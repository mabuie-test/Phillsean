<?php
// register.php — buffer + sem saída HTML

// 1) Inicia buffer e desativa erros no output
ob_start();
ini_set('display_errors', 0);
error_reporting(0);

// 2) Sessão e autoload
session_start();
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

// 3) Só POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success'=>false,'message'=>'Este endpoint aceita apenas POST.']);
    exit;
}

// 4) Lê e decodifica JSON
$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    ob_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success'=>false,'message'=>'JSON inválido: '.json_last_error_msg()]);
    exit;
}

// 5) Validações
if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
    ob_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success'=>false,'message'=>'Todos os campos são obrigatórios.']);
    exit;
}
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    ob_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success'=>false,'message'=>'Por favor, insira um email válido.']);
    exit;
}

// 6) Checa duplicado
$users = getMongoCollection('users');
if ($users->findOne(['email'=>$data['email']])) {
    ob_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success'=>false,'message'=>'Este email já está em uso.']);
    exit;
}

// 7) Insere usuário
$hash = password_hash($data['password'], PASSWORD_BCRYPT);
$res  = $users->insertOne([
    'name'=>$data['name'],
    'email'=>$data['email'],
    'password'=>$hash,
    'createdAt'=>new MongoDB\BSON\UTCDateTime()
]);

// 8) Resposta final
ob_clean();
header('Content-Type: application/json; charset=utf-8');

if ($res->getInsertedCount() === 1) {
    echo json_encode(['success'=>true,'message'=>'Registro realizado com sucesso!']);
} else {
    echo json_encode(['success'=>false,'message'=>'Ocorreu um erro ao registrar.']);
}
exit;
