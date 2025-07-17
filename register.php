<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1) força o JSON e inicia sessão
header('Content-Type: application/json');
session_start();

// 2) carrega autoload e conexão
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success'=>false,'message'=>'Método não permitido']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// 3) valida
if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
    echo json_encode(['success'=>false,'message'=>'Todos os campos são obrigatórios.']);
    exit;
}
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success'=>false,'message'=>'Email inválido.']);
    exit;
}

// 4) insere no Mongo
$users = getMongoCollection('users');
if ($users->findOne(['email' => $data['email']])) {
    echo json_encode(['success'=>false,'message'=>'Email já em uso.']);
    exit;
}

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
    echo json_encode(['success'=>false,'message'=>'Erro ao registrar.']);
}
exit;
