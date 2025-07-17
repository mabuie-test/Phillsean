<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success'=>false,'message'=>'Este endpoint aceita apenas POST.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (empty($data['email']) || empty($data['password'])) {
    echo json_encode(['success'=>false,'message'=>'Email e senha são obrigatórios.']);
    exit;
}

$users = getMongoCollection('users');
$user  = $users->findOne(['email'=>$data['email']]);

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
