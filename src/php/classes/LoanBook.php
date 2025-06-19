<?php

include_once 'Connection.php';

class LoanBook
{
    private $pdo;
    private $tableName = 'emprestimo_livro';

    private $loanFk;
    private $bookFk;
    private $statePickUp;
    private $stateReturn;
    private $stateLoan;

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    // ----------- GETTERS -----------

    public function getLoanFk()
    {
        return $this->loanFk;
    }

    public function getBookFk()
    {
        return $this->bookFk;
    }

    public function getStatePickUp()
    {
        return $this->statePickUp;
    }

    public function getStateReturn()
    {
        return $this->stateReturn;
    }

    public function getStateLoan()
    {
        return $this->stateLoan;
    }

    public function setLoanFk($loanFk)
    {
        $this->loanFk = $loanFk;
    }

    public function setBookFk($bookFk)
    {
        $this->bookFk = $bookFk;
    }

    public function setStatePickUp($statePickUp)
    {
        $this->statePickUp = $statePickUp;
    }

    public function setStateReturn($stateReturn)
    {
        $this->stateReturn = $stateReturn;
    }

    public function setStateLoan($stateLoan)
    {
        $this->stateLoan = $stateLoan;
    }


    public function create()
    {
        $query = "INSERT INTO {$this->tableName} (emprestimo_fk, livro_localizacao_fk, estado_levantou_fk) 
                  VALUES (:loanFk, :bookFk, :statePickUp)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':loanFk', $this->loanFk, PDO::PARAM_INT);
        $stmt->bindParam(':bookFk', $this->bookFk, PDO::PARAM_INT);
        $stmt->bindParam(':statePickUp', $this->statePickUp, PDO::PARAM_INT);

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
