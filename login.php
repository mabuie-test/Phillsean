<?php
// login.php
require 'mongo_conn.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success'=>false,'message'=>'Método não permitido']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// Validações
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

// Autentica usuário na sessão
$_SESSION['user'] = [
    'id'    => (string)$user->_id,
    'name'  => $user->name,
    'email' => $user->email
];

echo json_encode(['success'=>true,'message'=>'Login efetuado com sucesso.']);
