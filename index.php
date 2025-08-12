<?php

require_once __DIR__ . '/vendor/autoload.php';

use Controller\MovieController;
$movieController = new MovieController();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) 
{
    case 'GET':
        if (isset($_GET['id']) && !empty($_GET['id'])) {
        $movieController->getMovieById(); 
    } else {
        $movieController->getMovies(); 
    }
    break;
    case 'POST':
        $movieController->addMovie();
        break;
    case 'PUT':
        $movieController->editMovie();
        break;
    case 'DELETE':
        $movieController->deleteMovie();
        break;
    default:
    echo json_encode(["message" => "Method not allowed"]);
        break;
}


?>