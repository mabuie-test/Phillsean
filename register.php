<?php
// register.php
require 'mongo_conn.php';
header('Content-Type: application/json');

// Garante que estamos recebendo um POST JSON
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success'=>false,'message'=>'Método não permitido']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// Validações
if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
    echo json_encode(['success'=>false,'message'=>'Todos os campos são obrigatórios.']);
    exit;
}
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success'=>false,'message'=>'Por favor, insira um email válido.']);
    exit;
}

$users = getMongoCollection('users');

// Verifica email já cadastrado
if ($users->findOne(['email' => $data['email']])) {
    echo json_encode(['success'=>false,'message'=>'Este email já está em uso.']);
    exit;
}

// Insere usuário com senha hashed
$hash   = password_hash($data['password'], PASSWORD_BCRYPT);
$result = $users->insertOne([
    'name'      => $data['name'],
    'email'     => $data['email'],
    'password'  => $hash,
    'createdAt' => new MongoDB\BSON\UTCDateTime()
]);

if ($result->getInsertedCount() === 1) {
    echo json_encode(['success'=>true,'message'=>'Registro realizado com sucesso!']);
} else {
    echo json_encode(['success'=>false,'message'=>'Ocorreu um erro ao registrar.']);
}
