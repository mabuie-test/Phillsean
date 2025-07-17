<?php
// register.php — debug de stages

ini_set('display_errors', 0);
error_reporting(0);
ob_start();
header('Content-Type: application/json; charset=utf-8');

$response = ['stage' => 'start'];

try {
    // Stage 1: método
    $response['stage'] = 'method-check';
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido');
    }

    // Stage 2: ler raw JSON
    $response['stage'] = 'read-json';
    $raw  = file_get_contents('php://input');
    $data = json_decode($raw, true);
    $response['raw'] = $raw;
    $response['decoded'] = $data;
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON inválido: ' . json_last_error_msg());
    }

    // Stage 3: validações
    $response['stage'] = 'validation';
    if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
        throw new Exception('Campos faltando');
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Email inválido');
    }

    // Stage 4: conexão Mongo
    $response['stage'] = 'mongo-connect';
    require __DIR__ . '/vendor/autoload.php';
    require __DIR__ . '/mongo_conn.php';
    $users = getMongoCollection('users');
    if (!$users) {
        throw new Exception('Falha ao obter coleção users');
    }

    // Stage 5: duplicado
    $response['stage'] = 'check-duplicate';
    if ($users->findOne(['email' => $data['email']])) {
        throw new Exception('Email já em uso');
    }

    // Stage 6: insert
    $response['stage'] = 'insert';
    $hash = password_hash($data['password'], PASSWORD_BCRYPT);
    $res  = $users->insertOne([
        'name'      => $data['name'],
        'email'     => $data['email'],
        'password'  => $hash,
        'createdAt' => new MongoDB\BSON\UTCDateTime()
    ]);
    $response['insertedCount'] = $res->getInsertedCount();

    // Stage 7: sucesso
    $response['stage'] = 'success';
    $response['success'] = true;
    $response['message'] = 'Registro realizado com sucesso!';
} catch (Throwable $e) {
    $response['stage'] = 'error';
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    $response['exceptionFile'] = $e->getFile() . ':' . $e->getLine();
}

// Limpa buffer e retorna JSON
ob_clean();
echo json_encode($response, JSON_PRETTY_PRINT);
exit;
