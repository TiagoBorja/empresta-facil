<?php

include_once 'Connection.php';
include_once 'Library.php';
include_once 'UserLibrary.php';

class User
{
    private $id;
    private $firstName;
    private $lastName;
    private $birthDay;
    private $nif;
    private $cc;
    private $gender;
    private $address;
    private $phoneNumber;

    private $username;
    private $email;
    private $imgUrl;
    private $password;
    private $role;
    private $active;

    private $pdo;
    private $library;
    private $userLibrary;
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

    public function getAdress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
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
    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    public function setImgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;
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

        $this->library = new Library();
        $this->userLibrary = new UserLibrary();
    }

    public function getUsers($employeeId)
    {
        // Buscar a biblioteca_fk do funcionário
        $libraryQuery = "SELECT biblioteca_fk FROM funcionario WHERE utilizador_fk = :employeeId LIMIT 1";
        $stmt = $this->pdo->prepare($libraryQuery);
        $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
        $stmt->execute();
        $library = $stmt->fetch(PDO::FETCH_ASSOC);

        // Caso não tenha library atribuída, retorna todos os utilizadores
        if (!$library || $library['biblioteca_fk'] === null) {
            $query = "SELECT 
                    u.id, 
                    u.primeiro_nome, 
                    u.ultimo_nome, 
                    u.nome_utilizador, 
                    u.email,
                    tu.tipo,
                    u.ativo
                FROM utilizador u
                INNER JOIN tipo_utilizador tu ON u.tipo_utilizador_fk = tu.id
                ORDER BY 
                    CASE u.ativo 
                        WHEN 'P' THEN 1 
                        WHEN 'Y' THEN 2 
                        WHEN 'N' THEN 3 
                        ELSE 4 
                    END,
                    u.primeiro_nome ASC";

            $query_run = $this->pdo->prepare($query);
            $query_run->execute();
            $result = $query_run->fetchAll(PDO::FETCH_ASSOC);

            return json_encode([
                'status' => 200,
                'message' => "Utilizadores encontrados (sem filtro de biblioteca).",
                'data' => $result
            ]);
        }

        $query = "SELECT 
                u.id, 
                u.primeiro_nome, 
                u.ultimo_nome, 
                u.nome_utilizador, 
                u.email,
                tu.tipo,
                u.ativo
            FROM utilizador u
            INNER JOIN tipo_utilizador tu ON u.tipo_utilizador_fk = tu.id
            INNER JOIN utilizador_biblioteca ub ON u.id = ub.utilizador_fk
            WHERE ub.biblioteca_fk = :bibliotecaFk
            ORDER BY 
                CASE u.ativo 
                    WHEN 'P' THEN 1 
                    WHEN 'Y' THEN 2 
                    WHEN 'N' THEN 3 
                    ELSE 4 
                END,
                u.primeiro_nome ASC";

        $query_run = $this->pdo->prepare($query);
        $query_run->bindParam(':bibliotecaFk', $library['biblioteca_fk'], PDO::PARAM_INT);
        $query_run->execute();
        $result = $query_run->fetchAll(PDO::FETCH_ASSOC);

        return json_encode([
            'status' => 200,
            'message' => "Utilizadores encontrados (filtrados por biblioteca).",
            'data' => $result
        ]);
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
    public function newUser($libraryId)
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
                    img_url, 
                    tipo_utilizador_fk,
                    ativo
                  ) VALUES (
                    :firstName, 
                    :lastName, 
                    :birthDay, 
                    :nif, 
                    :cc, 
                    :gender, 
                    :address, 
                    :phoneNumber, 
                    :username, 
                    :password, 
                    :email,
                    :imgUrl, 
                    :role,
                    :active
                  )";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':birthDay', $this->birthDay);
        $stmt->bindParam(':nif', $this->nif);
        $stmt->bindParam(':cc', $this->cc);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':phoneNumber', $this->phoneNumber);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':imgUrl', $this->imgUrl);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':active', $this->active);

        try {
            $stmt->execute();
            $userFk = $this->pdo->lastInsertId();

            $code = Utils::generateRandomCode(12);

            if (!empty($libraryId)) {
                $this->userLibrary->setUserFk($userFk);
                $this->userLibrary->setLibraryFk($libraryId);
                $this->userLibrary->setValidationCode($code);
                $this->userLibrary->setExpirationDate(
                    date(
                        'Y-m-d H:i:s',
                        strtotime('+14 days')
                    )
                );

                $libraryResult = $this->userLibrary->create();
                $libraryResponse = json_decode($libraryResult, true);
                if ($libraryResponse['status'] != 200) {
                    return $libraryResult;
                }
                $libraryIdsValid[] = $libraryId;
            }

                // $libraryData = $this->library->getLibraryDataByIds($libraryIdsValid);

                // if (!Utils::sendConfirmationEmail($this->email, $this->getFirstName(), $code, $libraryData)) {
                //     exit;
                // }

            return json_encode([
                'status' => 200,
                'message' => "Utilizador criado com sucesso!"
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao realizar a inserção!" . $e->getMessage(),
            ]);
        }
    }

    public function registerUser($libraries = [])
    {
        if (empty($this->firstName) || empty($this->lastName) || empty($this->birthDay) || empty($this->phoneNumber) || empty($this->username) || empty($this->password) || empty($this->email)) {
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
                    ativo
                  ) VALUES (
                    :firstName, 
                    :lastName, 
                    :birthDay, 
                    :nif, 
                    :cc, 
                    :gender, 
                    :address, 
                    :phoneNumber, 
                    :username, 
                    :password, 
                    :email,
                    :active
                  )";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':birthDay', $this->birthDay);
        $stmt->bindParam(':nif', $this->nif);
        $stmt->bindParam(':cc', $this->cc);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':phoneNumber', $this->phoneNumber);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':active', $this->active);

        try {
            $stmt->execute();
            $userFk = $this->pdo->lastInsertId();

            $code = Utils::generateRandomCode(12);
            $libraryIdsValid = [];

            if (!empty($libraries) && is_array($libraries)) {
                foreach ($libraries as $libraryId) {
                    if (!empty($libraryId)) {
                        $this->userLibrary->setUserFk($userFk);
                        $this->userLibrary->setLibraryFk($libraryId);
                        $this->userLibrary->setValidationCode($code);
                        $this->userLibrary->setExpirationDate(
                            date(
                                'Y-m-d H:i:s',
                                strtotime('+14 days')
                            )
                        );

                        $libraryResult = $this->userLibrary->create();
                        $libraryResponse = json_decode($libraryResult, true);
                        if ($libraryResponse['status'] != 200) {
                            return $libraryResult;
                        }
                        $libraryIdsValid[] = $libraryId;
                    }
                }
            }

            // $libraryData = $this->library->getLibraryDataByIds($libraryIdsValid);

            // if (!Utils::sendConfirmationEmail($this->email, $this->getFirstName(), $code, $libraryData)) {
            //     exit;
            // }

            return json_encode([
                'status' => 200,
                'message' => "Utilizador criado com sucesso!"
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao realizar a inserção!" . $e->getMessage(),
            ]);
        }
    }

    public function updateUser($id)
    {
        $this->id = $id;

        // Verificação dos campos obrigatórios
        if (empty($this->firstName) || empty($this->lastName) || empty($this->birthDay) || empty($this->phoneNumber) || empty($this->username) || empty($this->email)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "UPDATE utilizador SET 
                    primeiro_nome = :firstName,
                    ultimo_nome = :lastName,
                    data_nascimento = :birthDay,
                    nif = :nif,
                    cc = :cc,
                    genero = :gender,
                    morada = :address,
                    telemovel = :phoneNumber,
                    nome_utilizador = :username,
                    email = :email,
                    img_url = :imgUrl,
                    tipo_utilizador_fk = :role
                  WHERE id = :id";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':birthDay', $this->birthDay);
        $stmt->bindParam(':nif', $this->nif);
        $stmt->bindParam(':cc', $this->cc);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':phoneNumber', $this->phoneNumber);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':imgUrl', $this->imgUrl);
        $stmt->bindParam(':role', $this->role);

        try {
            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Dados do utilizador atualizados com sucesso!"
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao atualizar o utilizador: " . $e->getMessage()
            ]);
        }
    }

    public function changeActiveStatus($id, $status)
    {
        $this->id = $id;
        $this->active = $status;

        $query = 'UPDATE utilizador
              SET ativo = :active
              WHERE id = :id';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':active', $this->active);

        try {

            $stmt->execute();

            return json_encode([
                'status' => 200,
                'message' => "Status atualizado com sucesso!"
            ]);
        } catch (PDOException $e) {

            return json_encode(value: [
                'status' => 500,
                'message' => "Erro ao atualizar: " . $e->getMessage()
            ]);
        }
    }
}
