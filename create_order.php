<?php
// create_order.php

// 1) Desliga exibição de erros na tela e limpa buffers
ini_set('display_errors', 0);
error_reporting(0);
while (ob_get_level()) {
    ob_end_clean();
}

// 2) Inicia sessão se ainda não estiver ativa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// 3) Define cabeçalho JSON
header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

// 4) Apenas POST JSON
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Use POST']);
    exit;
}

// 5) Decodifica payload
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    echo json_encode(['success' => false, 'message' => 'JSON inválido']);
    exit;
}

// 6) Validações básicas
if (empty($input['service']) || empty($input['name']) || empty($input['email'])) {
    echo json_encode(['success' => false, 'message' => 'Campos obrigatórios faltando']);
    exit;
}

// 7) Monta documento de pedido, garantindo details como objeto
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
    echo json_encode(['success' => false, 'message' => 'Falha ao criar pedido']);
    exit;
}

// 9) Gera fatura em PDF
require __DIR__ . '/generate_invoice.php';
$invoiceId = generateInvoicePDF($res->getInsertedId());

// 10) Atualiza pedido com invoiceId
$orders->updateOne(
    ['_id' => $res->getInsertedId()],
    ['$set' => ['invoiceId' => new ObjectId($invoiceId)]]
);

// 11) Envia email institucional
require __DIR__ . '/send_order_email.php';
sendOrderEmail($order, $invoiceId);

// 12) Resposta ao cliente
echo json_encode([
    'success' => true,
    'message' => 'Pedido criado com sucesso!',
    'orderId' => (string)$res->getInsertedId()
]);
exit;
