<?php

include_once 'Connection.php';

class UserRole
{
    private $id;
    private $role;
    private $description;
    private $pdo;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = filter_var($role, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }



    public function getUserRole()
    {
        $query = "SELECT * FROM tipo_utilizador";
        $query_run = $this->pdo->prepare($query);

        try {

            $query_run->execute();
            $userRoles = $query_run->fetchAll(PDO::FETCH_ASSOC);

            if (count($userRoles) < 1)
                echo "<tr><td colspan='3'>Nenhum tipo de utilizador encontrado</td></tr>";

            foreach ($userRoles as $role) {
                ?>
                <tr id="role-<?= $role['id'] ?>">
                    <th>
                        <label>
                            <input type="radio" class="form-check-input" name="userRoleRadio" class="editRadioBtn"
                                value="<?= $role['id']; ?>" />
                        </label>
                    </th>
                    <td><?= $role['tipo']; ?></td>
                    <td><?= $role['descricao']; ?></td>
                </tr>
                <?php
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='3'>Erro ao buscar os tipos de utilizador: " . $e->getMessage() . "</td></tr>";
        }
    }

    public function getUserRoleById($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM tipo_utilizador WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Obtém os dados

            if ($result) {
                echo json_encode([
                    'status' => 200,
                    'message' => "Tipo de utilizador encontrado.",
                    'data' => $result // Inclui os dados no JSON
                ]);
            } else {
                echo json_encode([
                    'status' => 404,
                    'message' => "Tipo de utilizador não encontrado."
                ]);
            }
        } catch (PDOException $e) {
            echo json_encode([
                'status' => 500,
                'message' => "Erro ao encontrar: " . $e->getMessage()
            ]);
        }
    }

    public function newUserRole()
    {

        if (empty($this->role) || empty($this->description)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "INSERT INTO tipo_utilizador (tipo, descricao) VALUES (:tipo, :descricao)";
        $query_run = $this->pdo->prepare($query);


        $data = [
            ':tipo' => $this->role,
            ':descricao' => $this->description,
        ];

        try {

            $query_run->execute($data);

            echo json_encode([
                'status' => 200,
                'message' => "Tipo de utilizador criado com sucesso."
            ]);
        } catch (PDOException $e) {

            return json_encode(value: [
                'status' => 500,
                'message' => "Erro ao inserir: " . $e->getMessage()
            ]);
        }
    }

    public function editUserRole()
    {


        if (empty($this->role) || empty($this->description)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "UPDATE tipo_utilizador 
                  SET tipo = :tipo, descricao: descricao
                  WHERE id = :id";
        $query_run = $this->pdo->prepare($query);


        $data = [
            ':id' => $this->id,
            ':tipo' => $this->role,
            ':descricao' => $this->description,
        ];

        try {

            $query_run->execute($data);

            echo json_encode([
                'status' => 200,
                'message' => "Tipo de utilizador criado com sucesso."
            ]);
        } catch (PDOException $e) {

            return json_encode(value: [
                'status' => 500,
                'message' => "Erro ao inserir: " . $e->getMessage()
            ]);
        }
    }
}
