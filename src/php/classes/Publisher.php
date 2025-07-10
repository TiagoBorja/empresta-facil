<?php

include_once 'Connection.php';

class Publisher
{

    private $id;
    private $publisher;
    private $active;
    private $createdFk;
    private $updatedFk;

    private $pdo;
    private $tableName = 'editora';
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

    public function getPublisher()
    {
        return $this->publisher;
    }

    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
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
        $query = "SELECT * FROM " . $this->tableName;

        if ($onlyActive) {
            if ($returnedId) {
                $query .= " WHERE ativo = 'Y' OR id = :returnedId";
            } else {
                $query .= " WHERE ativo = 'Y'";
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
                    e.*,
                    CONCAT(u1.primeiro_nome, ' ', u1.ultimo_nome) AS criado_por,
                    CONCAT(u2.primeiro_nome, ' ', u2.ultimo_nome) AS atualizado_por
                FROM editora e
                LEFT JOIN utilizador u1 ON e.criado_fk = u1.id
                LEFT JOIN utilizador u2 ON e.atualizado_fk = u2.id
                WHERE e.id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Editora encontrado.",
                    'data' => $result
                ]);
            } else {
                return json_encode([
                    'status' => 404,
                    'message' => "Editora não encontrado."
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
        if (empty($this->publisher)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $existsPublisher = "SELECT COUNT(*) FROM " . $this->tableName . " 
                   WHERE editora = :publisher";
        $checkStmt = $this->pdo->prepare($existsPublisher);
        $checkStmt->bindParam(':publisher', $this->publisher);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() > 0) {
            return json_encode([
                'status' => 409,
                'message' => "Já existe um código de Editora com esse nome para esta biblioteca."
            ]);
        }

        $query = "INSERT INTO {$this->tableName} (editora, criado_fk) VALUES (:publisher, :createdFk)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':publisher', $this->publisher);
        $stmt->bindParam(':createdFk', $this->createdFk);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Biblioteca criada com sucesso."
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

        if (empty($this->publisher)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $checkQuery = "SELECT id FROM " . $this->tableName . " 
                   WHERE editora = :publisher";

        $checkStmt = $this->pdo->prepare($checkQuery);
        $checkStmt->bindParam(':publisher', $this->publisher);
        $checkStmt->execute();

        $existingId = $checkStmt->fetchColumn();
        if ($existingId > 0 && $existingId !== $this->id) {
            return json_encode([
                'status' => 409,
                'message' => "Já existe uma editora com esse nome."
            ]);
        }

        $query = "UPDATE " . $this->tableName . " 
                  SET editora = :publisher,
                  atualizado_fk = :updatedFk
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', var: $this->id);
        $stmt->bindParam(':publisher', $this->publisher);
        $stmt->bindParam(':updatedFk', $this->updatedFk);

        try {

            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Biblioteca atualizado com sucesso."
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