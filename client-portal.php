<?php
require 'mongo_conn.php';
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
$user = $_SESSION['user'];
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
  <?php include 'index.php'; ?>

  <main class="container" style="margin-top:120px;">
    <h1>Bem‑vindo, <?= htmlspecialchars($user['name']) ?>!</h1>
    <p>Seu email: <?= htmlspecialchars($user['email']) ?></p>
    <!-- aqui você pode listar pedidos, faturas, histórico, etc. -->
  </main>
</body>
</html>
