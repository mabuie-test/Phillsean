<?php
// login.php — somente JSON, sem nada mais antes ou depois

// 1) desativa display_errors em produção
ini_set('display_errors', 0);
error_reporting(0);

// 2) limpa qualquer saída anterior
if (ob_get_length()) {
    ob_clean();
}

// 3) header JSON
header('Content-Type: application/json; charset=utf-8');

// 4) session
session_start();

// 5) autoload e conexão
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

// 6) apenas POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success'=>false,'message'=>'Este endpoint aceita apenas POST.']);
    exit;
}

// 7) lê e valida payload
$data = json_decode(file_get_contents('php://input'), true);
if (empty($data['email']) || empty($data['password'])) {
    echo json_encode(['success'=>false,'message'=>'Email e senha são obrigatórios.']);
    exit;
}

// 8) busca usuário
$users = getMongoCollection('users');
$user  = $users->findOne(['email' => $data['email']]);

if (!$user || !password_verify($data['password'], $user->password)) {
    echo json_encode(['success'=>false,'message'=>'Credenciais inválidas.']);
    exit;
}

// 9) autentica
$_SESSION['user'] = [
    'id'    => (string)$user->_id,
    'name'  => $user->name,
    'email' => $user->email
];

// 10) responde sucesso
echo json_encode(['success'=>true,'message'=>'Login efetuado com sucesso.']);
exit;
