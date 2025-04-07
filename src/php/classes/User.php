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
    private $permission;
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

    public function getPermission()
    {
        return $this->permission;
    }

    public function setPermission($permission)
    {
        $this->permission = $permission;
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
        $query = "SELECT u.*, tu.tipo
                  FROM utilizador u
                  INNER JOIN tipo_utilizador tu ON u.tipo_utilizador_fk = tu.id";
        $query_run = $this->pdo->prepare($query);

        try {

            $query_run->execute();
            $users = $query_run->fetchAll(PDO::FETCH_ASSOC);

            if (count($users) < 1)
                echo "<tr><td colspan='3'>Sem resultados</td></tr>";

            foreach ($users as $user) {
                ?>
                <tr id="id-<?= $user['id'] ?>">
                    <td><?= $user['primeiro_nome'] ?></td>
                    <td><?= $user['ultimo_nome'] ?></td>
                    <td><?= $user['nome_utilizador'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['tipo'] ?></td>
                    <td>
                        <?= $user['ativo'] == 'Y'
                            ? '<span class="badge rounded-pill bg-success">Ativo</span>'
                            : '<span class="badge rounded-pill bg-danger">Inativo</span>'
                            ?>
                    </td>
                </tr>
                <?php
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='3'>Sem resultados</td></tr>";
        }
    }
}
