<?php
// register.php (debug)

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Sempre JSON
header('Content-Type: application/json; charset=utf-8');

try {
    // Só POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método inválido: use POST');
    }

    // Carrega sessões e libs
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    require __DIR__ . '/vendor/autoload.php';
    require __DIR__ . '/mongo_conn.php';

    // Lê JSON
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON inválido: ' . json_last_error_msg());
    }

    // Validações
    if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
        throw new Exception('Todos os campos são obrigatórios.');
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Email inválido.');
    }

    // Conecta ao Mongo
    $users = getMongoCollection('users');
    if (!$users) {
        throw new Exception('Não foi possível obter a coleção users.');
    }

    // Verifica duplicado
    if ($users->findOne(['email' => $data['email']])) {
        throw new Exception('Email já em uso.');
    }

    // Insere
    $hash = password_hash($data['password'], PASSWORD_BCRYPT);
    $res  = $users->insertOne([
        'name'      => $data['name'],
        'email'     => $data['email'],
        'password'  => $hash,
        'createdAt' => new MongoDB\BSON\UTCDateTime()
    ]);

    if ($res->getInsertedCount() !== 1) {
        throw new Exception('Falha ao inserir usuário.');
    }

    // Sucesso
    echo json_encode(['success' => true, 'message' => 'Registro realizado com sucesso!']);
} catch (Throwable $e) {
    // Retorna status 500 com mensagem e trace
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage(),
        'trace'   => $e->getTraceAsString()
    ]);
}
