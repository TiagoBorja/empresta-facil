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
    public function getBookTitle($id)
    {
        $query = "SELECT l.titulo FROM livro l
                  INNER JOIN livro_localizacao ll ON ll.livro_fk = l.id
                  WHERE ll.id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['titulo'] : null;
        } catch (PDOException $e) {
            return null;
        }
    }
    public function create()
    {
        $query = "INSERT INTO {$this->tableName} (emprestimo_fk, livro_localizacao_fk, estado_levantou_fk) 
                  VALUES (:loanFk, :bookFk, :statePickUp)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':loanFk', $this->loanFk, PDO::PARAM_INT);
        $stmt->bindParam(':bookFk', $this->bookFk, PDO::PARAM_INT);
        $statePickUp = $this->getStatePickUp();
        $stmt->bindParam(':statePickUp', $statePickUp, PDO::PARAM_INT);

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

    public function update($loanFk, $stateReturn, $returnDate, $bookFk)
    {

        $today = new DateTime();
        $today->setTime(0, 0);

        $pickup = new DateTime($returnDate);
        $pickup->setTime(0, 0);

        if ($pickup->format('Y') !== $today->format('Y')) {
            return json_encode([
                'status' => 400,
                'message' => 'Só é possível devolver livros no ano atual.'
            ]);
        }

        if ($pickup < $today) {
            return json_encode([
                'status' => 400,
                'message' => 'A data de retorno não pode ser anterior à data de hoje.'
            ]);
        }
        $query = "UPDATE emprestimo_livro el
                  SET el.estado_devolucao_fk = :stateReturn,
                  el.data_devolvido = :returnDate
                  WHERE el.emprestimo_fk = :loanFk
                  AND el.livro_localizacao_fk = :bookFk";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':loanFk', $loanFk, PDO::PARAM_INT);
        $stmt->bindParam(':bookFk', $bookFk, PDO::PARAM_INT);
        $stmt->bindParam(':stateReturn', $stateReturn, PDO::PARAM_INT);
        $stmt->bindParam(':returnDate', $returnDate);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Estado do empréstimo atualizado com sucesso."
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao atualizar: " . $e->getMessage()
            ]);
        }
    }
}
