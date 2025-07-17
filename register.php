<?php
require 'mongo_conn.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
    echo json_encode(['success'=>false,'message'=>'Todos os campos são obrigatórios.']);
    exit;
}
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success'=>false,'message'=>'Email inválido.']);
    exit;
}

$col = getMongoCollection('users');
if ($col->findOne(['email'=>$data['email']])) {
    echo json_encode(['success'=>false,'message'=>'Email já cadastrado.']);
    exit;
}

$hash = password_hash($data['password'], PASSWORD_BCRYPT);
$res  = $col->insertOne([
    'name'=>$data['name'],
    'email'=>$data['email'],
    'password'=>$hash,
    'createdAt'=>new MongoDB\BSON\UTCDateTime()
]);

echo json_encode([
  'success'=> $res->getInsertedCount()===1,
  'message'=> $res->getInsertedCount()===1
    ? 'Registro realizado com sucesso!'
    : 'Erro ao registrar.'
]);
