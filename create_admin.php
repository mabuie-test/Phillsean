<?php
// create_admin.php

// 1) Desliga exib. de erros e força JSON
ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');

// 2) Só POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success'=>false,'message'=>'Use POST']);
    exit;
}

// 3) Verifica token secreto
// Defina UM TOKEN FORTE e único, e depois remova este arquivo!
define('ADMIN_TOKEN', 'COLOQUE_AQUI_SEU_TOKEN_SUPER_SECRETO');
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['token']) || $input['token'] !== ADMIN_TOKEN) {
    http_response_code(403);
    echo json_encode(['success'=>false,'message'=>'Token inválido']);
    exit;
}

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

use MongoDB\BSON\UTCDateTime;

// 4) Valida campos do payload
foreach (['name','email','password'] as $f) {
    if (empty($input[$f])) {
        http_response_code(422);
        echo json_encode(['success'=>false,'message'=>"Campo faltando: $f"]);
        exit;
    }
}
if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['success'=>false,'message'=>'Email inválido']);
    exit;
}

// 5) Gera hash da senha
$hash = password_hash($input['password'], PASSWORD_BCRYPT);

// 6) Insere no Mongo
$users  = getMongoCollection('users');
$result = $users->insertOne([
    'name'      => $input['name'],
    'email'     => $input['email'],
    'password'  => $hash,
    'role'      => 'admin',
    'createdAt' => new UTCDateTime()
]);

if ($result->getInsertedCount() !== 1) {
    http_response_code(500);
    echo json_encode(['success'=>false,'message'=>'Falha ao criar admin']);
    exit;
}

// 7) Sucesso
echo json_encode([
    'success' => true,
    'message' => 'Admin criado com sucesso',
    'id'      => (string)$result->getInsertedId()
]);
exit;
