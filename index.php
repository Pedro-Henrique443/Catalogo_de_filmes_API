<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/auth.php';

use Controller\MovieController;
$movieController = new MovieController();

$method = $_SERVER['REQUEST_METHOD'];

if (isset($_GET['rota']) && $_GET['rota'] === 'login' && $method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $usuario = $data['usuario'] ?? '';
    $senha = $data['senha'] ?? '';

    
    if ($usuario === "pedro" && $senha === "1234") {
        $token = gerarToken($usuario);
        echo json_encode(["token" => $token]);
    } else {
        http_response_code(401);
        echo json_encode(["mensagem" => "Credenciais inválidas"]);
    }
    exit;
}

switch ($method) 
{
    case 'GET':
    if (isset($_GET['id'])) {
        $movieController->getMovieById();
    } elseif (isset($_GET['name'])) {
        $movieController->getMoviesByName();
    } elseif (isset($_GET['year_launch'])) {
        $movieController->getMoviesByYear();
    } elseif (isset($_GET['genre'])) {
        $movieController->getMoviesByGenre();
    } else {
        $movieController->getMovies();
    }
    break;

    case 'POST':
        autenticarToken($secret);
        $movieController->addMovie();
        break;
    case 'PUT':
        autenticarToken($secret);
        $movieController->editMovie();
        break;
    case 'DELETE':
        autenticarToken($secret);
        $movieController->deleteMovie();
        break;
    default:
    echo json_encode(["message" => "Method not allowed"]);
        break;
}


?>