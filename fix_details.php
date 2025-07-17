<?php
// fix_details.php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

$orders = getMongoCollection('orders');

// Atualiza todos onde details é array para um object vazio
$result = $orders->updateMany(
    ['details' => ['$type' => 'array']],
    ['$set' => ['details' => (object)[]]]
);

// Apenas log de quantos foram corrigidos
echo "Orders matched: {$result->getMatchedCount()}, modified: {$result->getModifiedCount()}\n";
