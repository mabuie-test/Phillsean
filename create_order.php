<?php
// create_order.php

// 1) Desliga exibição de erros na tela e limpa buffers
ini_set('display_errors', 0);
error_reporting(0);
while (ob_get_level()) {
    ob_end_clean();
}

// 2) Inicia sessão
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// 3) Cabeçalho JSON
header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

try {
    // 4) Apenas POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new \Exception('Este endpoint aceita apenas POST.', 405);
    }

    // 5) Decodifica JSON
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        throw new \Exception('JSON inválido.', 400);
    }

    // 6) Valida campos
    foreach (['service','name','email'] as $f) {
        if (empty($input[$f])) {
            throw new \Exception("Campo obrigatório faltando: $f", 422);
        }
    }
    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        throw new \Exception("Email inválido.", 422);
    }

    // 7) Prepara documento
    $order = [
        'userId'    => isset($_SESSION['user']['id'])
                        ? new ObjectId($_SESSION['user']['id'])
                        : null,
        'name'      => $input['name'],
        'email'     => $input['email'],
        'service'   => $input['service'],
        'details'   => (isset($input['details']) && is_array($input['details']))
                       ? (object)$input['details']
                       : (object)[],
        'createdAt' => new UTCDateTime(),
        'status'    => 'pending'
    ];

    // 8) Insere no MongoDB
    $orders = getMongoCollection('orders');
    $res    = $orders->insertOne($order);
    if ($res->getInsertedCount() !== 1) {
        throw new \Exception('Falha ao criar pedido.', 500);
    }

    // 9) Gera fatura
    require __DIR__ . '/generate_invoice.php';
    $invoiceId = generateInvoicePDF($res->getInsertedId());

    // 10) Atualiza com invoiceId
    $orders->updateOne(
        ['_id' => $res->getInsertedId()],
        ['$set' => ['invoiceId' => new ObjectId($invoiceId)]]
    );

    // 11) Envia email
    require __DIR__ . '/send_order_email.php';
    sendOrderEmail($order, $invoiceId);

    // 12) Sucesso
    echo json_encode([
        'success' => true,
        'message' => 'Pedido criado com sucesso!',
        'orderId' => (string)$res->getInsertedId()
    ]);

} catch (\Throwable $e) {
    // Em caso de qualquer erro, retorna JSON e código HTTP apropriado
    $code = $e->getCode();
    if ($code < 100 || $code >= 600) {
        $code = 500;
    }
    http_response_code($code);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

exit;
