<?php

header('Content-Type: application/json');
include_once '../../classes/UserType.php';


if (isset($_POST['saveUserType'])) {
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

    $userType = new UserType();
    $userType->setType($type);
    $userType->setDescription($description);

    echo $userType->newUserType();
}
