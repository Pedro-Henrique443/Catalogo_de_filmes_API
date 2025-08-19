<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret = "1234"; 

function gerarToken($usuario) {
    global $secret;
    $payload = [
        "usuario" => $usuario,
        "iat" => time(),
        "exp" => time() + 3600 // expira em 1h
    ];
    return JWT::encode($payload, $secret, 'HS256');
}

// function autenticarToken() {
//     global $secret;

//     $headers = getallheaders();
//     if (!isset($headers['Authorization'])) {
//         http_response_code(401);
//         echo json_encode(["mensagem" => "Token não fornecido"]);
//         exit;
//     }

//     $authHeader = $headers['Authorization'];
//     $token = str_replace("Bearer ", "", $authHeader);

//     try {
//         $decoded = JWT::decode($token, new Key($secret, 'HS256'));
//         return $decoded;
//     } catch (Exception $e) {
//         http_response_code(403);
//         echo json_encode(["mensagem" => "Token inválido ou expirado"]);
//         exit;
//     }
// }

function autenticarToken($secret) {
    $headers = [];

    
    if (function_exists('getallheaders')) {
        $headers = getallheaders();
    }

    if (isset($_SERVER['Authorization'])) {
        $headers['Authorization'] = $_SERVER['Authorization'];
    } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $headers['Authorization'] = $_SERVER['HTTP_AUTHORIZATION'];
    }

    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["mensagem" => "Token não fornecido"]);
        exit;
    }

    $authHeader = $headers['Authorization'];
    $token = str_replace("Bearer ", "", $authHeader);

    try {
        $decoded = Firebase\JWT\JWT::decode($token, new Firebase\JWT\Key($secret, 'HS256'));
        return $decoded;
    } catch (Exception $e) {
        http_response_code(403);
        echo json_encode(["mensagem" => "Token inválido ou expirado", "erro" => $e->getMessage()]);
        exit;
    }
}

?>