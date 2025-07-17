<?php
// send_order_email.php

use MongoDB\BSON\ObjectId;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOrderEmail(array $order, ObjectId $invoiceId) {
    // Busca caminho da fatura
    $invoices = getMongoCollection('invoices');
    $inv      = $invoices->findOne(['_id' => $invoiceId]);
    $path     = __DIR__ . '/' . ($inv['pdfPath'] ?? '');

    // Configura PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Servidor (ajuste se usar SMTP)
        $mail->isMail();
        $mail->setFrom('shipsupply@philaseanprovider.co.mz', 'PHIL ASEAN');
        $mail->addAddress('shipsupply@philaseanprovider.co.mz');
        $mail->Subject = "Novo Pedido: {$order['service']}";

        $body = "<p>Um novo pedido foi criado:</p>"
              . "<ul>"
              . "<li><strong>Cliente:</strong> {$order['name']} ({$order['email']})</li>"
              . "<li><strong>Serviço:</strong> {$order['service']}</li>"
              . "<li><strong>Data:</strong> "
              . $order['createdAt']->toDateTime()->format('Y-m-d H:i')
              . "</li>"
              . "</ul>";

        $mail->isHTML(true);
        $mail->Body = $body;

        // Anexa PDF
        if (file_exists($path)) {
            $mail->addAttachment($path);
        }

        $mail->send();
    } catch (Exception $e) {
        // log de erro, mas não bloqueia o fluxo
        error_log("Mail error: {$mail->ErrorInfo}");
    }
}
