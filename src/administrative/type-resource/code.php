<?php

header('Content-Type: application/json');
include_once '../../php/classes/TypeResource.php';

$typeResource = new TypeResource();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $typeResource->getAll();
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $typeResource->setId($id);
    echo $typeResource->getById($id);
    exit;
}


if (isset($_POST['saveData'])) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?: filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

    $typeResource->setType($type);
    $typeResource->setDescription($description);

    if (!empty($id)) {
        $typeResource->setId($id);
        echo $typeResource->update($id);
        exit;
    }

    echo $typeResource->create();
    exit;
}

if (isset($_POST['changeStatus'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);
    $status = ($status === 'Y') ? 'N' : 'Y';

    $typeResource->setId($id);
    $typeResource->setActive($status);

    echo $typeResource->changeActiveStatus($id, $status);
    exit;
}