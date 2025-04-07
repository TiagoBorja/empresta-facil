<?php

header('Content-Type: application/json');
include_once '../../php/classes/UserRole.php';

$userRole = new UserRole();
if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    $userRole->setId($id);

    echo $userRole->getUserRoleById($id);
} else {
    echo $userRole->getUserRole();
}


if (isset($_POST['saveData'])) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    if (empty($id)) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    }

    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

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
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);

    $status = ($status === 'Y') ? 'N' : 'Y';

    $userRole->setId($id);
    $userRole->setActive($status);

    echo $userRole->changeActiveStatus($id, $status);
}
