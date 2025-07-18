<?php
// login.php
header('Content-Type: application/json; charset=utf-8');
session_start();
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

use MongoDB\BSON\ObjectId;

$input = json_decode(file_get_contents('php://input'), true);
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !is_array($input)) {
    http_response_code(400);
    echo json_encode(['success'=>false,'message'=>'Use POST com JSON']);
    exit;
}

// Busca usuário pelo email
$users = getMongoCollection('users');
$user  = $users->findOne(['email'=> $input['email']]);
if (!$user || !password_verify($input['password'], $user['password'])) {
    http_response_code(401);
    echo json_encode(['success'=>false,'message'=>'Credenciais inválidas']);
    exit;
}

// Grava na sessão
$_SESSION['user'] = [
  'id'    => (string)$user['_id'],
  'name'  => $user['name'],
  'role'  => $user['role']    // 'admin' ou 'user'
];

echo json_encode(['success'=>true,'message'=>'Login efetuado com sucesso']);
exit;
