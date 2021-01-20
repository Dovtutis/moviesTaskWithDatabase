<?php
require "../Class/DB.php";
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $movies = $db->getMovies();
    header('Content-Type:application/json');
    echo $jsonResponse = json_encode($movies);
}