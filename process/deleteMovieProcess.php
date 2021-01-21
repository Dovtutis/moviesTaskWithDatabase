<?php
require "../Class/DB.php";
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id = $_GET['id'];
    $db->deleteMovie($id);
    header('Content-Type:application/json');
    echo $jsonResponse = json_encode('Movie deleted successfully');
}

$db->closeConnection();