<?php
// register.php (debug completo)

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia buffer para capturar tudo
ob_start();

header('Content-Type: application/json; charset=utf-8');

try {
    // 1) Apenas POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido: use POST');
    }

    // 2) Sessão + Autoload
    session_start();
    require __DIR__ . '/vendor/autoload.php';
    require __DIR__ . '/mongo_conn.php';

    // 3) Lê JSON
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON inválido: ' . json_last_error_msg());
    }

    // 4) Validações
    if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
        throw new Exception('Todos os campos são obrigatórios.');
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Email inválido.');
    }

    // 5) Conecta no MongoDB
    $users = getMongoCollection('users');
    if (!$users) {
        throw new Exception('Falha ao conectar à coleção users.');
    }

    // 6) Checa duplicado
    if ($users->findOne(['email'=>$data['email']])) {
        throw new Exception('Este email já está cadastrado.');
    }

    // 7) Insere usuário
    $hash = password_hash($data['password'], PASSWORD_BCRYPT);
    $res  = $users->insertOne([
        'name'      => $data['name'],
        'email'     => $data['email'],
        'password'  => $hash,
        'createdAt' => new MongoDB\BSON\UTCDateTime()
    ]);
    if ($res->getInsertedCount() !== 1) {
        throw new Exception('Falha ao inserir usuário no banco.');
    }

    // 8) Sucesso
    $response = ['success'=>true,'message'=>'Registro realizado com sucesso!'];
} catch (Throwable $e) {
    // Captura o erro e gera JSON
    $response = [
        'success' => false,
        'error'   => $e->getMessage(),
        'file'    => $e->getFile() . ':' . $e->getLine(),
        'trace'   => $e->getTraceAsString()
    ];
}

// Limpa qualquer outra saída e devolve o JSON
ob_clean();
echo json_encode($response, JSON_PRETTY_PRINT);
exit;
