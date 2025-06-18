<?php

include_once 'Connection.php';

class Loan
{
    private $pdo;
    private $tableName = 'emprestimo';

    private $id;
    private $userFk;
    private $employeeFk;
    private $loanDate;
    private $returnDate;

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    // ----------- GETTERS -----------

    public function getId()
    {
        return $this->id;
    }

    public function getUserFk()
    {
        return $this->userFk;
    }

    public function getEmployeeFk()
    {
        return $this->employeeFk;
    }

    public function getLoanDate()
    {
        return $this->loanDate;
    }

    public function getReturnDate()
    {
        return $this->returnDate;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setUserFk($userFk)
    {
        $this->userFk = $userFk;
    }

    public function setEmployeeFk($employeeFk)
    {
        $this->employeeFk = $employeeFk;
    }

    public function setLoanDate($loanDate)
    {
        $this->loanDate = $loanDate;
    }

    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;
    }

    // ----------- MÉTODO: getAll() -----------

    public function getAll()
    {
        $query = "SELECT 
                    e.id,
                    CONCAT(u.primeiro_nome, ' ', u.ultimo_nome) AS utilizador,
                    CONCAT(u.primeiro_nome, ' ', u.ultimo_nome) AS funcionario,
                    e.data_emprestimo,
                    e.data_devolucao
                  FROM {$this->tableName} e
                  JOIN utilizador u ON e.utilizador_fk = u.id
                  LEFT JOIN funcionario f ON e.funcionario_fk = f.id
                  ORDER BY e.data_emprestimo DESC";

        $stmt = $this->pdo->prepare($query);

        try {
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    // ----------- MÉTODO: getById() -----------

    public function getById($id)
    {
        $query = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return json_encode([
                'status' => 200,
                'message' => "Empréstimo encontrado.",
                'data' => $result
            ]);
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'message' => 'Erro ao buscar empréstimo: ' . $e->getMessage()
            ];
        }
    }

    public function create()
    {
        $query = "INSERT INTO {$this->tableName} (utilizador_fk, funcionario_fk, data_devolucao) 
                  VALUES (:utilizador_fk, :funcionario_fk, :data_devolucao)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':utilizador_fk', $this->userFk, PDO::PARAM_INT);
        $stmt->bindParam(':funcionario_fk', $this->employeeFk, PDO::PARAM_INT);
        $stmt->bindParam(':data_devolucao', $this->returnDate, PDO::PARAM_STR);

        try {
            $stmt->execute();
            return json_encode([
                'status' => 200,
                'message' => "Empréstimo criado com sucesso."
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => 'Erro ao criar empréstimo: ' . $e->getMessage()
            ]);
        }
    }
}
