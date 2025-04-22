<?php

include_once 'Connection.php';

class User
{
    private $id;
    private $firstName;
    private $lastName;
    private $birthDay;
    private $nif;
    private $cc;
    private $gender;
    private $location;
    private $phoneNumber;

    private $username;
    private $email;
    private $password;
    private $role;
    private $active;

    private $pdo;

    // Getters and Setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getBirthDay()
    {
        return $this->birthDay;
    }

    public function setBirthDay($birthDay)
    {
        $this->birthDay = $birthDay;
    }

    public function getNif()
    {
        return $this->nif;
    }

    public function setNif($nif)
    {
        $this->nif = $nif;
    }

    public function getCc()
    {
        return $this->cc;
    }

    public function setCc($cc)
    {
        $this->cc = $cc;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    public function getUsers()
    {
        $query = "SELECT 
                    u.id, 
                    u.primeiro_nome, 
                    u.ultimo_nome, 
                    u.nome_utilizador, 
                    u.email,
                    tu.tipo,
                    u.ativo
                  FROM utilizador u
                  INNER JOIN tipo_utilizador tu ON u.tipo_utilizador_fk = tu.id";
        $query_run = $this->pdo->prepare($query);

        try {

            $query_run->execute();
            $users = $query_run->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($users);
        } catch (PDOException $e) {
            echo "<tr><td colspan='3'>Sem resultados</td></tr>";
        }
    }

    public function getUserById($id)
    {
        $this->id = $id;
        $query = "SELECT 
                    u.*, tu.tipo 
                  FROM utilizador u
                  INNER JOIN tipo_utilizador tu ON u.tipo_utilizador_fk = tu.id
                  WHERE u.id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return json_encode([
                    'status' => 200,
                    'message' => "Utilizador encontrado.",
                    'data' => $result
                ]);
            } else {
                return json_encode([
                    'status' => 404,
                    'message' => "Utilizador não encontrado."
                ]);
            }
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao encontrar: " . $e->getMessage()
            ]);
        }
    }
    public function newUser()
    {
        if (empty($this->firstName) || empty($this->lastName) || empty($this->birthDay) || empty($this->phoneNumber) || empty($this->username) || empty($this->password) || empty($this->email) || empty($this->role)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "INSERT INTO utilizador (
                    primeiro_nome, 
                    ultimo_nome, 
                    data_nascimento, 
                    nif, 
                    cc, 
                    genero, 
                    morada, 
                    telemovel, 
                    nome_utilizador, 
                    senha, 
                    email, 
                    tipo_utilizador_fk
                  ) VALUES (
                    :firstName, 
                    :lastName, 
                    :birthDay, 
                    :nif, 
                    :cc, 
                    :gender, 
                    :location, 
                    :phoneNumber, 
                    :username, 
                    :password, 
                    :email, 
                    :role
                  )";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':birthDay', $this->birthDay);
        $stmt->bindParam(':nif', $this->nif);
        $stmt->bindParam(':cc', $this->cc);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':phoneNumber', $this->phoneNumber);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':role', $this->role);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Utilizador criado com sucesso!"
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao realizar a inserção!",
            ]);
        }
    }
}
