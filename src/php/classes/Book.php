<?php

include_once 'Connection.php';

class Book
{
    private $id;
    private $title;
    private $isbn;
    private $releaseYear;
    private $synopsis;
    private $language;
    private $quantity;
    private $resourceType;
    private $publisherFk;
    private $categoryFk;
    private $subcategoryFk;
    private $locationFk;
    private $stateFk;
    private $active;

    private $pdo;
    private $tableName = 'livro';

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

    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }

    public function getReleaseYear()
    {
        return $this->releaseYear;
    }
    public function setReleaseYear($releaseYear)
    {
        $this->releaseYear = $releaseYear;
    }

    public function getSynopsis()
    {
        return $this->synopsis;
    }
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;
    }

    public function getLanguage()
    {
        return $this->language;
    }
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function getPublisher()
    {
        return $this->publisherFk;
    }
    public function setPublisher($publisherFk)
    {
        $this->publisherFk = $publisherFk;
    }

    public function getCategory()
    {
        return $this->categoryFk;
    }
    public function setCategory($categoryFk)
    {
        $this->categoryFk = $categoryFk;
    }

    public function getSubcategory()
    {
        return $this->subcategoryFk;
    }
    public function setSubcategory($subcategoryFk)
    {
        $this->subcategoryFk = $subcategoryFk;
    }

    public function getLocation()
    {
        return $this->locationFk;
    }
    public function setLocation($locationFk)
    {
        $this->locationFk = $locationFk;
    }

    public function getState()
    {
        return $this->stateFk;
    }
    public function setState($stateFk)
    {
        $this->stateFk = $stateFk;
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
                    l.*, 
                    b.nome AS nome_biblioteca, 
                    lc.cod_local
                  FROM " . $this->tableName . " l
                    INNER JOIN localizacao lc ON l.localizacao_fk = lc.id
                    INNER JOIN biblioteca b ON lc.biblioteca_fk = b.id
                  ORDER BY b.nome, l.titulo";
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
                    l.*, 
                    b.nome AS nome_biblioteca, 
                    lc.cod_local
                  FROM " . $this->tableName . " l
                    INNER JOIN localizacao lc ON l.localizacao_fk = lc.id
                    INNER JOIN biblioteca b ON lc.biblioteca_fk = b.id
                  WHERE id = : id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Livro criado.",
                    'data' => $result
                ]);
            } else {
                return json_encode([
                    'status' => 404,
                    'message' => "Livro criado encontrado."
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
        if (
            empty($this->title) || empty($this->isbn) || empty($this->releaseYear) ||
            empty($this->synopsis) || empty($this->language) || empty($this->quantity) ||
            empty($this->publisherFk) || empty($this->categoryFk) || empty($this->subcategoryFk) ||
            empty($this->locationFk) || empty($this->stateFk)
        ) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos obrigatórios antes de prosseguir."
            ]);
        }

        $checkQuery = "SELECT COUNT(*) FROM " . $this->tableName . " WHERE isbn = :isbn";
        $checkStmt = $this->pdo->prepare($checkQuery);
        $checkStmt->bindParam(':isbn', $this->isbn);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() > 0) {
            return json_encode([
                'status' => 409,
                'message' => "Já existe um livro com este ISBN."
            ]);
        }

        $query = "INSERT INTO " . $this->tableName . " (
        titulo, isbn, ano_lancamento, sinopse, idioma, quantidade, 
        editora_fk, categoria_fk, subcategoria_fk, localizacao_fk, estado_fk, ativo
    ) VALUES (
        :title, :isbn, :releaseYear, :synopsis, :language, :quantity, 
        :publisherFk, :categoryFk, :subcategoryFk, :locationFk, :stateFk, :active
    )";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':isbn', $this->isbn);
        $stmt->bindParam(':releaseYear', $this->releaseYear);
        $stmt->bindParam(':synopsis', $this->synopsis);
        $stmt->bindParam(':language', $this->language);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':publisherFk', $this->publisherFk);
        $stmt->bindParam(':categoryFk', $this->categoryFk);
        $stmt->bindParam(':subcategoryFk', $this->subcategoryFk);
        $stmt->bindParam(':locationFk', $this->locationFk);
        $stmt->bindParam(':stateFk', $this->stateFk);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Livro criado com sucesso."
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

        if (empty($this->type) && empty($this->description)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $checkQuery = "SELECT id FROM " . $this->tableName . " 
                       WHERE tipo = :type";

        $checkStmt = $this->pdo->prepare($checkQuery);
        $checkStmt->bindParam(':type', $this->type);
        $checkStmt->execute();

        $existing = $checkStmt->fetchColumn();
        if ($existing > 0 && $existing !== (int) $this->id) {
            return json_encode([
                'status' => 409,
                'message' => "Já existe uma Livro criado esse nome."
            ]);
        }

        $query = "UPDATE " . $this->tableName . " 
                  SET tipo = :type,
                  descricao = :description
                  WHERE id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', var: $this->id);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':description', $this->description);

        try {

            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Livro atualizado com sucesso."
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
