<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

// Inicia a sessão apenas aqui
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'GET') {
    // Acesso via navegador
    echo json_encode([
        'success' => false,
        'message' => 'Este endpoint aceita apenas POST. Use uma requisição AJAX ou cliente REST.' 
    ]);
    exit;
}
if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['success'=>false,'message'=>'Método não permitido']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// validações...
if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
    echo json_encode(['success'=>false,'message'=>'Todos os campos são obrigatórios.']);
    exit;
}
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success'=>false,'message'=>'Email inválido.']);
    exit;
}

$users = getMongoCollection('users');
if ($users->findOne(['email' => $data['email']])) {
    echo json_encode(['success'=>false,'message'=>'Email já em uso.']);
    exit;
}

$hash = password_hash($data['password'], PASSWORD_BCRYPT);
$res  = $users->insertOne([
    'name'      => $data['name'],
    'email'     => $data['email'],
    'password'  => $hash,
    'createdAt' => new MongoDB\BSON\UTCDateTime()
]);

if ($res->getInsertedCount() === 1) {
    echo json_encode(['success'=>true,'message'=>'Registro realizado com sucesso!']);
} else {
    echo json_encode(['success'=>false,'message'=>'Erro ao registrar.']);
}
exit;
