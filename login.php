<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'GET') {
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

if (empty($data['email']) || empty($data['password'])) {
    echo json_encode(['success'=>false,'message'=>'Email e senha são obrigatórios.']);
    exit;
}

$users = getMongoCollection('users');
$user  = $users->findOne(['email' => $data['email']]);

if (!$user || !password_verify($data['password'], $user->password)) {
    echo json_encode(['success'=>false,'message'=>'Credenciais inválidas.']);
    exit;
}

$_SESSION['user'] = [
    'id'    => (string)$user->_id,
    'name'  => $user->name,
    'email' => $user->email
];

echo json_encode(['success'=>true,'message'=>'Login efetuado com sucesso.']);
exit;
