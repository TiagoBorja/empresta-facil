<?php
session_start();
header('Content-Type: application/json');
include_once '../classes/Employee.php';
include_once '../classes/User.php';

$employee = new Employee();
$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $employee->getAll();
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $employee->setId($id);
    echo $employee->getById($id);
    exit;
}

if (isset($_POST['saveData'])) {

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $userFk = filter_input(INPUT_POST, 'users', FILTER_SANITIZE_NUMBER_INT);
    $libraryFk = filter_input(INPUT_POST, 'library', FILTER_SANITIZE_NUMBER_INT);
    $pickUpDate = filter_input(INPUT_POST, 'pickUpDate', filter: FILTER_SANITIZE_SPECIAL_CHARS);

    $userResultJson = $user->getUserById($userFk);
    $userResult = json_decode($userResultJson, true);

    if ($userResult && isset($userResult['data']['tipo']) && $userResult['data']['tipo'] === 'Administrador') {
        $libraryFk = null;
    }

    $employee->setUserFk($userFk);
    $employee->setLibraryFk($libraryFk);

    if (!empty($id)) {
        $employee->setId($id);
        echo $employee->update($id);
        exit;
    }
    echo $employee->create();

    exit;
}

if (isset($_POST['changeStatus'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);
    $status = ($status === 'Y') ? 'N' : 'Y';

    $employee->setId($id);
    $employee->setActive($status);

    echo $employee->changeActiveStatus($id, $status);
    exit;
}