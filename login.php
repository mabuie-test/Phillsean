<?php
// login.php — buffer + sem saída HTML

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

// 5) Valida campos
if (empty($data['email']) || empty($data['password'])) {
    ob_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success'=>false,'message'=>'Email e senha são obrigatórios.']);
    exit;
}

// 6) Busca usuário
$users = getMongoCollection('users');
$user  = $users->findOne(['email'=>$data['email']]);

if (!$user || !password_verify($data['password'], $user->password)) {
    ob_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success'=>false,'message'=>'Credenciais inválidas.']);
    exit;
}

// 7) Autentica
$_SESSION['user'] = [
    'id'    => (string)$user->_id,
    'name'  => $user->name,
    'email' => $user->email
];

// 8) Resposta sucesso
ob_clean();
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['success'=>true,'message'=>'Login efetuado com sucesso.']);
exit;
