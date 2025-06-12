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
        $query = "SELECT al.id as autor_livro_id, CONCAT(a.primeiro_nome, ' ', a.ultimo_nome) AS nome_completo, 
                  l.titulo FROM " . $this->tableName . "
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

    public function getAuthorsByBookId($bookId)
    {
        $query = "SELECT al.autor_fk,
        CONCAT(a.primeiro_nome, ' ', a.ultimo_nome) AS nome_completo
              FROM autor_livro al
              INNER JOIN autor a ON al.autor_fk = a.id
              WHERE al.livro_fk = :bookId";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Autores encontrados.",
                    'data' => $result
                ]);
            } else {
                return json_encode([
                    'status' => 404,
                    'message' => "Nenhum autor encontrado para este livro."
                ]);
            }
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao buscar autores: " . $e->getMessage()
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
}