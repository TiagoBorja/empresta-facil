<?php

include_once 'Connection.php';

class Comments
{
    private $id;
    private $bookFk;
    private $userFk;
    private $comment;
    private $pdo;
    private $tableName = 'comentarios';

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getBookFk()
    {
        return $this->bookFk;
    }
    public function setBookFk($bookFk)
    {
        $this->bookFk = $bookFk;
    }
    public function getUserFk()
    {
        return $this->userFk;
    }
    public function setUserFk($userFk)
    {
        $this->userFk = $userFk;
    }

    public function getComment()
    {
        return $this->comment;
    }
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    public function getCommentsByBookId($bookFk)
    {
        $query = "SELECT 
                    l.titulo,
                    c.comentario,
                    c.criado_em,
                    CONCAT(u.primeiro_nome, ' ', u.ultimo_nome) AS utilizador,
                    u.img_url
                FROM {$this->tableName} c
                JOIN utilizador u ON c.utilizador_fk = u.id
                JOIN livro l ON c.livro_fk = l.id 
                WHERE c.livro_fk = :bookFk
                ORDER BY c.criado_em ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':bookFk', $bookFk);

        try {
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Comentários encontrada.",
                    'data' => $result
                ]);
            }

            return json_encode([
                'status' => 404,
                'message' => "Comentários não encontrados.",
                'data' => []
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao encontrar: " . $e->getMessage()
            ]);
        }
    }
}
