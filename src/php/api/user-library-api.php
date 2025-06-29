<?php
header('Content-Type: application/json; charset=utf-8');

include_once '../../php/classes/UserLibrary.php';

$userLibrary = new UserLibrary();

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    echo $userLibrary->getLibrariesByUserId($id);
    exit;
}

if (isset($_POST['validationSubmit'])) {

    $userId = filter_input(INPUT_POST, 'userIdInput', FILTER_SANITIZE_NUMBER_INT);
    $code = filter_input(INPUT_POST, 'validationCodeInput', FILTER_UNSAFE_RAW);

    $userLibrary->setValidationCode($code);

    echo $userLibrary->confirmValidationCode($userId);
    exit;
}
