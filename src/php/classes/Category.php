<?php

include_once 'Connection.php';

class Category
{
    private $id;
    private $category;
    private $description;

    private $active;
    private $createdFk;
    private $updatedFk;
    private $pdo;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getCreatedFk()
    {
        return $this->createdFk;
    }

    public function setCreatedFk($createdFk)
    {
        $this->createdFk = $createdFk;
    }
    public function getUpdatedFk()
    {
        return $this->updatedFk;
    }

    public function setUpdatedFk($updatedFk)
    {
        $this->updatedFk = $updatedFk;
    }

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    public function getAll($onlyActive = false, $returnedId = null)
    {
        $query = "SELECT * FROM categoria";

        if ($onlyActive) {
            if ($returnedId !== null) {
                $query .= " WHERE ativo = 'Y' OR id = :returnedId";
            } else {
                $query .= " WHERE ativo = 'Y'";
            }
        }

        $query_run = $this->pdo->prepare($query);

        if ($onlyActive && $returnedId !== null) {
            $query_run->bindParam(':returnedId', $returnedId, PDO::PARAM_INT);
        }

        try {
            $query_run->execute();
            $category = $query_run->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($category);
        } catch (PDOException $e) {
            return json_encode(['error' => 'Erro ao buscar categorias', 'details' => $e->getMessage()]);
        }
    }

    public function getCategoryById($id)
    {
        $this->id = $id;
        $query = "SELECT c.*, 
                  CONCAT(u1.primeiro_nome, ' ', u1.ultimo_nome) AS criado_por, 
                  CONCAT(u2.primeiro_nome, ' ', u2.ultimo_nome) AS atualizado_por
                  FROM categoria c
                  LEFT JOIN utilizador u1 ON c.criado_fk = u1.id
                  LEFT JOIN utilizador u2 ON c.atualizado_fk = u2.id
                  WHERE c.id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Categoria encontrada.",
                    'data' => $result
                ]);
            } else {
                return json_encode([
                    'status' => 404,
                    'message' => "Categoria não encontrada."
                ]);
            }
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao encontrar: " . $e->getMessage()
            ]);
        }
    }

    public function newCategory()
    {
        if (empty($this->category && $this->description)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "INSERT INTO categoria (categoria, descricao, criado_fk) VALUES (:category, :description, :createdFk)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':createdFk', $this->createdFk);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Categoria criada com sucesso."
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao inserir: " . $e->getMessage()
            ]);
        }
    }

    public function updateCategory($id)
    {

        $this->id = $id;

        if (empty($this->category && $this->description)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "UPDATE categoria 
                  SET categoria = :category, 
                  descricao = :description,
                  atualizado_fk = :updatedFk
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', var: $this->id);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':updatedFk', $this->updatedFk);

        try {

            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Estado atualizado com sucesso."
            ]);
        } catch (PDOException $e) {

            return json_encode(value: [
                'status' => 500,
                'message' => "Erro ao atualizar: " . $e->getMessage()
            ]);
        }
    }

    public function changeActiveStatus($id, $status)
    {
        $this->id = $id;
        $this->active = $status;

        $query = 'UPDATE categoria
                  SET ativo = :active
                  WHERE id = :id';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':active', $this->active);

        try {

            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Status atualizado com sucesso!"
            ]);
        } catch (PDOException $e) {

            return json_encode(value: [
                'status' => 500,
                'message' => "Erro ao atualizar: " . $e->getMessage()
            ]);
        }
    }
}