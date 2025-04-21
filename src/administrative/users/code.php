<?php

header('Content-Type: application/json');
include_once '../../php/classes/User.php';

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $user->getUsers();
    exit;
}