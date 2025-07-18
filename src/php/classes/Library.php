<?php

include_once 'Connection.php';

class Library
{

    private $id;
    private $name;
    private $email;
    private $address;
    private $postalCode;
    private $active;
    private $createdFk;
    private $updatedFk;

    private $pdo;
    private $tableName = 'biblioteca';
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getAdress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
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
    public function getAll($onlyActive = false)
    {
        $query = "SELECT *
                  FROM " . $this->tableName;

        if ($onlyActive) {
            $query .= " WHERE ativo = 'Y'";
        }
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
        $query = "SELECT 
                    b.*,
                    CONCAT(u1.primeiro_nome, ' ', u1.ultimo_nome) AS criado_por, 
                    CONCAT(u2.primeiro_nome, ' ', u2.ultimo_nome) AS atualizado_por
                  FROM {$this->tableName} b
                  LEFT JOIN utilizador u1 ON b.criado_fk = u1.id
                  LEFT JOIN utilizador u2 ON b.atualizado_fk = u2.id
                  WHERE b.id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Biblioteca encontrado.",
                    'data' => [$result]
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
    public function getLibraryDataById($libraryId)
    {
        $query = "SELECT nome, morada FROM {$this->tableName} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $libraryId]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna ['nome' => ..., 'morada' => ...]
    }

    public function getLibraryDataByIds(array $libraryIds): array
    {
        if (empty($libraryIds)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($libraryIds), '?'));
        $query = "SELECT nome, morada FROM {$this->tableName} WHERE id IN ($placeholders)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($libraryIds);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create()
    {
        if (empty($this->name) || empty($this->email) || empty($this->address) || empty($this->postalCode)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "INSERT INTO " . $this->tableName . " (nome, email, morada, cod_postal, criado_fk) VALUES (:name, :email, :address, :postalCode, :createdFk)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':postalCode', $this->postalCode);
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

        if (empty($this->name && $this->address && $this->postalCode)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "UPDATE " . $this->tableName . " 
                  SET nome = :name,
                  email = :email,
                  morada = :address, 
                  cod_postal = :postalCode,
                  atualizado_fk = :updatedFk
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', var: $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':postalCode', $this->postalCode);
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