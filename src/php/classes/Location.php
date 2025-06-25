<?php
include_once 'Connection.php';
class Location
{
    private $id;
    private $locationCode;
    private $library;
    private $active;
    private $pdo;
    private $tableName = 'localizacao';
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

    public function getLocationCode()
    {
        return $this->locationCode;
    }

    public function setLocationCode($locationCode)
    {
        $this->locationCode = $locationCode;
    }

    public function getLibrary()
    {
        return $this->library;
    }

    public function setLibrary($library)
    {
        $this->library = $library;
    }
    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }
    public function getAll($onlyActive = false, $libraryFk = null)
    {
        $query = "SELECT l.*, b.nome
              FROM " . $this->tableName . " l 
              INNER JOIN biblioteca b ON l.biblioteca_fk = b.id";

        // Só adiciona WHERE se libraryFk for diferente de null ou se onlyActive for true
        $conditions = [];

        if ($libraryFk !== null) {
            $conditions[] = "l.biblioteca_fk = :libraryFk";
        }

        if ($onlyActive) {
            $conditions[] = "l.ativo = 'Y'";
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $query .= " ORDER BY b.nome, l.cod_local ASC";

        $query_run = $this->pdo->prepare($query);

        if ($libraryFk !== null) {
            $query_run->bindParam(':libraryFk', $libraryFk);
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
                    'message' => "Localização encontrado.",
                    'data' => $result
                ]);
            } else {
                return json_encode([
                    'status' => 404,
                    'message' => "Localização não encontrado."
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
        if (empty($this->locationCode && $this->library)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $existsLocationCode = "SELECT COUNT(*) FROM " . $this->tableName . " 
                   WHERE cod_local = :locationCode AND biblioteca_fk = :library";
        $checkLocationCode = $this->pdo->prepare($existsLocationCode);
        $checkLocationCode->bindParam(':locationCode', $this->locationCode);
        $checkLocationCode->bindParam(':library', $this->library);
        $checkLocationCode->execute();

        if ($checkLocationCode->fetchColumn() > 0) {
            return json_encode([
                'status' => 409,
                'message' => "Já existe um código de localização com esse nome para esta biblioteca."
            ]);
        }

        $query = "INSERT INTO " . $this->tableName . " (cod_local, biblioteca_fk) VALUES (:locationCode, :library)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':locationCode', $this->locationCode);
        $stmt->bindParam(':library', $this->library);

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

        if (empty($this->locationCode && $this->library)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $checkoQuery = "SELECT id FROM " . $this->tableName . " 
                   WHERE cod_local = :locationCode AND biblioteca_fk = :library;";

        $checkStmt = $this->pdo->prepare($checkoQuery);
        $checkStmt->bindParam(':locationCode', $this->locationCode);
        $checkStmt->bindParam(':library', $this->library);
        $checkStmt->execute();

        $existingId = $checkStmt->fetchColumn();
        if ($existingId > 0 && $existingId !== $this->id) {
            return json_encode([
                'status' => 409,
                'message' => "Já existe um código de localização com esse nome para esta biblioteca."
            ]);
        }

        $query = "UPDATE " . $this->tableName . " 
                  SET cod_local = :locationCode, biblioteca_fk = :library
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', var: $this->id);
        $stmt->bindParam(':locationCode', $this->locationCode);
        $stmt->bindParam(':library', $this->library);

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