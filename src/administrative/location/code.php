<?php

header('Content-Type: application/json');
include_once '../../php/classes/Location.php';
session_start();
$location = new Location();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $onlyActive = isset($_GET['activeOnly']) && $_GET['activeOnly'] === 'true';
    echo $location->getAll($onlyActive, $_SESSION['employee']['biblioteca_fk']);
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $location->setId($id);
    echo $location->getById($id);
    exit;
}


if (isset($_POST['saveData'])) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?: filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $locationCode = filter_input(INPUT_POST, 'locationCode', FILTER_SANITIZE_SPECIAL_CHARS);
    $libraryFk = filter_input(INPUT_POST, 'library', FILTER_SANITIZE_SPECIAL_CHARS);

    $location->setLocationCode($locationCode);
    $location->setLibrary($libraryFk);

    if (!empty($id)) {
        $location->setId($id);
        echo $location->update($id);
        exit;
    }

    echo $location->create();
    exit;
}

if (isset($_POST['changeStatus'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);
    $status = ($status === 'Y') ? 'N' : 'Y';

    $location->setId($id);
    $location->setActive($status);

    echo $location->changeActiveStatus($id, $status);
    exit;
}