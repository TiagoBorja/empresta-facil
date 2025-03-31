<?php
session_start();
include_once '../../classes/Connection.php';

if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $connection = new Connection();
    $pdo = $connection->getConnection();

    // Primeiro, busca o utilizador pelo email
    $query = 'SELECT u.*, t.tipo AS tipo FROM utilizador u
            JOIN tipo_utilizador t ON u.tipo_utilizador_fk = t.id WHERE email = :email';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        $_SESSION['login-error'] = "Utilizador não encontrado!";
        header('Location: ../../index.php?page=auth');
        exit();
    }

    if ($password !== $row['senha']) {
        $_SESSION['login-error'] = "Senha inválida!";
        header('Location: ../../index.php?page=auth');
        exit();
    }

    $_SESSION['user'] = $row;
    $_SESSION['email'] = $row['email'];

    header('Location: ../../index.php?page=home');
    exit();
}