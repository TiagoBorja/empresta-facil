<?php

include_once 'Connection.php';
include_once 'Location.php';
include_once 'Book.php';
class BookLocation
{
    private $id;
    private $bookFk;
    private $locationFk;
    private $quantity;

    private $pdo;
    private $tableName = 'biblioteca';

    public function __construct(Book $book = null, Location $location = null)
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
    public function getBookFk()
    {
        return $this->bookFk;
    }

    public function setBookFk($bookFk)
    {
        $this->bookFk = $bookFk;
    }

    public function getLocationFk()
    {
        return $this->locationFk;
    }

    public function setLocationFk($locationFk)
    {
        $this->locationFk = $locationFk;
    }


    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function getQuantity()
    {
        return $this->quantity;
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
                  INNER JOIN funcionario e ON e.biblioteca_fk = b.id
                  WHERE ll.livro_fk = :id
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


    public function getBookStockById($bookId)
    {

        $query = "SELECT 
                    b.id AS biblioteca_fk,
                    ll.id AS livro_localizacao_fk,
                    b.morada,
                    b.nome AS biblioteca,
                    SUM(ll.quantidade) AS total_exemplares
                FROM livro_localizacao ll
                INNER JOIN localizacao loc ON ll.localizacao_fk = loc.id
                INNER JOIN biblioteca b ON loc.biblioteca_fk = b.id
                WHERE ll.livro_fk = :bookId
                GROUP BY b.id, b.nome";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':bookId', $bookId);

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
    public function create()
    {
        $query = "INSERT INTO livro_localizacao
                (livro_fk, localizacao_fk, quantidade)
                VALUES (:bookFk, :locationFk, :quantity)";

        $bookFk = $this->getBookFk();
        $locationFk = $this->getLocationFk();
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':bookFk', $bookFk);
        $stmt->bindParam(':locationFk', $locationFk);
        $stmt->bindParam(':quantity', $this->quantity);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Livro Localização criado com sucesso!",
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
        $query = "UPDATE livro_localizacao
              SET livro_fk = :bookFk,
                  localizacao_fk = :locationFk,
                  quantidade = :quantity
              WHERE id = :id";

        $bookFk = $this->getBookFk();
        $locationFk = $this->getLocationFk();
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':bookFk', $bookFk);
        $stmt->bindParam(':locationFk', $locationFk);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Livro Localização atualizado com sucesso!",
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao atualizar: " . $e->getMessage()
            ]);
        }
    }
}
