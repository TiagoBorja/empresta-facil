<?php
session_start();
header('Content-Type: application/json');
include_once '../../php/classes/User.php';
include_once '../../php/classes/Utils.php';

$user = new User();
$utils = new Utils();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $user->getUsers($_SESSION['employee']['utilizador_fk']);
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

    $address = filter_input(INPUT_POST, 'address ', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->setAddress($address);

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

    $libraries = filter_input(INPUT_POST, 'librarySelect', FILTER_SANITIZE_SPECIAL_CHARS);

    if (isset($_FILES["imgProfile"]) && $_FILES["imgProfile"]["tmp_name"] != "") {
        $imgPath = $utils::uploadImage('./upload', 'imgProfile');

        $user->setImgUrl($imgPath);
    }
    if (!empty($id)) {
        $user->setId($id);
        echo $user->updateUser($id);
        exit;
    }

    $user->setActive('P');
    echo $user->newUser($libraries);
    exit;
}

if (isset($_POST['registerUser'])) {

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

    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->setAddress($address);

    $phoneNumber = filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_NUMBER_INT);
    $user->setPhoneNumber($phoneNumber);

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->setUsername($username);

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $user->setEmail($email);

    $passwordRaw = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $passwordHashed = password_hash($passwordRaw, PASSWORD_DEFAULT);
    $user->setPassword($passwordHashed);

    $user->setActive('P');
    $libraries = $_POST['libraries'] ?? [];
    $libraries = array_filter(array_map(function ($libraryId) {
        return filter_var($libraryId, FILTER_SANITIZE_NUMBER_INT);
    }, $libraries));

    echo $user->registerUser($libraries);
    exit;
}

if (isset($_POST['changeStatus'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);
    $status = ($status === 'Y') ? 'N' : 'Y';

    $user->setId($id);
    $user->setActive($status);

    echo $user->changeActiveStatus($id, $status);
    exit;
}

