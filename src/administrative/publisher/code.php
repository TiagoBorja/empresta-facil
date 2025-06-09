<?php

header('Content-Type: application/json');
include_once '../../php/classes/Publisher.php';

$publisher = new Publisher();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $onlyActive = isset($_GET['activeOnly']) && $_GET['activeOnly'] === 'true';
    $returnedId = isset($_GET['returnedId']) ? (int) $_GET['returnedId'] : null;

    echo $publisher->getAll($onlyActive, $returnedId);
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $publisher->setId($id);
    echo $publisher->getById($id);
    exit;
}


if (isset($_POST['saveData'])) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?: filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $publisherName = filter_input(INPUT_POST, 'publisherName', FILTER_SANITIZE_SPECIAL_CHARS);

    $publisher->setPublisher($publisherName);

    if (!empty($id)) {
        $publisher->setId($id);
        echo $publisher->update($id);
        exit;
    }

    echo $publisher->create();
    exit;
}

if (isset($_POST['changeStatus'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);
    $status = ($status === 'Y') ? 'N' : 'Y';

    $publisher->setId($id);
    $publisher->setActive($status);

    echo $publisher->changeActiveStatus($id, $status);
    exit;
}