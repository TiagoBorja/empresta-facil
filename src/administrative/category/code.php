<?php

header('Content-Type: application/json');
include_once '../../php/classes/Category.php';

$categoryClass = new Category();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $categoryClass->getCategories();
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $categoryClass->setId($id);
    echo $categoryClass->getCategoryById($id);
    exit;
}


if (isset($_POST['saveData'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?: filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

    $categoryClass->setCategory($category);
    $categoryClass->setDescription($description);

    if (!empty($id)) {
        $categoryClass->setId($id);
        echo $categoryClass->updateCategory($id);
    } else {
        echo $categoryClass->newCategory();
    }
    exit;
}

if (isset($_POST['changeStatus'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);
    $status = ($status === 'Y') ? 'N' : 'Y';

    $categoryClass->setId($id);
    $categoryClass->setActive($status);

    echo $categoryClass->changeActiveStatus($id, $status);
    exit;
}