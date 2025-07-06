<?php

include_once 'Connection.php';

class Evaluation
{
    private $id;
    private $bookFk;
    private $userFk;
    private $rate;
    private $pdo;
    private $tableName = 'avaliacoes';

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

    public function getRate()
    {
        return $this->rate;
    }
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    public function create()
    {
        if (empty($this->rate)) {
            return json_encode([
                'status' => 409,
                'message' => 'Insira um texto válido'
            ]);
        }


        $query = "INSERT INTO {$this->tableName} 
                (livro_fk, utilizador_fk, avaliacao)
                VALUES (:bookFk, :userFk, :rate)";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':bookFk', $this->bookFk);
        $stmt->bindParam(':userFk', $this->userFk);
        $stmt->bindParam(':rate', $this->rate);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Comentário criado com sucesso!",
            ]);

        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao inserir: " . $e->getMessage()
            ]);
        }
    }

    public function update()
    {
        $query = "UPDATE {$this->tableName} 
              SET avaliacao = :evaluation
              WHERE livro_fk = :bookFk AND utilizador_fk = :userFk";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':evaluation', $this->rate); // este estava em falta
        $stmt->bindParam(':bookFk', $this->bookFk);
        $stmt->bindParam(':userFk', $this->userFk);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Avaliação atualizada com sucesso."
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao atualizar: " . $e->getMessage()
            ]);
        }
    }
    public function exists()
    {
        $query = "SELECT COUNT(*) FROM {$this->tableName} 
              WHERE livro_fk = :bookFk AND utilizador_fk = :userFk";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':bookFk', $this->bookFk);
        $stmt->bindParam(':userFk', $this->userFk);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }
    public function getEvaluationsByBookId($bookFk)
    {
        $query = "SELECT 
                    l.titulo,
                    a.avaliacao,
                    a.criado_em,
                    CONCAT(u.primeiro_nome, ' ', u.ultimo_nome) AS utilizador,
                    u.img_url
                FROM avaliacoes a
                JOIN utilizador u ON a.utilizador_fk = u.id
                JOIN livro l ON a.livro_fk = l.id 
                WHERE a.livro_fk = :bookFk
                ORDER BY a.criado_em ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':bookFk', $bookFk);

        try {
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Avaliações encontrada.",
                    'data' => $result
                ]);
            }

            return json_encode([
                'status' => 404,
                'message' => "Avaliações não encontrados.",
                'data' => []
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao encontrar: " . $e->getMessage()
            ]);
        }
    }
    public function getBookEvalutionByUserId($userFk, $bookFk)
    {
        $query = "SELECT         
                    a.avaliacao
                FROM avaliacoes a
                JOIN utilizador u ON a.utilizador_fk = u.id
                JOIN livro l ON a.livro_fk = l.id 
                WHERE a.livro_fk = :bookFk
                AND a.utilizador_fk = :userFk
                ORDER BY a.criado_em ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userFk', $userFk);
        $stmt->bindParam(':bookFk', $bookFk);

        try {
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Avaliações encontrada.",
                    'data' => $result
                ]);
            }

            return json_encode([
                'status' => 404,
                'message' => "Avaliações não encontrados.",
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
