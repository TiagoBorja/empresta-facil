<?php

include_once 'Connection.php';

class TypeResource
{

    private $id;
    private $type;
    private $description;
    private $active;

    private $pdo;
    private $tableName = 'tipo_recurso';
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

    public function getType()
    {
        return $this->id;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
    public function getDescription()
    {
        return $this->id;
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
        $query = "SELECT * FROM " . $this->tableName;
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
        $query = "SELECT *
                  FROM " . $this->tableName . "
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Tipo de recurso criado.",
                    'data' => $result
                ]);
            } else {
                return json_encode([
                    'status' => 404,
                    'message' => "Tipo de recurso criado encontrado."
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
        if (empty($this->type) && empty($this->description)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $checkQuery = "SELECT COUNT(*) FROM " . $this->tableName . " 
                   WHERE tipo = :type";
        $checkStmt = $this->pdo->prepare($checkQuery);
        $checkStmt->bindParam(':type', $this->type);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() > 0) {
            return json_encode([
                'status' => 409,
                'message' => "Já existe tipo de recurso com este nome."
            ]);
        }

        $query = "INSERT INTO " . $this->tableName .
            "(tipo, descricao) VALUES (:type, :description)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':description', $this->description);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Tipo de recurso criado com sucesso."
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

        if (empty($this->type) && empty($this->description)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $checkQuery = "SELECT id FROM " . $this->tableName . " 
                       WHERE tipo = :type";

        $checkStmt = $this->pdo->prepare($checkQuery);
        $checkStmt->bindParam(':type', $this->type);
        $checkStmt->execute();

        $existingId = $checkStmt->fetchColumn();
        if ($existingId > 0 && $existingId !== (int) $this->id) {
            return json_encode([
                'status' => 409,
                'message' => "Já existe uma tipo de recurso criado esse nome."
            ]);
        }

        $query = "UPDATE " . $this->tableName . " 
                  SET tipo = :type,
                  descricao = :description
                  WHERE id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', var: $this->id);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':description', $this->description);

        try {

            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Tipo de recurso atualizado com sucesso."
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

        $query = 'UPDATE ' . $this->tableName . '
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