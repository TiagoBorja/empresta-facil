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

    public function create()
    {
        if (empty($this->pickUpDate)) {
            return json_encode([
                'status' => 409,
                'message' => 'A data de levantamento é obrigatória.'
            ]);
        }

        $this->reservationDate = date('Y-m-d H:i:s');
        $this->expirationDate = date('Y-m-d H:i:s', strtotime($this->pickUpDate . ' +7 days'));

        $query = "INSERT INTO {$this->tableName} 
        (livro_localizacao_fk, utilizador_fk, data_reserva, data_levantamento, data_expiracao)
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
                'status' => 200,
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

    public function getById($id)
    {
        $query = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $this->id = $data['id'];
                $this->userId = $data['utilizador_fk'];
                $this->reservationDate = $data['data_reserva'];
                $this->expirationDate = $data['data_expiracao'];
            }

            return [
                'status' => 200,
                'data' => $data
            ];
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'message' => 'Failed to retrieve reservation: ' . $e->getMessage()
            ];
        }
    }
}
