<?php
session_start();
header('Content-Type: application/json');
include_once '../../php/classes/User.php';
include_once '../../php/classes/Utils.php';

$user = new User();
$utils = new Utils();
$userRole = $_SESSION['user']['tipo'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['getPendentUserCount'])) {
        echo $user->getPendentUserCount($_SESSION['employee']['biblioteca_fk']);
        exit;
    }

    if (isset($_GET['employeeLibraryId'])) {
        echo $user->getUsersByEmployeeLibrary($_SESSION['employee']['biblioteca_fk']);
        exit;
    }

    if (isset($_GET['id'])) {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $user->setId($id);
        echo $user->getUserById($id);
        exit;
    }

    // Caso default: retorna todos os utilizadores
    if (!isset($_GET['id'])) {
        echo $user->getUsers($_SESSION['employee']['utilizador_fk']);
        exit;
    }
}

if (isset($_GET['profileId']) && isset($_POST['saveProfile'])) {

    $user->setId(filter_input(INPUT_GET, 'profileId', FILTER_SANITIZE_NUMBER_INT));
    $user->setFirstName(filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS));
    $user->setLastName(filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS));
    $user->setNif(filter_input(INPUT_POST, 'nif', FILTER_SANITIZE_SPECIAL_CHARS));
    $user->setCc(filter_input(INPUT_POST, 'cc', FILTER_SANITIZE_SPECIAL_CHARS));
    $user->setPhoneNumber(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS));
    $user->setAddress(filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS));
    $user->setUsername(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
    $user->setEmail(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));

    $libraries = $_POST['libraries'] ?? [];
    $libraries = array_filter(array_map(function ($libraryId) {
        return filter_var($libraryId, FILTER_SANITIZE_NUMBER_INT);
    }, $libraries));

    echo $user->updateProfile($user->getId(), $libraries);
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

    $passwordRaw = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $passwordHashed = password_hash($passwordRaw, PASSWORD_DEFAULT);
    $user->setPassword($passwordHashed);

    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->setRole($role);

    $libraryId = filter_input(INPUT_POST, 'librarySelect', FILTER_SANITIZE_SPECIAL_CHARS);
    $libraries = $_POST['libraries'] ?? [];
    $libraries = array_filter(array_map(function ($libraryId) {
        return filter_var($libraryId, FILTER_SANITIZE_NUMBER_INT);
    }, $libraries));
    if (isset($_FILES["imgProfile"]) && $_FILES["imgProfile"]["tmp_name"] != "") {
        $imgPath = $utils::uploadImage('../../administrative/users/upload', 'imgProfile');

        $user->setImgUrl($imgPath);
    }
    if (!empty($id)) {
        $user->setId($id);
        if ($role === 'Administrador')
            echo $user->updateUserByAdm($id, $libraries);
        else
            echo $user->updateUserByEmployee($id, $libraryId);
        exit;
    }

    $user->setActive('P');
    if ($userRole === 'Administrador')
        echo $user->newUserByAdm($libraries);
    else
        echo $user->newUserByEmployee($libraryId);
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

if (isset($_POST['changePassword'])) {
    $profileId = filter_input(INPUT_POST, 'profileId', FILTER_SANITIZE_NUMBER_INT);

    $currentPasswordRaw = filter_input(INPUT_POST, 'currentPassword', FILTER_SANITIZE_SPECIAL_CHARS);
    $newPasswordRaw = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmPasswordRaw = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_SPECIAL_CHARS);

    $user->setId($profileId);
    echo $user->changePassword(
        $user->getId(),
        $currentPasswordRaw,
        $newPasswordRaw,
        $confirmPasswordRaw
    );
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

