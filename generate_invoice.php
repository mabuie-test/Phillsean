<?php
// generate_invoice.php

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

function generateInvoicePDF(ObjectId $orderId) {
    // Busca dados do pedido
    $orders     = getMongoCollection('orders');
    $order      = $orders->findOne(['_id' => $orderId]);
    if (!$order) {
        throw new RuntimeException('Pedido não encontrado para faturamento');
    }

    // Gera número e conteúdo da fatura
    $dt      = $order['createdAt']->toDateTime()->format('Y-m-d');
    $invNum  = 'FAT-' . $orderId . '-' . $dt;

    // Instancia TCPDF
    $pdf = new \TCPDF();
    $pdf->AddPage();
    $html = "
        <h1>Fatura: {$invNum}</h1>
        <p><strong>Cliente:</strong> {$order['name']} ({$order['email']})</p>
        <p><strong>Serviço:</strong> {$order['service']}</p>
        <p><strong>Data:</strong> {$dt}</p>
        <hr>
        <p>Detalhes adicionais:</p>
        <pre>" . json_encode($order['details'], JSON_PRETTY_PRINT) . "</pre>
    ";
    $pdf->writeHTML($html, true, false, true, false, '');

    // Salva arquivo
    $path     = "invoices/invoice_{$orderId}.pdf";
    $fullpath = __DIR__ . '/' . $path;
    @mkdir(dirname($fullpath), 0755, true);
    $pdf->Output($fullpath, 'F');

    // Armazena no Mongo (coleção invoices)
    $invoices = getMongoCollection('invoices');
    $res      = $invoices->insertOne([
        'orderId'   => $orderId,
        'pdfPath'   => $path,
        'createdAt' => new UTCDateTime()
    ]);

    return $res->getInsertedId();
}
