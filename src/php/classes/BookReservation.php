<?php

include_once 'Connection.php';

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

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();

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
        $this->pickUpDate = $pickUpDate;
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
            echo json_encode([
                'status' => 400,
                'message' => 'A data de levantamento é obrigatória.'
            ]);
            exit;
        }


        $this->reservationDate = date('Y-m-d H:i:s');
        $this->expirationDate = date('Y-m-d H:i:s', strtotime('+14 days'));

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

            return json_encode([
                'status' => 200,
                'message' => "Reserva criada com sucesso.",
            ]);
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
