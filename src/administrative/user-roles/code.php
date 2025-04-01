<?php

header('Content-Type: application/json');
include_once '../../php/classes/UserRole.php';


if (isset($_GET['roleId'])) {
    $id = filter_input(INPUT_GET, 'roleId', FILTER_SANITIZE_NUMBER_INT);

    $userRole = new UserRole();
    $userRole->setId($id);

    echo $userRole->getUserRoleById($id);
}

if (isset($_POST['saveUserRole'])) {
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

    $userRole = new UserRole();
    $userRole->setRole($role);
    $userRole->setDescription($description);

    echo $userRole->newUserRole();
}
