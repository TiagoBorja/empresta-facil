<?php

header('Content-Type: application/json');
include_once '../../php/classes/State.php';

$stateClass = new State();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $stateClass->getStates();
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $stateClass->setId($id);
    echo $stateClass->getStateById($id);
    exit;
}

if (isset($_POST['saveData'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?: filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_SPECIAL_CHARS);
    $observation = filter_input(INPUT_POST, 'observation', FILTER_SANITIZE_SPECIAL_CHARS);

    $stateClass->setState($state);
    $stateClass->setObservation($observation);

    if (!empty($id)) {
        $stateClass->setId($id);
        echo $stateClass->updateState($id);
    } else {
        echo $stateClass->newState();
    }
    exit;
}