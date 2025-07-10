<?php

include_once 'Connection.php';

class Subcategory
{

    private $id;
    private $subcategory;
    private $category;
    private $description;
    private $active;
    private $createdFk;
    private $updatedFk;
    private $pdo;
    private $tableName = 'subcategoria';
    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getSubcategory()
    {
        return $this->subcategory;
    }

    public function setSubcategory($subcategory)
    {
        $this->subcategory = $subcategory;
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

    public function getAll($onlyActive = false, $returnedId = null)
    {
        $query = "SELECT sub.*, cat.categoria
                  FROM " . $this->tableName . " sub
                  INNER JOIN categoria cat ON sub.categoria_fk = cat.id";

        if ($onlyActive) {
            if ($returnedId) {
                $query .= " WHERE sub.ativo = 'Y' OR sub.id = :returnedId";
            } else {
                $query .= " WHERE sub.ativo = 'Y'";
            }
        }

        $query_run = $this->pdo->prepare($query);

        if ($onlyActive && $returnedId) {
            $query_run->bindParam(':returnedId', $returnedId, PDO::PARAM_INT);
        }

        try {
            $query_run->execute();
            $value = $query_run->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($value);
        } catch (PDOException $e) {
            return json_encode($e->getMessage());
        }
    }


    public function getById($id)
    {
        $this->id = $id;
        $query = "SELECT                    
                    sub.*, 
                    cat.categoria, 
                    CONCAT(u1.primeiro_nome, ' ', u1.ultimo_nome) AS criado_por, 
                    CONCAT(u2.primeiro_nome, ' ', u2.ultimo_nome) AS atualizado_por
                FROM " . $this->tableName . " sub
                INNER JOIN categoria cat ON sub.categoria_fk = cat.id
                LEFT JOIN utilizador u1 ON sub.criado_fk = u1.id
                LEFT JOIN utilizador u2 ON sub.atualizado_fk = u2.id
                WHERE sub.id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Utilizador encontrado.",
                    'data' => $result
                ]);
            } else {
                return json_encode([
                    'status' => 404,
                    'message' => "Utilizador não encontrado."
                ]);
            }
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao encontrar: " . $e->getMessage()
            ]);
        }
    }
    public function create()
    {
        if (empty($this->category && $this->subcategory && $this->description)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "INSERT INTO subcategoria (categoria_fk, subcategoria, descricao, criado_fk) 
                  VALUES (:category, :subcategory, :description, :createdFk)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':subcategory', $this->subcategory);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':createdFk', $this->createdFk);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Subcategoria criada com sucesso."
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao inserir: " . $e->getMessage()
            ]);
        }
    }

    public function update($id)
    {

        $this->id = $id;

        if (empty($this->category && $this->subcategory && $this->description)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "UPDATE " . $this->tableName . " 
                  SET categoria_fk = :category, 
                  subcategoria = :subcategory, 
                  descricao = :description,
                  atualizado_fk = :updatedFk
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', var: $this->id);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':subcategory', $this->subcategory);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':updatedFk', $this->updatedFk);

        try {

            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Subcategoria atualizado com sucesso."
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

        $query = 'UPDATE subcategoria
                  SET ativo = :active,
                  atualizado_fk = :updatedFk
                  WHERE id = :id';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':active', $this->active);
        $stmt->bindParam(':updatedFk', $this->updatedFk);

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