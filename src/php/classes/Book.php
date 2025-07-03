<?php

include_once 'Connection.php';
include_once 'AuthorBook.php';

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
    private $authorFk;
    private $subcategoryFk;
    private $active;
    public $authorBook;

    private $pdo;
    private $tableName = 'livro';

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();

        $this->authorBook = new AuthorBook();
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

        $query = "SELECT l.*, e.editora, c.categoria, s.subcategoria
                  FROM " . $this->tableName . " l
                  INNER JOIN editora e ON l.editora_fk = e.id
                  INNER JOIN categoria c ON l.categoria_fk = c.id
                  INNER JOIN subcategoria s ON l.subcategoria_fk = s.id";
        $query_run = $this->pdo->prepare($query);

        try {
            $query_run->execute();
            $value = $query_run->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($value);
        } catch (PDOException $e) {
            return json_encode($e->getMessage());
        }
    }

    public function getNewBooks()
    {
        $query = "SELECT l.*, e.editora, c.categoria, s.subcategoria
        FROM " . $this->tableName . " l
        INNER JOIN editora e ON l.editora_fk = e.id
        INNER JOIN categoria c ON l.categoria_fk = c.id
        INNER JOIN subcategoria s ON l.subcategoria_fk = s.id
        ORDER BY l.criado_em DESC
        LIMIT 10";

        $query_run = $this->pdo->prepare($query);

        try {
            $query_run->execute();
            return $query_run->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    public function getById($id)
    {
        $this->id = $id;
        $query = "SELECT l.*, e.editora, c.categoria, s.subcategoria
                  FROM " . $this->tableName . " l
                  INNER JOIN editora e ON l.editora_fk = e.id
                  INNER JOIN categoria c ON l.categoria_fk = c.id
                  INNER JOIN subcategoria s ON l.subcategoria_fk = s.id
                  WHERE l.id = :id";
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
    public function getMostRequested()
    {
        $query = "SELECT 
                    l.*, e.editora, c.categoria, s.subcategoria,
                    COUNT(el.emprestimo_fk) AS total_emprestimos
                FROM 
                    {$this->tableName} l
                JOIN livro_localizacao ll ON l.id = ll.livro_fk
                JOIN emprestimo_livro el ON ll.id = el.livro_localizacao_fk
                JOIN editora e ON l.editora_fk = e.id
                JOIN categoria c ON l.categoria_fk = c.id
                JOIN subcategoria s ON l.subcategoria_fk = s.id
                GROUP BY 
                    l.id, l.titulo
                ORDER BY 
                    total_emprestimos DESC
                LIMIT 10";

        $stmt = $this->pdo->prepare($query);

        try {
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }
    public function create($authors = [])
    {

        if (
            empty($this->title) || empty($this->isbn) || empty($this->releaseYear) ||
            empty($this->synopsis) || empty($this->language) ||
            empty($this->publisherFk) || empty($this->categoryFk) || empty($this->subcategoryFk)
        ) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos obrigatórios antes de prosseguir."
            ]);
        }

        $checkQuery = "SELECT COUNT(*) FROM " . $this->tableName . " 
                       WHERE titulo = :title
                       AND isbn = :isbn
                       AND idioma = :language";
        $checkStmt = $this->pdo->prepare($checkQuery);
        $checkStmt->bindParam(':title', $this->title);
        $checkStmt->bindParam(':isbn', $this->isbn);
        $checkStmt->bindParam(':language', $this->language);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() > 0) {
            return json_encode([
                'status' => 409,
                'message' => "Já existe um livro com este ISBN."
            ]);
        }

        $query = "INSERT INTO " . $this->tableName . " (
                titulo, isbn, ano_lancamento, sinopse, idioma, 
                editora_fk, categoria_fk, subcategoria_fk
                ) VALUES (
                    :title, :isbn, :releaseYear, :synopsis, :language, 
                    :publisherFk, :categoryFk, :subcategoryFk
                )";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':isbn', $this->isbn);
        $stmt->bindParam(':releaseYear', $this->releaseYear);
        $stmt->bindParam(':synopsis', $this->synopsis);
        $stmt->bindParam(':language', $this->language);
        $stmt->bindParam(':publisherFk', $this->publisherFk);
        $stmt->bindParam(':categoryFk', $this->categoryFk);
        $stmt->bindParam(':subcategoryFk', $this->subcategoryFk);

        try {
            $stmt->execute();
            $bookId = $this->pdo->lastInsertId();

            if (!empty($authors) && is_array($authors)) {
                foreach ($authors as $authorId) {
                    if (!empty($authorId)) {
                        $this->authorBook->setBook($bookId);
                        $this->authorBook->setAuthor($authorId);
                        $authorResult = $this->authorBook->create();

                        $authorResponse = json_decode($authorResult, true);
                        if ($authorResponse['status'] != 200) {
                            return $authorResult;
                        }
                    }
                }
            }

            return json_encode([
                'status' => 200,
                'message' => "Livro criado com sucesso.",
                'bookId' => $bookId
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao inserir: " . $e->getMessage()
            ]);
        }
    }


    public function update($id, $newAuthors = [])
    {
        $this->id = $id;

        if (empty($this->title) || empty($this->isbn) || empty($this->releaseYear)) {
            return json_encode([
                'status' => 422,
                'message' => "Por favor, preencha os campos título, ISBN e ano de lançamento."
            ]);
        }

        $checkQuery = "SELECT id FROM " . $this->tableName . " 
                       WHERE titulo = :title
                       AND isbn = :isbn
                       AND idioma = :language";
        $checkStmt = $this->pdo->prepare($checkQuery);
        $checkStmt->bindParam(':title', $this->title);
        $checkStmt->bindParam(':isbn', $this->isbn);
        $checkStmt->bindParam(':language', $this->language);
        $checkStmt->execute();

        $existing = $checkStmt->fetchColumn();

        if ($existing !== false && (int) $existing !== (int) $this->id) {
            return json_encode([
                'status' => 409,
                'message' => "Já existe um livro com este título."
            ]);
        }

        $query = "UPDATE " . $this->tableName . " SET
                titulo = :title,
                isbn = :isbn,
                ano_lancamento = :releaseYear,
                sinopse = :synopsis,
                idioma = :language,
                editora_fk = :publisherFk,
                categoria_fk = :categoryFk,
                subcategoria_fk = :subcategoryFk
              WHERE id = :id";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':isbn', $this->isbn);
        $stmt->bindParam(':releaseYear', $this->releaseYear);
        $stmt->bindParam(':synopsis', $this->synopsis);
        $stmt->bindParam(':language', $this->language);
        $stmt->bindParam(':publisherFk', $this->publisherFk);
        $stmt->bindParam(':categoryFk', $this->categoryFk);
        $stmt->bindParam(':subcategoryFk', $this->subcategoryFk);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();
            $this->updateAuthors($id, $newAuthors);
            return json_encode([
                'status' => 200,
                'message' => "Livro atualizado com sucesso."
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao atualizar o livro: " . $e->getMessage()
            ]);
        }
    }

    private function updateAuthors($bookId, $newAuthors)
    {
        try {
            $deleteQuery = "DELETE FROM autor_livro WHERE livro_fk = :bookId";
            $deleteStmt = $this->pdo->prepare($deleteQuery);
            $deleteStmt->bindParam(':bookId', $bookId);
            $deleteStmt->execute();

            if (!empty($newAuthors)) {
                foreach ($newAuthors as $authorId) {
                    $this->authorBook->setBook($bookId);
                    $this->authorBook->setAuthor($authorId);
                    $result = $this->authorBook->create();

                    $response = json_decode($result, true);
                    if ($response['status'] != 200) {
                        throw new Exception("Erro ao associar autor: " . $response['message']);
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar autores: " . $e->getMessage());
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

    public function getBookCount()
    {
        try {
            // Supondo que tens uma propriedade $this->pdo com a conexão PDO
            $sql = "SELECT COUNT(*) AS total FROM livro";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            $count = $stmt->fetch(PDO::FETCH_ASSOC);

            // Retorna JSON
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 200,
                'data' => $count['total']
            ]);
        } catch (PDOException $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 500,
                'error' => $e->getMessage()
            ]);
        }
    }
}
