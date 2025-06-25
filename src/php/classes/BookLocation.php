<?php

include_once 'Connection.php';

class BookLocation
{
    private $id;
    private $quantity;

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

    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getAll($libraryFk = null)
    {
        $query = "SELECT 
                l.*, ll.id as livro_localizacao_fk, 
                b.nome AS biblioteca,
                loc.cod_local, 
                ll.quantidade
              FROM {$this->tableName} b
              INNER JOIN localizacao loc ON loc.biblioteca_fk = b.id
              INNER JOIN livro_localizacao ll ON ll.localizacao_fk = loc.id
              INNER JOIN livro l ON ll.livro_fk = l.id
              WHERE ll.quantidade > 0";

        if ($libraryFk === null) {
            if (isset($_SESSION['employee']) && !empty($_SESSION['employee']['biblioteca_fk'])) {
                $libraryFk = $_SESSION['employee']['biblioteca_fk'];
            }
        }

        if ($libraryFk !== null && $libraryFk !== false && $libraryFk !== '') {
            $query .= " AND b.id = :libraryFk";
        }

        $query_run = $this->pdo->prepare($query);

        if ($libraryFk !== null && $libraryFk !== false && $libraryFk !== '') {
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
        $query = "SELECT 
                    l.*, 
                    b.id as biblioteca_fk,
                    b.nome, 
                    b.morada, 
                    ll.id as livro_localizacao_fk, 
                    loc.id as loc_fk,
                    loc.cod_local, ll.quantidade,
                    e.biblioteca_fk as biblioteca_utilizador_fk
                  FROM {$this->tableName} b
                  INNER JOIN localizacao loc ON loc.biblioteca_fk = b.id
                  INNER JOIN livro_localizacao ll ON ll.localizacao_fk = loc.id
                  INNER JOIN livro l ON ll.livro_fk = l.id 
                  LEFT JOIN funcionario e ON e.biblioteca_fk = b.id
                  WHERE ll.id = :id
                  AND ll.quantidade > 0";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return json_encode([
                'status' => 200,
                'data' => $result
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao encontrar: " . $e->getMessage()
            ]);
        }
    }
}
