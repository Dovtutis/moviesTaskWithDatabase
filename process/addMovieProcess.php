<?php
require "../Class/DB.php";
define('REQUIRED_FIELD_ERROR', 'This field is required');
$db = new DB();
$errors = [];
$image = '';
$title = '';
$year = '';
$genre = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $image = post_data("image");
    $title = post_data("title");
    $year = post_data("year");
    $genre = post_data("genre");

    if (!$image){
        $errors['image'] = REQUIRED_FIELD_ERROR;
    }
    if (!$title){
        $errors['title'] = REQUIRED_FIELD_ERROR;
    }
    if (!$year){
        $errors['year'] = REQUIRED_FIELD_ERROR;
    }

    if (empty($errors)){
        $db->addMovie($image, $title, $year, $genre);
        header('Content-Type:application/json');
        echo $jsonResponse = json_encode('Movie added');
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

