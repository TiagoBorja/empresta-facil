<?php

include_once 'Connection.php';

class Subcategory
{

    private $id;
    private $subcategory;
    private $category;
    private $description;
    private $active;

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

    public function getAll()
    {
        $query = "SELECT sub.*, cat.categoria
                  FROM " . $this->tableName . " sub
                  INNER JOIN categoria cat ON sub.categoria_fk = cat.id";
        $query_run = $this->pdo->prepare($query);

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
        $query = "SELECT sub.id, cat.id AS categoria_id, cat.categoria, sub.subcategoria, sub.descricao, sub.ativo
                  FROM " . $this->tableName . " sub
                  INNER JOIN categoria cat ON sub.categoria_fk = cat.id
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

        $query = "INSERT INTO subcategoria (categoria_fk, subcategoria, descricao) VALUES (:category, :subcategory, :description)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':subcategory', $this->subcategory);
        $stmt->bindParam(':description', $this->description);

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
                  SET categoria_fk = :category, subcategoria = :subcategory, descricao = :description
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', var: $this->id);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':subcategory', $this->subcategory);
        $stmt->bindParam(':description', $this->description);

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