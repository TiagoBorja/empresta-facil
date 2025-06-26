<?php

header('Content-Type: application/json');
include_once '../../php/classes/Library.php';

$library = new Library();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $onlyActive = isset($_GET['activeOnly']) && $_GET['activeOnly'] === 'true';
    echo $library->getAll($onlyActive);
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $library->setId($id);
    echo $library->getById($id);
    exit;
}


if (isset($_POST['saveData'])) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?: filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    $postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_SPECIAL_CHARS);

    $library->setName($name);
    $library->setAddress($address);
    $library->setPostalCode($postalCode);

    if (!empty($id)) {
        $library->setId($id);
        echo $library->update($id);
        exit;
    }

    echo $library->create();
    exit;
}

if (isset($_POST['changeStatus'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);
    $status = ($status === 'Y') ? 'N' : 'Y';

    $library->setId($id);
    $library->setActive($status);

    echo $library->changeActiveStatus($id, $status);
    exit;
}