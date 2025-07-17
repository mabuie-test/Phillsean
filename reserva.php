<?php
// reserva.php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Fazer Reserva – PHIL ASEAN</title>
  <link rel="icon" href="phil.jpeg">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <?php include 'index.php'; /* opcional: extrair header/nav para include separado */ ?>

  <main class="container" style="margin-top:120px;">
    <h2>Solicitar Serviço</h2>
    <form id="service-order-form">
      <!-- campos similares ao seu send_email.php -->
      <div id="form-messages"></div>
      <div class="form-group">
        <label>Nome:</label>
        <input type="text" id="name" class="form-control" required>
      </div>
      <!-- coloque aqui todos os campos: company, email, phone, vessel, port, date, service, quantity, notes -->
      <!-- Exemplo: -->
      <div class="form-group">
        <label>Empresa:</label>
        <input type="text" id="company" class="form-control">
      </div>
      <div class="form-group">
        <label>Email:</label>
        <input type="email" id="email" class="form-control" required>
      </div>
      <!-- ... resto dos campos ... -->
      <button type="submit" class="btn">Enviar Solicitação</button>
    </form>
  </main>

  <script src="script.js"></script>
</body>
</html>
