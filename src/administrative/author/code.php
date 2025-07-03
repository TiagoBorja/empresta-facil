<?php

header('Content-Type: application/json');
include_once '../../php/classes/Author.php';
include_once '../../php/classes/Utils.php';

$author = new Author();
$utils = new Utils();
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $author->getAll();
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $author->setId($id);
    echo $author->getById($id);
    exit;
}


if (isset($_POST['saveData'])) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?: filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
    $author->setFirstName($firstName);

    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
    $author->setLastName($lastName);

    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_SPECIAL_CHARS);
    $author->setGender($gender);

    $birthDay = filter_input(INPUT_POST, 'birthDay', FILTER_SANITIZE_SPECIAL_CHARS);
    $author->setBirthDay($birthDay);

    $biography = filter_input(INPUT_POST, 'biography', FILTER_SANITIZE_SPECIAL_CHARS);
    $author->setBiography($biography);

    $nationality = filter_input(INPUT_POST, 'nationality', FILTER_SANITIZE_SPECIAL_CHARS);
    $author->setNationality($nationality);

    if (isset($_FILES["imgProfile"]) && $_FILES["imgProfile"]["tmp_name"] != "") {
        $imgPath = $utils::uploadImage('../../administrative/author/upload', 'imgProfile');

        $author->setImgUrl($imgPath);
    }

    if (!empty($id)) {
        $author->setId($id);
        echo $author->update($id);
        exit;
    }

    echo $author->create();
    exit;
}

if (isset($_POST['changeStatus'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);
    $status = ($status === 'Y') ? 'N' : 'Y';

    $author->setId($id);
    $author->setActive($status);

    echo $author->changeActiveStatus($id, $status);
    exit;
}
