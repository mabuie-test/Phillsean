<?php
// login.php

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

// 7) Valida campos
if (empty($data['email']) || empty($data['password'])) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Email e senha são obrigatórios.']);
    exit;
}

// 8) Busca usuário
$users = getMongoCollection('users');
$user  = $users->findOne(['email' => $data['email']]);

if (!$user || !password_verify($data['password'], $user->password)) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Credenciais inválidas.']);
    exit;
}

// 9) Autentica na sessão
$_SESSION['user'] = [
    'id'    => (string)$user->_id,
    'name'  => $user->name,
    'email' => $user->email
];

// 10) Retorna sucesso
ob_clean();
echo json_encode(['success' => true, 'message' => 'Login efetuado com sucesso.']);
exit;
