<?php

include_once 'Connection.php';
include_once 'Utils.php';

class BookReservation
{
    private $pdo;
    private $tableName = 'reserva';

    private $id;
    private $bookId;
    private $locationId;
    private $userId;
    private $reservationDate;
    private $expirationDate;
    private $pickUpDate;

    private $utils;

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
        $this->utils = new Utils();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBookId()
    {
        return $this->bookId;
    }
    public function getLocationId()
    {
        return $this->locationId;
    }
    public function getUserId()
    {
        return $this->userId;
    }

    public function getReservationDate()
    {
        return $this->reservationDate;
    }

    public function getExpirationDate()
    {
        return $this->expirationDate;
    }
    public function getPickUpDate($pickUpDate)
    {
        return $this->pickUpDate = $pickUpDate;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setBookId($bookId)
    {
        $this->bookId = $bookId;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    public function setReservationDate($reservationDate)
    {
        $this->reservationDate = $reservationDate;
    }

    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }
    public function setPickUpDate($pickupDate)
    {
        $this->pickUpDate = $pickupDate; // Usa o "U" maiúsculo
    }


    public function getAll()
    {
        $query = "SELECT
                    r.id,
                    r.utilizador_fk,
                    CONCAT(u.primeiro_nome, ' ', u.ultimo_nome) AS nome_completo,
                    l.titulo,
                    r.criado_em,
                    r.data_levantamento,
                    r.data_expiracao,
                    e.estado AS estado_reserva
                FROM reserva r
                JOIN utilizador u ON r.utilizador_fk = u.id
                JOIN estado e ON r.estado_fk = e.id
                JOIN livro_localizacao ll ON r.livro_localizacao_fk = ll.id
                JOIN livro l ON ll.livro_fk = l.id
                ORDER BY r.criado_em DESC";
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
        $query = "SELECT
                r.id,
                r.utilizador_fk,
                CONCAT(u.primeiro_nome, ' ', u.ultimo_nome) AS nome_completo,
                ll.id as livro_localizacao_fk,
                ll.livro_fk,
                l.titulo,
                r.criado_em,
                r.data_levantamento,
                r.data_expiracao,
                e.estado AS estado_reserva
            FROM reserva r
            JOIN utilizador u ON r.utilizador_fk = u.id
            JOIN estado e ON r.estado_fk = e.id
            JOIN livro_localizacao ll ON r.livro_localizacao_fk = ll.id
            JOIN livro l ON ll.livro_fk = l.id
            WHERE r.id = :id
            ORDER BY r.criado_em DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return json_encode([
                'status' => 200,
                'message' => "Reserva encontrada.",
                'data' => $result
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => 'Erro ao obter a reserva: ' . $e->getMessage()
            ]);
        }
    }
    public function getReservationByUserId($userId)
    {
        $query = "SELECT 
                    l.titulo,
                    r.criado_em, 
                    r.data_levantamento,
                    e.estado
                FROM reserva r                           
                INNER JOIN livro_localizacao ll ON r.livro_localizacao_fk = ll.id
                INNER JOIN livro l ON ll.livro_fk = l.id
                INNER JOIN estado e ON r.estado_fk = e.id
                INNER JOIN utilizador u ON r.utilizador_fk = u.id
                WHERE r.utilizador_fk = :userId
                ORDER BY r.criado_em DESC
                LIMIT 5";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId);

        try {
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode([
                'status' => 200,
                'message' => "Reserva encontrada.",
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

        if (empty($this->pickUpDate)) {
            return json_encode([
                'status' => 409,
                'message' => 'A data de levantamento é obrigatória.'
            ]);
        }

        $today = new DateTime();
        $today->setTime(0, 0);

        $pickup = new DateTime($this->pickUpDate);
        $pickup->setTime(0, 0);

        if ($pickup->format('Y') !== $today->format('Y')) {
            return json_encode([
                'status' => 400,
                'message' => 'Só é possível levantar livros no ano atual.'
            ]);
        }

        if ($pickup < $today) {
            return json_encode([
                'status' => 400,
                'message' => 'A data de levantamento não pode ser anterior à data de hoje.'
            ]);
        }

        $this->reservationDate = date('Y-m-d H:i:s');
        $this->expirationDate = date('Y-m-d H:i:s', strtotime($this->pickUpDate . ' +3 days'));

        $query = "INSERT INTO {$this->tableName} 
            (livro_localizacao_fk, utilizador_fk, criado_em, data_levantamento, data_expiracao)
            VALUES (:locationId, :userId, :reservationDate, :pickUpDate, :expirationDate)";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':locationId', $this->locationId);
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':reservationDate', $this->reservationDate);
        $stmt->bindParam(':pickUpDate', $this->pickUpDate);
        $stmt->bindParam(':expirationDate', $this->expirationDate);

        try {
            $stmt->execute();

            $bookQuery = "SELECT l.titulo , b.nome, b.morada
                            FROM livro l
                            JOIN livro_localizacao ll ON l.id = ll.livro_fk
                            JOIN localizacao loc ON ll.localizacao_fk = loc.id
                            JOIN biblioteca b ON loc.biblioteca_fk = b.id
                        WHERE ll.id = :locationId";

            $bookStmt = $this->pdo->prepare($bookQuery);
            $bookStmt->bindParam(':locationId', $this->locationId);
            $bookStmt->execute();

            $book = $bookStmt->fetch(PDO::FETCH_ASSOC);
            $bookTitle = $book['titulo'];
            $libraryName = $book['nome'];
            $libraryAddress = $book['morada'];

            echo json_encode([
                'status' => 202,
                'message' => "Reserva criada com sucesso! Um email será enviado em breve.",
            ]);

            Utils::sendReservationEmail(
                $_SESSION['user']['email'],
                $_SESSION['user']['primeiro_nome'],
                $bookTitle,
                $this->pickUpDate,
                $this->expirationDate,
                $libraryName,
                $libraryAddress
            );

            return;
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao inserir: " . $e->getMessage()
            ]);
        }
    }

    public function updateReservationState($reservationId)
    {
        $queryState = "SELECT id FROM estado WHERE observacoes = 'RESERVA' AND estado = 'ATENDIDA'";
        $stmtState = $this->pdo->prepare($queryState);
        $stmtState->execute();
        $stateIdRow = $stmtState->fetch(PDO::FETCH_ASSOC);

        if (!$stateIdRow) {
            return json_encode([
                'status' => 404,
                'message' => "Estado 'RESERVA - ATENDIDA' não encontrado na tabela estado."
            ]);
        }

        $stateId = $stateIdRow['id'];

        $query = "UPDATE {$this->tableName} SET estado_fk = :stateId WHERE id = :reservationId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':stateId', $stateId, PDO::PARAM_INT);
        $stmt->bindParam(':reservationId', $reservationId, PDO::PARAM_INT);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Estado da reserva atualizado com sucesso!",
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao atualizar: " . $e->getMessage()
            ]);
        }
    }
}
