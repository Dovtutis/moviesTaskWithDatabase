<?php
require "../Class/DB.php";
define('REQUIRED_FIELD_ERROR', 'This field is required');
$connection = mysqli_connect('localhost', 'root', '', 'movies_database');
$db = new DB();
$errors = [];
$btnName = htmlspecialchars($_POST['btnName']);
$id = htmlspecialchars($_POST['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $image = post_data("image");
    $title = post_data("title");
    $image = mysqli_real_escape_string($connection, $image);
    $title = mysqli_real_escape_string($connection, $title);
    $year = post_data("year");
    $genre = post_data("genre");

    if (!$image){
        $errors['image'] = REQUIRED_FIELD_ERROR;
    } else {
        if (!filter_var($image, FILTER_VALIDATE_URL)) {
            $errors['image'] = "URL is not a valid URL";
        }
    }
    if (!$title){
        $errors['title'] = REQUIRED_FIELD_ERROR;
    }
    if (!$year){
        $errors['year'] = REQUIRED_FIELD_ERROR;
    }

    if (empty($errors)) {
        if ($btnName === 'edit') {
            $db->editMovie($image, $title, $year, $genre, $id);
//            $array = [$image, $title, $year, $genre, $id];
            header('Content-Type:application/json');
            echo $jsonResponse = json_encode('Movie edited successfully');
        } else {
            $db->addMovie($image, $title, $year, $genre);
            header('Content-Type:application/json');
            echo $jsonResponse = json_encode('Movie added successfully');
        }
    } else{
        $jsonResponse['errors'] = $errors;
        header('Content-Type:application/json');
        echo $jsonResponse = json_encode($jsonResponse);
    }
}

function post_data($field)
{
    $_POST[$field] ??= false;
    return htmlspecialchars(stripslashes($_POST[$field]));
}

$db->closeConnection();

