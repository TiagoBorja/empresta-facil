<?php

include_once 'Connection.php';

class UserLibrary
{
    private $userFk;
    private $libraryFk;
    private $validationCode;
    private $validated;
    private $requestDate;
    private $expirationDate;
    private $validationDate;
    private $pdo;
    private $tableName = 'utilizador_biblioteca';

    // Getters
    public function getUserFk()
    {
        return $this->userFk;
    }

    public function getLibraryFk()
    {
        return $this->libraryFk;
    }

    public function getValidationCode()
    {
        return $this->validationCode;
    }

    public function isValidated()
    {
        return $this->validated;
    }

    public function getRequestDate()
    {
        return $this->requestDate;
    }

    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    public function getValidationDate()
    {
        return $this->validationDate;
    }

    // Setters
    public function setUserFk($userFk)
    {
        $this->userFk = $userFk;
    }

    public function setLibraryFk($libraryFk)
    {
        $this->libraryFk = $libraryFk;
    }

    public function setValidationCode($validationCode)
    {
        $this->validationCode = $validationCode;
    }

    public function setValidated($validated)
    {
        $this->validated = $validated;
    }

    public function setRequestDate($requestDate)
    {
        $this->requestDate = $requestDate;
    }

    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }

    public function setValidationDate($validationDate)
    {
        $this->validationDate = $validationDate;
    }



    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }


    public function create()
    {
        $query = "INSERT INTO {$this->tableName} (utilizador_fk, biblioteca_fk, codigo_validacao, data_expirado) 
                  VALUES (:userFk, :libraryFk, :validationCode, :expirationDate)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':userFk', $this->userFk);
        $stmt->bindParam(':libraryFk', $this->libraryFk);
        $stmt->bindParam(':validationCode', $this->validationCode);
        $stmt->bindParam(':expirationDate', $this->expirationDate); // corrigido aqui

        try {
            $stmt->execute();
            return json_encode([
                'status' => 200,
                'message' => "Relação criada com sucesso."
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao inserir relação: " . $e->getMessage()
            ]);
        }
    }
}