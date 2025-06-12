<?php

include_once 'Connection.php';

class AuthorBook
{
    private $authorFk;
    private $bookFk;
    private $pdo;
    private $tableName = 'autor_livro';

    public function getAuthor()
    {
        return $this->authorFk;
    }
    public function setAuthor($authorFk)
    {
        $this->authorFk = $authorFk;
    }
    public function getBook()
    {
        return $this->bookFk;
    }
    public function setBook($bookFk)
    {
        $this->bookFk = $bookFk;
    }

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    public function getAll()
    {
        $query = "SELECT a.primeiro_nome, l.titulo FROM " . $this->tableName . "
                  INNER JOIN autor a ON al.autor_fk = a.id
                  INNER JOIN livro l ON al.livro_fk = l.id";
        $query_run = $this->pdo->prepare($query);

        try {

            $query_run->execute();
            $userRoles = $query_run->fetchAll(PDO::FETCH_ASSOC);

            if (count($userRoles) < 1)
                echo "<tr><td colspan='3'>Sem resultados</td></tr>";

            return json_encode($userRoles);
        } catch (PDOException $e) {
            echo "<tr><td colspan='3'>Sem resultados</td></tr>";
        }
    }

    public function getStateById($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM estado WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Estado encontrado.",
                    'data' => $result
                ]);
            } else {
                return json_encode([
                    'status' => 404,
                    'message' => "Estado não encontrado."
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
        if (empty($this->bookFk) && empty($this->bookFk)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "INSERT INTO " . $this->tableName . " (autor_fk, livro_fk) VALUES (:authorFk, :bookFk)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':authorFk', $this->authorFk);
        $stmt->bindParam(':bookFk', $this->bookFk);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Relação criada com sucesso."
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao inserir: " . $e->getMessage()
            ]);
        }
    }

    public function updateState($id)
    {

        $this->id = $id;

        if (empty($this->state)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "UPDATE estado 
                  SET estado = :state, observacoes = :observation
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', var: $this->id);
        $stmt->bindParam(':state', $this->state);
        $stmt->bindParam(':observation', $this->observation);

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
}