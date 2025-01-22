<?php

include_once 'Connection.php';

class UserType
{
    private $id;
    private $type;
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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = filter_var($type, FILTER_SANITIZE_SPECIAL_CHARS);
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



    public function getUserType()
    {
        $query = "SELECT * FROM tipo_utilizador";
        $query_run = $this->pdo->prepare($query);

        try {

            $query_run->execute();
            $userTypes = $query_run->fetchAll(PDO::FETCH_ASSOC);

            if (count($userTypes) < 1)
                echo "<tr><td colspan='3'>Nenhum tipo de utilizador encontrado</td></tr>";

            foreach ($userTypes as $type) {
?>
                <tr>
                    <th>
                        <label>
                            <input type="radio" class="form-check-input" name="userTypeRadio" class="editRadioBtn" value="<?= $type['id']; ?>" />
                        </label>
                    </th>
                    <td><?= $type['tipo']; ?></td>
                    <td><?= $type['descricao']; ?></td>
                    <td>
                        <?= $type['ativo'] === 'Y' ?  '<span class="badge rounded-pill bg-success">Ativo</span>' :
                            '<span class="badge rounded-pill bg-danger">Desabilitado</span>' ?>
                    </td>
                </tr>
<?php
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='3'>Erro ao buscar os tipos de utilizador: " . $e->getMessage() . "</td></tr>";
        }
    }

    public function getUserTypeById()
    {
        $query = "SELECT * FROM user_type WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados encontrados
        }
        return null;
    }

    public function newUserType()
    {

        if (empty($this->type) || empty($this->description)) {
            return json_encode([
                'status' => 422,
                'message' => "Preencha todos os campos antes de prosseguir."
            ]);
        }

        $query = "INSERT INTO tipo_utilizador (tipo, descricao) VALUES (:tipo, :descricao)";
        $query_run = $this->pdo->prepare($query);


        $data = [
            ':tipo' => $this->type,
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

    public function editUserType()
    {


        if (empty($this->type) || empty($this->description)) {
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
            ':tipo' => $this->type,
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
