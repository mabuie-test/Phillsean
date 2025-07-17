<?php
// index.php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>PHIL ASEAN PROVIDER & LOGISTICS | Serviços Marítimos</title>
  <link rel="icon" href="phil.jpeg">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <!-- HEADER / NAVBAR -->
  <header>
    <div class="container header-container">
      <div class="logo">
        <img src="phil.jpeg" alt="Logo">
        <div class="logo-text">
          <h1>PHIL ASEAN</h1>
          <p>Provider &amp; Logistics</p>
        </div>
      </div>
      <button id="mobile-menu-btn" class="mobile-menu-btn">
        <i class="fas fa-bars"></i>
      </button>
      <nav>
        <ul id="main-menu">
          <li><a href="index.php"><i class="fas fa-home"></i> Início</a></li>
          
          <?php if(isset($_SESSION['user'])): ?>
          <li class="auth-dropdown">
            <a href="#"><i class="fas fa-user-circle"></i>
              Olá, <?= htmlspecialchars($_SESSION['user']['name']) ?></a>
            <div class="auth-dropdown-content">
              <a href="client-portal.php">
                <i class="fas fa-tachometer-alt"></i> Portal do Cliente
              </a>
              <a href="#" id="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
          <?php else: ?>
          <li><a href="#" id="login-btn-nav">
            <i class="fas fa-sign-in-alt"></i> Login</a>
          </li>
          <li><a href="#" id="register-btn-nav">
            <i class="fas fa-user-plus"></i> Registrar</a>
          </li>
          <?php endif; ?>

        </ul>
      </nav>
    </div>
  </header>

  <!-- AUTENTICAÇÃO (Modal) -->
  <div id="auth-modal" class="auth-modal">
    <div class="auth-modal-content">
      <div class="auth-tabs">
        <div id="login-tab" class="auth-tab active">Login</div>
        <div id="register-tab" class="auth-tab">Registrar</div>
      </div>
      <!-- LOGIN -->
      <div class="auth-form" id="login-form">
        <div class="auth-form-group">
          <label for="login-email">Email</label>
          <input type="email" id="login-email" class="auth-form-control" required>
        </div>
        <div class="auth-form-group">
          <label for="login-password">Senha</label>
          <input type="password" id="login-password"
            class="auth-form-control" required>
        </div>
        <button id="login-btn" class="btn">Entrar</button>
        <p class="auth-form-footer">
          Ainda não tem conta? <a href="#" id="switch-to-register">Registre‑se</a>
        </p>
      </div>
      <!-- REGISTER -->
      <div class="auth-form" id="register-form" style="display:none;">
        <div class="auth-form-group">
          <label for="reg-name">Nome Completo</label>
          <input type="text" id="reg-name" class="auth-form-control" required>
        </div>
        <div class="auth-form-group">
          <label for="reg-email">Email</label>
          <input type="email" id="reg-email" class="auth-form-control" required>
        </div>
        <div class="auth-form-group">
          <label for="reg-password">Senha</label>
          <input type="password" id="reg-password"
            class="auth-form-control" required>
        </div>
        <button id="register-btn" class="btn">Registrar</button>
        <p class="auth-form-footer">
          Já tem conta? <a href="#" id="switch-to-login">Entre</a>
        </p>
      </div>
      <button class="close-modal" id="close-auth-modal">&times;</button>
    </div>
  </div>

  <!-- ======= TODO SEU CONTEÚDO: Hero, Seções, Footer, etc. ======= -->
  <!-- Exemplo de seção -->
  <section class="hero">
    <div class="container">
      <h2>Bem‑vindo à PHIL ASEAN</h2>
      <p>Fornecimento de serviços marítimos em Moçambique.</p>
      <a href="reserva.php" class="btn">Faça sua Reserva</a>
    </div>
  </section>
  <!-- ================================================================= -->

  <script src="script.js"></script>
  <script>
    // Logout
    document.getElementById('logout-btn')?.addEventListener('click', e => {
      e.preventDefault();
      fetch('logout.php', { method: 'POST' })
        .then(r => r.json()).then(js => {
          if (js.success) window.location = 'index.php';
        });
    });

    // Abrir modais via Navbar
    document.getElementById('login-btn-nav')
      .addEventListener('click', e => {
        e.preventDefault();
        document.getElementById('auth-modal').style.display = 'flex';
        showLoginForm();
      });
    document.getElementById('register-btn-nav')
      .addEventListener('click', e => {
        e.preventDefault();
        document.getElementById('auth-modal').style.display = 'flex';
        showRegisterForm();
      });
    document.getElementById('close-auth-modal')
      .addEventListener('click', () => {
        document.getElementById('auth-modal').style.display = 'none';
      });
  </script>
</body>
</html>
