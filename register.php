<?php
// register.php — mesma lógica de buffer + JSON apenas

ini_set('display_errors', 0);
error_reporting(0);

if (ob_get_length()) {
    ob_clean();
}

header('Content-Type: application/json; charset=utf-8');
session_start();

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success'=>false,'message'=>'Este endpoint aceita apenas POST.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
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
