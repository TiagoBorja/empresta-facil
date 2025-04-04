<?php

header('Content-Type: application/json');
include_once '../../php/classes/UserRole.php';


if (isset($_GET['roleId'])) {
    $id = filter_input(INPUT_GET, 'roleId', FILTER_SANITIZE_NUMBER_INT);

    $userRole = new UserRole();
    $userRole->setId($id);

    echo $userRole->getUserRoleById($id);
}

if (isset($_POST['saveData'])) {

    $id = filter_input(INPUT_GET, 'roleId', FILTER_SANITIZE_NUMBER_INT);

    if (empty($id)) {
        $id = filter_input(INPUT_POST, 'roleId', FILTER_SANITIZE_NUMBER_INT);
    }

    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

    $userRole = new UserRole();
    if (!empty($id)) {
        $userRole->setId($id);
        $userRole->setRole($role);
        $userRole->setDescription($description);

        echo $userRole->updateUserRole($id);
    } else {

        $userRole->setRole($role);
        $userRole->setDescription($description);

        echo $userRole->newUserRole();
    }
}

if (isset($_POST['changeStatus'])) {
    $id = filter_input(INPUT_POST, 'roleId', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);

    $status = ($status === 'Y') ? 'N' : 'Y'; 

    $userRole = new UserRole();

    $userRole->setId($id);
    $userRole->setActive($status);

    echo $userRole->changeActiveStatus($id, $status);
}
