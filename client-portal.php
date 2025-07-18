<?php
// client-portal.php
ini_set('display_errors', 0);
error_reporting(0);

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

use MongoDB\BSON\ObjectId;
use DateTimeZone;

// Carrega dados do usuário logado
$user = $_SESSION['user'];

// Conecta na coleção de pedidos
$ordersCol = getMongoCollection('orders');

// Define filtro: todos (admin) ou só próprio user
$filter = [];
if ($user['role'] !== 'admin') {
    $filter = ['userId' => new ObjectId($user['id'])];
}

// Busca e converte em array
$cursor  = $ordersCol->find($filter, ['sort' => ['createdAt' => -1]]);
$orders  = iterator_to_array($cursor, false);

// Função para formatar datas BSON
function fmtDate($utcDate) {
    $dt = $utcDate->toDateTime();
    return $dt
        ->setTimezone(new DateTimeZone(date_default_timezone_get()))
        ->format('Y-m-d H:i');
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Portal do Cliente – PHIL ASEAN</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include 'header.php'; ?>

  <main class="container" style="margin-top:120px;">
    <h1>Bem‑vindo, <?= htmlspecialchars($user['name']) ?>!</h1>
    <p>Email: <?= htmlspecialchars($user['email']) ?></p>
    <?php if ($user['role'] === 'admin'): ?>
      <p>Você está no painel de <strong>Administrador</strong>. Aqui estão todos os pedidos:</p>
    <?php else: ?>
      <p>Seus pedidos:</p>
    <?php endif; ?>

    <?php if (count($orders) === 0): ?>
      <p><em>Nenhum pedido encontrado.</em></p>
    <?php else: ?>
      <table class="orders-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Serviço</th>
            <th>Cliente</th>
            <th>Email</th>
            <th>Data</th>
            <th>Status</th>
            <th>Fatura</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $o): ?>
            <tr>
              <td><?= (string)$o['_id'] ?></td>
              <td><?= htmlspecialchars($o['service']) ?></td>
              <td><?= htmlspecialchars($o['name']) ?></td>
              <td><?= htmlspecialchars($o['email']) ?></td>
              <td><?= fmtDate($o['createdAt']) ?></td>
              <td><?= htmlspecialchars($o['status']) ?></td>
              <td>
                <?php if (!empty($o['invoiceId'])): ?>
                  <a href="invoices/<?= (string)$o['invoiceId'] ?>.pdf" target="_blank">Download</a>
                <?php else: ?>
                  —
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </main>
</body>
</html>
