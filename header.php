<?php
// header.php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<header>
  <div class="container header-container">
    <div class="logo">
      <img src="phil.jpeg" alt="Logo">
      <div class="logo-text">
        <h1>PHIL ASEAN</h1>
        <p>Provider & Logistics</p>
      </div>
    </div>
    <button id="mobile-menu-btn" class="mobile-menu-btn">
      <i class="fas fa-bars"></i>
    </button>
    <nav>
      <ul id="main-menu">
        <li><a href="index.php"><i class="fas fa-home"></i> Início</a></li>
        <?php if (isset($_SESSION['user'])): ?>
          <li class="auth-dropdown">
            <a href="#"><i class="fas fa-user-circle"></i>
              Olá, <?= htmlspecialchars($_SESSION['user']['name']) ?></a>
            <div class="auth-dropdown-content">
              <a href="client-portal.php"><i class="fas fa-tachometer-alt"></i> Portal do Cliente</a>
              <a href="#" id="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
          </li>
        <?php else: ?>
          <li><a href="#" id="login-btn-nav"><i class="fas fa-sign-in-alt"></i> Login</a></li>
          <li><a href="#" id="register-btn-nav"><i class="fas fa-user-plus"></i> Registrar</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>
