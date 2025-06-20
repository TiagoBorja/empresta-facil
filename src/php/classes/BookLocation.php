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

    public function getAll()
    {

        $query = "SELECT l.*, ll.id as livro_localizacao_fk, loc.cod_local, ll.quantidade
                  FROM {$this->tableName} b
                  INNER JOIN localizacao loc ON loc.biblioteca_fk = b.id
                  INNER JOIN livro_localizacao ll ON ll.localizacao_fk = loc.id
                  INNER JOIN livro l ON ll.livro_fk = l.id
                  WHERE ll.quantidade > 0";
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
        $query = "SELECT l.*, ll.id as livro_localizacao_fk, loc.cod_local, ll.quantidade
                  FROM {$this->tableName} b
                  INNER JOIN localizacao loc ON loc.biblioteca_fk = b.id
                  INNER JOIN livro_localizacao ll ON ll.localizacao_fk = loc.id
                  INNER JOIN livro l ON ll.livro_fk = l.id 
                  WHERE ll.id = :id
                  AND ll.quantidade > 0";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
