<?php


class DB
{
    private $serverName = 'localhost';
    private $userName = 'root';
    private $password = '';
    private $databaseName = 'movies_database';
    public $connection;

    public function __construct()
    {
        $this->connection = new mysqli($this->serverName, $this->userName, $this->password, $this->databaseName);

        if ($this->connection->connect_error){
            die('Sugriuvo serveris: ' . $this->connection->connect_error);
        }
    }

    public function addMovie($image, $title, $year, $genre)
    {
        $sql = "
        INSERT INTO movies(`img`, `title`, `year`, `genre`)
        VALUES ('$image', '$title', '$year', '$genre')
        ";

        $this->connection->query($sql);
    }

    public function getMovies()
    {
        $sql = "SELECT * FROM movies";
        $mysqliResultObj = $this->connection->query($sql);

        if ($mysqliResultObj->num_rows>0){
            return $mysqliResultObj->fetch_all(MYSQLI_ASSOC);
        }
    }
}