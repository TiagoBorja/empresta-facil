<?php
session_start();
header('Content-Type: application/json');
include_once '../../php/classes/Subcategory.php';

$subcategoryClass = new Subcategory();
$userId = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id']) && !isset($_GET['categoryId'])) {
    $onlyActive = isset($_GET['activeOnly']) && $_GET['activeOnly'] === 'true';
    $returnedId = isset($_GET['returnedId']) ? (int) $_GET['returnedId'] : null;
    echo $subcategoryClass->getAll($onlyActive, $returnedId);
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $subcategoryClass->setId($id);
    echo $subcategoryClass->getById($id);
    exit;
}

if (isset($_GET['categoryId'])) {
    $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
    echo $subcategoryClass->getByCategoryId($categoryId);
    exit;
}


if (isset($_POST['saveData'])) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?: filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS);
    $subcategory = filter_input(INPUT_POST, 'subcategory', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

    $subcategoryClass->setCategory($category);
    $subcategoryClass->setSubcategory($subcategory);
    $subcategoryClass->setDescription($description);
    $subcategoryClass->setCreatedFk($userId);

    if (!empty($id)) {
        $subcategoryClass->setId($id);
        $subcategoryClass->setUpdatedFk($userId);

        echo $subcategoryClass->update($id);
        exit;
    }

    echo $subcategoryClass->create();
    exit;
}

if (isset($_POST['changeStatus'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);
    $status = ($status === 'Y') ? 'N' : 'Y';

    $subcategoryClass->setId($id);
    $subcategoryClass->setActive($status);
    $subcategoryClass->setUpdatedFk($userId);

    echo $subcategoryClass->changeActiveStatus($id, $status);
    exit;
}