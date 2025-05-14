<?php

include_once 'Connection.php';

class Category
{
    private $id;
    private $category;
    private $description;

    private $active;

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

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    public function getCategories()
    {
        $query = "SELECT * FROM categoria";
        $query_run = $this->pdo->prepare($query);

        try {

            $query_run->execute();
            $category = $query_run->fetchAll(PDO::FETCH_ASSOC);

            if (count($category) < 1)
                echo "<tr><td colspan='3'>Sem resultados</td></tr>";

            return json_encode($category);
        } catch (PDOException $e) {
            echo "<tr><td colspan='3'>Sem resultados</td></tr>";
        }
    }

    public function getCategoryById($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM categoria WHERE id = :id";
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

        $query = "INSERT INTO categoria (categoria, descricao) VALUES (:category, :description)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':description', $this->description);

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
                  SET categoria = :category, descricao = :description
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', var: $this->id);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':description', $this->description);

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