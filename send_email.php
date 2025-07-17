<?php
header('Content-Type: application/json');
$to      = 'shipsupply@philaseanprovider.co.mz';
$subject = 'Nova Solicitação de Serviço - PHIL ASEAN';
$data    = json_decode(file_get_contents('php://input'), true);

if (empty($data['name']) || empty($data['email']) || empty($data['service'])) {
    echo json_encode(['success'=>false,'message'=>'Preencha todos os campos obrigatórios.']);
    exit;
}
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success'=>false,'message'=>'Email inválido.']);
    exit;
}

// monta email HTML (igual ao seu)
$message = "..."; // mantenha o body completo que você já tinha
$headers = "MIME-Version: 1.0\r\n"
         . "Content-type: text/html; charset=utf-8\r\n"
         . "From: {$data['email']}\r\n"
         . "Reply-To: {$data['email']}\r\n";

$sent = mail($to,$subject,$message,$headers);
if ($sent) {
    $ref = 'PHIL-'.date('Ymd').'-'.rand(1000,9999);
    echo json_encode(['success'=>true,'message'=>'Solicitação enviada!','reference'=>$ref]);
} else {
    echo json_encode(['success'=>false,'message'=>'Erro no envio.']);
}
