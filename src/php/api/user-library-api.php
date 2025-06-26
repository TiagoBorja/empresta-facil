<?php
header('Content-Type: application/json');
include_once '../../php/classes/UserLibrary.php';

$userLibrary = new UserLibrary();

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    echo $userLibrary->getLibrariesByUserId($id);
    exit;
}