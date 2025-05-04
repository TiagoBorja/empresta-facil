<?php

include_once 'Connection.php';

class State
{
    private $id;
    private $state;
    private $observation;
    private $pdo;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getObservation()
    {
        return $this->observation;
    }

    public function setObservation($observation)
    {
        $this->observation = $observation;
    }

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    public function getStates()
    {
        $query = "SELECT * FROM estado";
        $query_run = $this->pdo->prepare($query);

        try {

            $query_run->execute();
            $userRoles = $query_run->fetchAll(PDO::FETCH_ASSOC);

            if (count($userRoles) < 1)
                echo "<tr><td colspan='3'>Sem resultados</td></tr>";

            return json_encode($userRoles);
        } catch (PDOException $e) {
            echo "<tr><td colspan='3'>Sem resultados</td></tr>";
        }
    }

    public function getStateById($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM estado WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Estado encontrado.",
                    'data' => $result
                ]);
            } else {
                return json_encode([
                    'status' => 404,
                    'message' => "Estado não encontrado."
                ]);
            }
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao encontrar: " . $e->getMessage()
            ]);
        }
    }

    public function newState()
    {
        if (empty($this->state)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "INSERT INTO estado (estado, observacoes) VALUES (:state, :observation)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':state', $this->state);
        $stmt->bindParam(':observation', $this->observation);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Tipo de utilizador criado com sucesso."
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao inserir: " . $e->getMessage()
            ]);
        }
    }
}