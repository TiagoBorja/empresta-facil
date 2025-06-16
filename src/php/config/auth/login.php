<?php
session_start();
include_once '../../classes/Connection.php';

if (isset($_POST['usernameOrEmail']) && isset($_POST['password'])) {

    $usernameOrEmail = $_POST['usernameOrEmail'];
    $password = $_POST['password'];

    $connection = new Connection();
    $pdo = $connection->getConnection();

    $query = 'SELECT u.*, t.tipo AS tipo FROM utilizador u
              JOIN tipo_utilizador t ON u.tipo_utilizador_fk = t.id 
              WHERE email = :usernameOrEmail OR nome_utilizador = :usernameOrEmail';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':usernameOrEmail', $usernameOrEmail, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        $_SESSION['login-error'] = "Utilizador não encontrado!";
        header('Location: ../../index.php?page=auth');
        exit();
    }

    if (!password_verify($password, $row['senha'])) {
        $_SESSION['login-error'] = "Senha inválida!";
        header('Location: ../../index.php?page=auth');
        exit();
    }


    $_SESSION['user'] = $row;
    $_SESSION['username'] = $row['nome_utilizador'];
    $_SESSION['email'] = $row['email'];

    $pageRedirect = '';
    $_SESSION['user']['tipo_utilizador'] === 'Utilizador Comum'
        ? $pageRedirect = 'Location: ../../index.php?page=home'
        : $pageRedirect = 'Location: ../../../administrative/index.php?page=dashboard';

    header($pageRedirect);
    exit();
}