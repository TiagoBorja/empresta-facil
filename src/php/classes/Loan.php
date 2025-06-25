<?php

include_once 'Connection.php';
include_once 'LoanBook.php';

class Loan
{
    private $pdo;
    private $tableName = 'emprestimo';

    private $loanBook;
    private $id;
    private $reservationFk;
    private $userFk;
    private $employeeFk;
    private $bookFk;
    private $loanDate;
    private $dueDate;
    private $returnDate;
    private $stateReturn;
    private $statePickUp;


    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
        $this->loanBook = new LoanBook();
    }

    // ----------- GETTERS -----------

    public function getId()
    {
        return $this->id;
    }

    public function getReservationFk()
    {
        return $this->reservationFk;
    }

    public function getUserFk()
    {
        return $this->userFk;
    }
    public function getBookFk()
    {
        return $this->bookFk;
    }

    public function getEmployeeFk()
    {
        return $this->employeeFk;
    }

    public function getLoanDate()
    {
        return $this->loanDate;
    }
    public function getDueDate()
    {
        return $this->dueDate;
    }
    public function getReturnDate()
    {
        return $this->returnDate;
    }

    public function getStateReturn()
    {
        return $this->stateReturn;
    }
    public function getStatePickUp()
    {
        return $this->statePickUp;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setReservationFk($reservationFk)
    {
        $this->reservationFk = $reservationFk;
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

    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
    }
    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;
    }

    public function setStateReturn($stateReturn)
    {
        $this->stateReturn = $stateReturn;
    }

    public function setStatePickUp($statePickUp)
    {
        $this->statePickUp = $statePickUp;
    }

    public function setBookFk($bookFk)
    {
        $this->bookFk = $bookFk;
    }

    public function getAll()
    {
        $query = "SELECT 
                    e.id, 
                    CONCAT(u.primeiro_nome, ' ', u.ultimo_nome) AS utilizador, 
                    CONCAT(u_func.primeiro_nome, ' ', u_func.ultimo_nome) AS funcionario,
                    u.id AS utilizador_fk,
                    ll.livro_fk,
                    l.titulo,
                    el.livro_localizacao_fk,
                    e.data_emprestimo,
                    e.data_devolucao,
                    el.data_devolvido,
                    es_emprestimo.estado AS estado_emprestimo,
                    es_levantou.estado AS estado_levantou,
                    es_devolucao.estado AS estado_devolucao
                FROM emprestimo e
                JOIN utilizador u ON e.utilizador_fk = u.id
                JOIN funcionario f ON e.funcionario_fk = f.id
                JOIN utilizador u_func ON f.utilizador_fk = u_func.id
                JOIN emprestimo_livro el ON el.emprestimo_fk = e.id
                JOIN livro_localizacao ll ON ll.id = el.livro_localizacao_fk
                JOIN livro l ON l.id = ll.livro_fk
                JOIN estado es_emprestimo ON el.estado_emprestimo_fk = es_emprestimo.id
                JOIN estado es_levantou ON el.estado_levantou_fk = es_levantou.id
                LEFT JOIN estado es_devolucao ON el.estado_devolucao_fk = es_devolucao.id
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

    public function getById($id, $bookId)
    {
        $query = "SELECT 
                    e.id, 
                    CONCAT(u.primeiro_nome, ' ', u.ultimo_nome) AS utilizador, 
                    CONCAT(u_func.primeiro_nome, ' ', u_func.ultimo_nome) AS funcionario,
                    u.id AS utilizador_fk,
                    ll.livro_fk,
                    l.titulo,
                    el.livro_localizacao_fk,
                    e.data_emprestimo,
                    e.data_devolucao,
                    el.data_devolvido,
                    es_emprestimo.id AS estado_emprestimo_fk,
                    es_levantou.id AS estado_levantou_fk,
                    es_devolucao.id AS estado_devolucao_fk,
                    es_emprestimo.estado AS estado_emprestimo,
                    es_levantou.estado AS estado_levantou,
                    es_devolucao.estado AS estado_devolucao
                FROM emprestimo e
                JOIN utilizador u ON e.utilizador_fk = u.id
                JOIN funcionario f ON e.funcionario_fk = f.id
                JOIN utilizador u_func ON f.utilizador_fk = u_func.id
                JOIN emprestimo_livro el ON el.emprestimo_fk = e.id
                JOIN livro_localizacao ll ON ll.id = el.livro_localizacao_fk
                JOIN livro l ON l.id = ll.livro_fk
                JOIN estado es_emprestimo ON el.estado_emprestimo_fk = es_emprestimo.id
                JOIN estado es_levantou ON el.estado_levantou_fk = es_levantou.id
                LEFT JOIN estado es_devolucao ON el.estado_devolucao_fk = es_devolucao.id
                WHERE e.id = :id
                AND el.livro_localizacao_fk = :bookId
                ORDER BY e.data_emprestimo DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);

        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result === false) {
                return json_encode([
                    'status' => 404,
                    'message' => "Empréstimo não encontrado para os IDs fornecidos.",
                    'data' => null
                ]);
            }

            return json_encode([
                'status' => 200,
                'message' => "Empréstimo encontrado.",
                'data' => $result
            ]);
        } catch (PDOException $e) {
            return json_encode([  // Adicionado json_encode também para erros
                'status' => 500,
                'message' => 'Erro ao buscar empréstimo: ' . $e->getMessage(),
                'data' => null
            ]);
        }
    }

    public function getByReservationId($reservationId)
    {
        $query = "SELECT * FROM {$this->tableName} WHERE reserva_fk = :reservationId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':reservationId', $reservationId, PDO::PARAM_INT);

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

    public function create($books = [])
    {
        $query = "INSERT INTO {$this->tableName} (reserva_fk, utilizador_fk, funcionario_fk, data_devolucao) 
                  VALUES (:reservationFk, :userFk, :employeeFk, :dueDate)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':reservationFk', $this->reservationFk, PDO::PARAM_INT);
        $stmt->bindParam(':userFk', $this->userFk, PDO::PARAM_INT);
        $stmt->bindParam(':employeeFk', $this->employeeFk, PDO::PARAM_INT);
        $stmt->bindParam(':dueDate', $this->dueDate, PDO::PARAM_STR);

        try {
            $stmt->execute();

            $loanId = $this->pdo->lastInsertId();

            if (!empty($books) && is_array($books)) {
                foreach ($books as $bookId) {
                    if (!empty($bookId)) {
                        $this->loanBook->setLoanFk($loanId);
                        $this->loanBook->setBookFk($bookId);
                        $this->loanBook->setStatePickUp($this->statePickUp);
                        $loanResult = $this->loanBook->create();

                        $loanResponse = json_decode($loanResult, true);
                        if ($loanResponse['status'] != 200) {
                            return $loanResult;
                        }
                    }
                }
            }
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

    // @Deprected
    /*public function update($id)
    {
        $this->id = $id;

        $query = "UPDATE emprestimo e
                  SET e.data_devolvido = :returnDate
                  WHERE e.id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':returnDate', $this->returnDate, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $this->loanBook->setBookFk($this->bookFk);
            $this->loanBook->setStateReturn($this->stateReturn);

            return $this->loanBook->update($this->id, $this->stateReturn, $this->bookFk);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao atualizar: " . $e->getMessage()
            ]);
        }
    }
        */
}
