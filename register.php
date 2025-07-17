<?php
// register.php

// 1) Inicia buffer e desativa exibição de erros no output
ob_start();
ini_set('display_errors', 0);
error_reporting(0);

// 2) Header JSON
header('Content-Type: application/json; charset=utf-8');

// 3) Sessão
session_start();

// 4) Autoload Composer e conexão Mongo
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

// 5) Apenas POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Este endpoint aceita apenas POST.']);
    exit;
}

// 6) Lê e decodifica o corpo JSON
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'JSON inválido: ' . json_last_error_msg()]);
    exit;
}

// 7) Valida campos obrigatórios
if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
    exit;
}
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Por favor, insira um email válido.']);
    exit;
}

// 8) Conecta à coleção users
$users = getMongoCollection('users');

// 9) Verifica duplicado
if ($users->findOne(['email' => $data['email']])) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Este email já está em uso.']);
    exit;
}

// 10) Insere novo usuário
$hash = password_hash($data['password'], PASSWORD_BCRYPT);
$res  = $users->insertOne([
    'name'      => $data['name'],
    'email'     => $data['email'],
    'password'  => $hash,
    'createdAt' => new MongoDB\BSON\UTCDateTime()
]);

// 11) Retorna resultado
ob_clean();
if ($res->getInsertedCount() === 1) {
    echo json_encode(['success' => true, 'message' => 'Registro realizado com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao registrar.']);
}
exit;
