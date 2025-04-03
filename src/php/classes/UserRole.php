<?php

include_once 'Connection.php';

class UserRole
{
    private $id;
    private $role;
    private $description;
    private $active;
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
    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = filter_var($active, FILTER_SANITIZE_SPECIAL_CHARS);
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
                    <td><?= $role['tipo']; ?></td>
                    <td><?= $role['descricao'] === '' ? 'Sem descrição definida' : $role['descricao']; ?></td>
                    <td>
                        <?= $role['ativo'] == 'Y'
                            ? '<span class="badge rounded-pill bg-success">Ativo</span>'
                            : '<span class="badge rounded-pill bg-danger">Inativo</span>'
                            ?>
                    </td>
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
        if (empty($this->role)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "INSERT INTO tipo_utilizador (tipo, descricao) VALUES (:tipo, :descricao)";
        $stmt = $this->pdo->prepare($query);

        // Bind dos parâmetros
        $stmt->bindParam(':tipo', $this->role);
        $stmt->bindParam(':descricao', $this->description);

        try {
            // Execute sem passar os dados novamente, pois os dados já estão vinculados com bindParam
            $stmt->execute();

            echo json_encode([
                'status' => 200,
                'message' => "Tipo de utilizador criado com sucesso."
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao inserir: " . $e->getMessage()
            ]);
        }
    }


    public function updateUserRole($id)
    {

        $this->id = $id;

        if (empty($this->role)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "UPDATE tipo_utilizador 
                  SET tipo = :tipo, descricao = :descricao
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', var: $this->id);
        $stmt->bindParam(':tipo', $this->role);
        $stmt->bindParam(':descricao', $this->description);

        try {

            $stmt->execute();

            echo json_encode([
                'status' => 200,
                'message' => "Tipo de utilizador atualizado com sucesso."
            ]);
        } catch (PDOException $e) {

            return json_encode(value: [
                'status' => 500,
                'message' => "Erro ao inserir: " . $e->getMessage()
            ]);
        }
    }

    public function changeActiveStatus($id, $status)
    {
        $this->id = $id;
        $this->active = $status;

        $query = 'UPDATE tipo_utilizador
                  SET ativo = :active
                  WHERE id = :id';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':active', $this->active);

        try {

            $stmt->execute();

            echo json_encode([
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
