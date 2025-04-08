<?php

header('Content-Type: application/json');
include_once '../../php/classes/UserRole.php';

$userRole = new UserRole();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $userRole->getUserRole();
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $userRole->setId($id);
    echo $userRole->getUserRoleById($id);
    exit;
}


if (isset($_POST['saveData'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?: filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

    $userRole->setRole($role);
    $userRole->setDescription($description);

    if (!empty($id)) {
        $userRole->setId($id);
        echo $userRole->updateUserRole($id);
    } else {
        echo $userRole->newUserRole();
    }
    exit;
}

if (isset($_POST['changeStatus'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);
    $status = ($status === 'Y') ? 'N' : 'Y';

    $userRole->setId($id);
    $userRole->setActive($status);

    echo $userRole->changeActiveStatus($id, $status);
    exit;
}