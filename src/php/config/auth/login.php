<?php
session_start();
include_once '../../classes/Connection.php';

if (isset($_POST['usernameOrEmail']) && isset($_POST['password'])) {

    $usernameOrEmail = $_POST['usernameOrEmail'];
    $password = $_POST['password'];

    $connection = new Connection();
    $pdo = $connection->getConnection();

    $queryUser = 'SELECT u.*, t.tipo AS tipo FROM utilizador u
              JOIN tipo_utilizador t ON u.tipo_utilizador_fk = t.id 
              WHERE email = :usernameOrEmail OR nome_utilizador = :usernameOrEmail';
    $stmtUser = $pdo->prepare($queryUser);
    $stmtUser->bindParam(':usernameOrEmail', $usernameOrEmail, PDO::PARAM_STR);
    $stmtUser->execute();

    $userRow = $stmtUser->fetch(PDO::FETCH_ASSOC);

    $queryEmployee = "SELECT
                        f.id,
                        f.biblioteca_fk,
                        CONCAT(u.primeiro_nome, ' ', u.ultimo_nome) AS nome_completo
                    FROM funcionario f
                    JOIN utilizador u ON f.utilizador_fk = u.id
                    WHERE f.utilizador_fk = :utilizadorFk";
    $stmtEmployee = $pdo->prepare($queryEmployee);
    $stmtEmployee->bindParam(':utilizadorFk', $userRow['id']);
    $stmtEmployee->execute();

    $employeeRow = $stmtEmployee->fetch(PDO::FETCH_ASSOC);

    if (!$userRow) {
        $_SESSION['login-error'] = "Utilizador não encontrado!";
        header('Location: ../../index.php?page=auth');
        exit();
    }

    if (!password_verify($password, $userRow['senha'])) {
        $_SESSION['login-error'] = "Senha inválida!";
        header('Location: ../../index.php?page=auth');
        exit();
    }


    $_SESSION['user'] = $userRow;
    $_SESSION['username'] = $userRow['nome_utilizador'];
    $_SESSION['email'] = $userRow['email'];

    $_SESSION['employee'] = $employeeRow;

    $pageRedirect = '';
    $_SESSION['user']['tipo_utilizador'] === 'Utilizador Comum'
        ? $pageRedirect = 'Location: ../../index.php?page=home'
        : $pageRedirect = 'Location: ../../../administrative/index.php?page=dashboard';

    header($pageRedirect);
    exit();
}
