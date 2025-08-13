<?php

namespace Controller;

use Model\Movie;

require_once __DIR__ . '/../Config/Configuration.php';

class MovieController
{
    public function getMovies()
    {
        $movie = new Movie();
        $movies = $movie->getMovies();

        if ($movies) {

            header('Content-Type: application/json', true, 200);
            echo json_encode($movies);
        } else {
            header('Content-Type: application/json', true, 404);
            echo json_encode(["message" => "Sem filmes encontrados"]);
        }
    }

    public function getMovieById()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $movie = new Movie();
            $movie->id = $id;
            $result = $movie->getMovieById();

            if ($result) {
                header('Content-Type: application/json', true, 200);
                echo json_encode($result);
            } else {
                header('Content-Type: application/json', true, 404);
                echo json_encode(["message" => "Filme não encontrado"]);
            }
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(["message" => "ID inválido"]);
        }
    }

    public function getMoviesByName()
    {
        $name = $_GET['name'] ?? null;

        if ($name) {
            $movie = new Movie();
            $movie->name = $name;
            $result = $movie->getMoviesByName();

            if ($result) {
                header('Content-Type: application/json', true, 200);
                echo json_encode($result);
            } else {
                header('Content-Type: application/json', true, 404);
                echo json_encode(["message" => "Nenhum filme encontrado com esse nome"]);
            }
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(["message" => "Nome inválido"]);
        }
    }

    public function getMoviesByYear()
    {
        $year = $_GET['year_launch'] ?? null;

        if ($year) {
            $movie = new Movie();
            $movie->year_launch = $year;
            $result = $movie->getMoviesByYear();

            if ($result) {
                header('Content-Type: application/json', true, 200);
                echo json_encode($result);
            } else {
                header('Content-Type: application/json', true, 404);
                echo json_encode(["message" => "Nenhum filme encontrado nesse ano"]);
            }
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(["message" => "Ano inválido"]);
        }
    }

    public function getMoviesByGenre()
    {
        $genre = $_GET['genre'] ?? null;

        if ($genre) {
            $movie = new Movie();
            $movie->genre = $genre;
            $result = $movie->getMoviesByGenre();

            if ($result) {
                header('Content-Type: application/json', true, 200);
                echo json_encode($result);
            } else {
                header('Content-Type: application/json', true, 404);
                echo json_encode(["message" => "Nenhum filme encontrado com esse gênero"]);
            }
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(["message" => "Gênero inválido"]);
        }
    }




    public function addMovie()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->name) && isset($data->genre) && isset($data->year_launch)) {
            $movie = new Movie();
            $movie->name = $data->name;
            $movie->genre = $data->genre;
            $movie->year_launch = $data->year_launch;

            if ($movie->addMovie()) {
                header('Content-Type: application/json', true, 201);
                echo json_encode(["message" => "Filme adicionado com sucesso"]);
            } else {
                header('Content-Type: application/json', true, 500);
                echo json_encode(["message" => "Falha ao adicionar o filme"]);
            }
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(["message" => "Informações inválidas para o filme"]);
        }

    }

    public function editMovie()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->id) && isset($data->name) && isset($data->genre) && isset($data->year_launch)) {
            $movie = new Movie();
            $movie->id = $data->id;
            $movie->name = $data->name;
            $movie->genre = $data->genre;
            $movie->year_launch = $data->year_launch;

            if ($movie->editMovie()) {
                header('Content-Type: application/json', true, 200);
                echo json_encode(["message" => "Filme editado com sucesso"]);
            } else {
                header('Content-Type: application/json', true, 500);
                echo json_encode(["message" => "Falha ao editar o filme"]);
            }
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(["message" => "Informações invalidas do filme"]);
        }
    }

    public function deleteMovie()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $movie = new Movie();
            $movie->id = $id;

            if ($movie->deleteMovie()) {
                header("Content-Type: application/json", true, 200);
                echo json_encode(["message" => "Filme excluido com sucesso"]);
            } else {
                header("Content-Type: application/json", true, 500);
                echo json_encode(["message" => "Falha ao excluir o filme"]);
            }
        } else {
            header("Content-Type: application/json", true, 400);
            echo json_encode(["message" => "ID inválido"]);
        }
    }
}










?>