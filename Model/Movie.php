<?php

namespace Model;

use PDO;
use Model\Connection;

class Movie
{
    private $conn;
    public $id;
    public $name;
    public $genre;
    public $year_launch;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }


    public function getMovies()
    {
        $sql = "SELECT * FROM movies";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getMovieById()
    {
        $sql = "SELECT * FROM movies WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMoviesByName()
    {
        $sql = "SELECT * FROM movies WHERE name LIKE :name";
        $stmt = $this->conn->prepare($sql);
        $search = "%" . $this->name . "%";
        $stmt->bindParam(":name", $search, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMoviesByYear()
    {
        $sql = "SELECT * FROM movies WHERE year_launch = :year_launch";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":year_launch", $this->year_launch, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMoviesByGenre()
    {
        $sql = "SELECT * FROM movies WHERE genre LIKE :genre";
        $stmt = $this->conn->prepare($sql);
        $search = "%" . $this->genre . "%";
        $stmt->bindParam(":genre", $search, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    public function addMovie()
    {
        $sql = "INSERT INTO movies (name, genre, year_launch) VALUES (:name, :genre, :year_launch)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindParam(":genre", $this->genre, PDO::PARAM_STR);
        $stmt->bindParam(":year_launch", $this->year_launch, PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function editMovie()
    {
        $sql = "UPDATE movies SET name = :name, genre = :genre, year_launch = :year_launch WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindParam(":genre", $this->genre, PDO::PARAM_STR);
        $stmt->bindParam(":year_launch", $this->year_launch, PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function deleteMovie()
    {
        $sql = "DELETE FROM movies WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}


?>