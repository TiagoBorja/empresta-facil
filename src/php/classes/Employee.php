<?php

include_once 'Connection.php';

class Employee
{
    private $pdo;
    private $tableName = 'funcionario';
    private $id;
    private $userFk;
    private $libraryFk;
    private $active;

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

    public function getUserFk()
    {
        return $this->userFk;
    }

    public function setUserFk($userFk)
    {
        $this->userFk = $userFk;
    }

    public function getLibraryFk()
    {
        return $this->libraryFk;
    }

    public function setLibraryFk($libraryFk)
    {
        $this->libraryFk = $libraryFk;
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
        $query = "SELECT
                    f.id,
                    u.primeiro_nome, 
                    u.ultimo_nome, 
                    b.nome AS biblioteca, 
                    t.tipo AS permissao,
                    f.ativo
                FROM {$this->tableName} f
                INNER JOIN utilizador u ON f.utilizador_fk = u.id
                LEFT JOIN biblioteca b ON f.biblioteca_fk = b.id
                INNER JOIN tipo_utilizador t ON u.tipo_utilizador_fk = t.id";
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
        $query = "SELECT f.id, 
            CONCAT(u.primeiro_nome, ' ', u.ultimo_nome) AS nome_completo,
            f.utilizador_fk,
            f.biblioteca_fk,
            b.nome as biblioteca_nome,
            f.ativo
            FROM {$this->tableName} f
            JOIN utilizador u ON f.utilizador_fk = u.id
            JOIN biblioteca b ON f.biblioteca_fk = b.id
            WHERE f.id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Autor encontrado.",
                    'data' => $result
                ]);
            } else {
                return json_encode([
                    'status' => 404,
                    'message' => "Autor não encontrado."
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
        if (empty($this->userFk)) {
            return json_encode([
                'status' => 409,
                'message' => 'Preencha todos os campos antes de prosseguir.'
            ]);
        }


        $query = "INSERT INTO {$this->tableName} 
                (utilizador_fk, biblioteca_fk)
                VALUES (:userFk, :libraryFk)";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userFk', $this->userFk);
        $stmt->bindParam(':libraryFk', $this->libraryFk);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Funcionário criado com sucesso!",
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

        if (empty($this->userFk)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "UPDATE {$this->tableName} 
              SET utilizador_fk = :userFk, biblioteca_fk = :libraryFk
              WHERE id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':userFk', $this->userFk);
        $stmt->bindParam(':libraryFk', $this->libraryFk);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Funcionário atualizado com sucesso."
            ]);
        } catch (PDOException $e) {
            return json_encode([
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
