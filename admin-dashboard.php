<?php
// admin-dashboard.php

session_start();
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/mongo_conn.php';

// 1) Verifica role de admin
if (empty($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$orders   = getMongoCollection('orders')->find([], ['sort'=>['createdAt'=>-1]]);
$invoices = getMongoCollection('invoices');
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header><h1>Dashboard de Pedidos (Admin)</h1></header>
  <main class="container" style="padding-top:100px;">
    <table>
      <thead>
        <tr>
          <th>Pedido ID</th>
          <th>Cliente</th>
          <th>Serviço</th>
          <th>Data</th>
          <th>Status</th>
          <th>Fatura</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($orders as $o): 
        $inv = $invoices->findOne(['orderId' => $o['_id']]);
        $dt  = $o['createdAt']->toDateTime()->format('d/m/Y H:i');
      ?>
        <tr>
          <td><?= $o['_id'] ?></td>
          <td><?= htmlspecialchars($o['name']) ?> (<?= htmlspecialchars($o['email']) ?>)</td>
          <td><?= htmlspecialchars($o['service']) ?></td>
          <td><?= $dt ?></td>
          <td><?= htmlspecialchars($o['status']) ?></td>
          <td>
            <?php if (!empty($inv['pdfPath'])): ?>
              <a href="<?= htmlspecialchars($inv['pdfPath']) ?>" target="_blank">Download</a>
            <?php else: ?>
              —
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
