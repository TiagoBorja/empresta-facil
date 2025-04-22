<?php

header('Content-Type: application/json');
include_once '../../php/classes/User.php';

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $user->getUsers();
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $user->setId($id);
    echo $user->getUserById($id);
    exit;
}

if (isset($_POST['saveData'])) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?: filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Sanitização e atribuição de valores
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->setFirstName($firstName);

    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->setLastName($lastName);

    $birthDay = filter_input(INPUT_POST, 'birthDay', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->setBirthDay($birthDay);

    $nif = filter_input(INPUT_POST, 'nif', FILTER_SANITIZE_NUMBER_INT);
    $user->setNif($nif);

    $cc = filter_input(INPUT_POST, 'cc', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->setCc($cc);

    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->setGender($gender);

    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->setLocation($location);

    $phoneNumber = filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_NUMBER_INT);
    $user->setPhoneNumber($phoneNumber);

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->setUsername($username);

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $user->setEmail($email);

    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->setPassword($password);

    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->setRole($role);

    // if (!empty($id)) {
    //     $user->setId($id);
    //     // echo $user->updateUser();
    //     exit;
    // }

    echo $user->newUser(); // método de inserção

    exit;
}
