<?php
// create_order.php

header('Content-Type: application/json; charset=utf-8');
session_start();

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

// 1) Apenas POST JSON
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success'=>false,'message'=>'Use POST']);
    exit;
}

// 2) Decodifica payload
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    echo json_encode(['success'=>false,'message'=>'JSON inválido']);
    exit;
}

// 3) Validações básicas
if (empty($input['service']) || empty($input['name']) || empty($input['email'])) {
    echo json_encode(['success'=>false,'message'=>'Campos obrigatórios faltando']);
    exit;
}

// 4) Monta documento de pedido
$order = [
    'userId'    => isset($_SESSION['user']['id'])
                    ? new ObjectId($_SESSION['user']['id'])
                    : null,
    'name'      => $input['name'],
    'email'     => $input['email'],
    'service'   => $input['service'],
    // garante que details seja sempre um objeto, nunca array
    'details'   => (isset($input['details']) && is_array($input['details']))
                   ? (object)$input['details']
                   : (object)[],
    'createdAt' => new UTCDateTime(),
    'status'    => 'pending'
];

// 5) Insere no Mongo
$orders = getMongoCollection('orders');
$res    = $orders->insertOne($order);
if ($res->getInsertedCount() !== 1) {
    echo json_encode(['success'=>false,'message'=>'Falha ao criar pedido']);
    exit;
}

// 6) Gera fatura em PDF
require __DIR__ . '/generate_invoice.php';
$invoiceId = generateInvoicePDF($res->getInsertedId());

// 7) Atualiza pedido com invoiceId
$orders->updateOne(
    ['_id' => $res->getInsertedId()],
    ['$set' => ['invoiceId' => new ObjectId($invoiceId)]]
);

// 8) Envia email institucional
require __DIR__ . '/send_order_email.php';
sendOrderEmail($order, $invoiceId);

// 9) Resposta ao cliente
echo json_encode([
    'success' => true,
    'message' => 'Pedido criado com sucesso!',
    'orderId' => (string)$res->getInsertedId()
]);
exit;
