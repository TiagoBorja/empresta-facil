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

    public function getLibrariesByUserId($userId)
    {
        $query = "SELECT b.nome, ub.biblioteca_fk 
                    FROM utilizador_biblioteca ub
                    JOIN utilizador u ON ub.utilizador_fk = u.id
                    JOIN biblioteca b ON ub.biblioteca_Fk = b.id
                    WHERE u.id = :userId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId);

        try {
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode([
                'status' => 200,
                'message' => "Bibliotecas encontradas.",
                'data' => $result
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => 'Erro ao obter a reserva: ' . $e->getMessage()
            ]);
        }
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


    public function confirmValidationCode($userId)
    {
        // Selecionar o código válido e não expirado
        $querySelect = "SELECT codigo_validacao 
                FROM utilizador_biblioteca 
                WHERE utilizador_fk = :userId 
                  AND validado = 0 
                  AND data_expirado >= CURRENT_DATE";

        $stmtSelect = $this->pdo->prepare($querySelect);
        $stmtSelect->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmtSelect->execute();

        $row = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return json_encode([
                'status' => 422,
                'message' => 'Código de validação inexistente ou expirado.'
            ]);
        }

        if ($row['codigo_validacao'] != $this->validationCode) {
            return json_encode([
                'status' => 422,
                'message' => 'Código de validação incorreto.'
            ]);
        }

        // Iniciar transação para garantir que ambas as atualizações sejam bem sucedidas
        $this->pdo->beginTransaction();

        try {
            // 1. Atualizar a tabela utilizador_biblioteca
            $queryUpdate = "UPDATE utilizador_biblioteca 
                    SET validado = 1, 
                        data_validacao = CURRENT_DATE 
                    WHERE utilizador_fk = :userId 
                      AND validado = 0 
                      AND data_expirado >= CURRENT_DATE
                      AND codigo_validacao = :code";

            $stmtUpdate = $this->pdo->prepare($queryUpdate);
            $stmtUpdate->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':code', $this->validationCode, PDO::PARAM_STR);
            $stmtUpdate->execute();

            // 2. Atualizar a tabela utilizador para ativo = 'Y'
            $queryUpdateUser = "UPDATE utilizador 
                       SET ativo = 'Y' 
                       WHERE id = :userId";

            $stmtUpdateUser = $this->pdo->prepare($queryUpdateUser);
            $stmtUpdateUser->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmtUpdateUser->execute();

            // Confirmar ambas as atualizações
            $this->pdo->commit();

            return json_encode([
                'status' => 200,
                'message' => 'Código validado com sucesso. Conta ativada.'
            ]);
        } catch (PDOException $e) {
            // Em caso de erro, desfazer quaisquer alterações
            $this->pdo->rollBack();
            error_log("Erro ao validar: " . $e->getMessage());
            return json_encode([
                'status' => 500,
                'message' => 'Erro ao validar: ' . $e->getMessage()
            ]);
        }
    }
}