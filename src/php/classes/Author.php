<?php

include_once 'Connection.php';

class Author
{

    private $id;
    private $firstName;
    private $lastName;
    private $birthDay;
    private $gender;
    private $biography;
    private $nationality;
    private $imgUrl;
    private $active;
    private $createdFk;
    private $updatedFk;
    private $pdo;
    private $tableName = 'autor';
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

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    public function getBirthDay()
    {
        return $this->birthDay;
    }

    public function setBirthDay($birthDay)
    {
        $this->birthDay = $birthDay;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getBiography()
    {
        return $this->biography;
    }

    public function setBiography($biography)
    {
        $this->biography = $biography;
    }

    public function getNationality()
    {
        return $this->nationality;
    }

    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    }
    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    public function setImgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;
    }
    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getCreatedFk()
    {
        return $this->createdFk;
    }

    public function setCreatedFk($createdFk)
    {
        $this->createdFk = $createdFk;
    }
    public function getUpdatedFk()
    {
        return $this->updatedFk;
    }
    public function setUpdatedFk($updatedFk)
    {
        $this->updatedFk = $updatedFk;
    }
    public function getAll()
    {
        $query = "SELECT * FROM " . $this->tableName;
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
                    a.*,
                    CONCAT(u1.primeiro_nome, ' ', u1.ultimo_nome) AS criado_por, 
                    CONCAT(u2.primeiro_nome, ' ', u2.ultimo_nome) AS atualizado_por
                FROM {$this->tableName} a
                LEFT JOIN utilizador u1 ON a.criado_fk = u1.id
                LEFT JOIN utilizador u2 ON a.atualizado_fk = u2.id
                WHERE a.id = :id";
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
        if (empty($this->firstName) && empty($this->lastName) && empty($this->birthDay) && empty($this->biography) && empty($this->nationality)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "INSERT INTO " . $this->tableName .
            "(primeiro_nome, ultimo_nome, data_nascimento, genero, biografia, nacionalidade, img_url, criado_fk) 
                  VALUES (:firstName, :lastName, :birthDay, :gender, :biography, :nationality, :imgUrl, :createdFk)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':birthDay', $this->birthDay);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':biography', $this->biography);
        $stmt->bindParam(':nationality', $this->nationality);
        $stmt->bindParam(':imgUrl', $this->imgUrl);
        $stmt->bindParam(':createdFk', $this->createdFk);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Autor criada com sucesso."
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

        if (empty($this->firstName) && empty($this->lastName) && empty($this->birthDay) && empty($this->biography) && empty($this->nationality)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $checkQuery = "SELECT id FROM " . $this->tableName . " 
                       WHERE primeiro_nome = :firstName AND ultimo_nome = :lastName";

        $checkStmt = $this->pdo->prepare($checkQuery);
        $checkStmt->bindParam(':firstName', $this->firstName);
        $checkStmt->bindParam(':lastName', $this->lastName);
        $checkStmt->execute();

        $existingId = $checkStmt->fetchColumn();
        if ($existingId > 0 && $existingId !== (int) $this->id) {
            return json_encode([
                'status' => 409,
                'message' => "Já existe uma autor com esse nome."
            ]);
        }

        $query = "UPDATE " . $this->tableName . " 
                  SET primeiro_nome = :firstName,
                  ultimo_nome = :lastName,
                  data_nascimento = :birthDay,
                  genero = :gender,
                  biografia = :biography,
                  nacionalidade = :nationality,
                  img_url = :imgUrl,
                  atualizado_fk = :updatedFk
                  WHERE id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', var: $this->id);
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':birthDay', $this->birthDay);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':biography', $this->biography);
        $stmt->bindParam(':nationality', $this->nationality);
        $stmt->bindParam(':imgUrl', $this->imgUrl);
        $stmt->bindParam(':updatedFk', $this->updatedFk);

        try {

            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Autor atualizado com sucesso."
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
                  SET ativo = :active,
                  atualizado_fk = :updatedFk
                  WHERE id = :id';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':active', $this->active);
        $stmt->bindParam(':updatedFk', $this->updatedFk);

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