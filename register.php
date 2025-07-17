<?php
// register.php — versão “normal”

header('Content-Type: application/json; charset=utf-8');
session_start();
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

// Só POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success'=>false,'message'=>'Este endpoint aceita apenas POST.']);
    exit;
}

// Decodifica JSON
$data = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success'=>false,'message'=>'JSON inválido: ' . json_last_error_msg()]);
    exit;
}

// Valida campos
if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
    echo json_encode(['success'=>false,'message'=>'Todos os campos são obrigatórios.']);
    exit;
}
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success'=>false,'message'=>'Por favor, insira um email válido.']);
    exit;
}

// Conecta ao Mongo
$users = getMongoCollection('users');
if ($users->findOne(['email'=>$data['email']])) {
    echo json_encode(['success'=>false,'message'=>'Este email já está em uso.']);
    exit;
}

// Insere usuário
$hash = password_hash($data['password'], PASSWORD_BCRYPT);
$res  = $users->insertOne([
    'name'=>$data['name'],
    'email'=>$data['email'],
    'password'=>$hash,
    'createdAt'=>new MongoDB\BSON\UTCDateTime()
]);

if ($res->getInsertedCount() === 1) {
    echo json_encode(['success'=>true,'message'=>'Registro realizado com sucesso!']);
} else {
    echo json_encode(['success'=>false,'message'=>'Ocorreu um erro ao registrar.']);
}
exit;
