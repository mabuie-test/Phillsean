<?php
require 'mongo_conn.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['email'])||empty($data['password'])) {
    echo json_encode(['success'=>false,'message'=>'Email e senha são obrigatórios.']);
    exit;
}

$col = getMongoCollection('users');
$user = $col->findOne(['email'=>$data['email']]);
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
