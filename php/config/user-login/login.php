<?php
session_start();
include_once '../../classes/Connection.php';

if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $connection = new Connection();
    $pdo = $connection->getConnection();

    // Primeiro, busca o utilizador pelo email
    $query = 'SELECT * FROM utilizador WHERE email = :email';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        $_SESSION['login-error'] = "Utilizador não encontrado!";
        header('Location: ../../?page=auth');
        exit();
    }

    if ($password !== $row['senha']) {
        $_SESSION['login-error'] = "Senha inválida!";
        header('Location: ../../?page=auth');
        exit();
    }

    $_SESSION['user'] = $row;
    $_SESSION['email'] = $row['email'];

    header('Location: ../../index.php?page=home');
    exit();
}