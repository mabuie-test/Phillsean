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


 <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        /* Header Styles */
        header {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .logo img {
            height: 50px;
            margin-right: 15px;
        }
        
        .logo-text h1 {
            font-size: 1.5rem;
            color: #0056b3;
            margin-bottom: 5px;
        }
        
        .logo-text p {
            font-size: 0.8rem;
            color: #666;
        }
        
        /* Navigation */
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 20px;
            position: relative;
        }
        
        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        nav ul li a i {
            margin-right: 5px;
        }
        
        .auth-dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            z-index: 1;
            right: 0;
        }
        
        .auth-dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        
        .auth-dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        
        .auth-dropdown:hover .auth-dropdown-content {
            display: block;
        }
        
        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        /* Hero Section with Video Background */
        .hero {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
            color: #fff;
            margin-top: 80px;
            overflow: hidden;
        }
        
        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        
        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }
        
        .hero .container {
            position: relative;
            z-index: 1;
        }
        
        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Button Styles */
        .btn {
            display: inline-block;
            background-color: #0056b3;
            color: #fff;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            background-color: #003d82;
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background-color: transparent;
            border: 2px solid #fff;
            margin-left: 15px;
        }
        
        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        /* Section Styles */
        .section {
            padding: 80px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-size: 2rem;
            color: #0056b3;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            width: 50px;
            height: 3px;
            background-color: #0056b3;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        
        /* Services Grid */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }
        
        .service-card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
        }
        
        .service-img img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .service-content {
            padding: 20px;
        }
        
        .service-content h3 {
            margin-bottom: 15px;
            color: #0056b3;
        }
        
        .service-content p {
            margin-bottom: 20px;
            color: #666;
        }
        
        /* Fruit Gallery Styles */
        .fruit-gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }
        
        .fruit-item {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .fruit-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .fruit-item img:hover {
            transform: scale(1.05);
        }
        
        /* About Section */
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }
        
        .about-text h2 {
            font-size: 2rem;
            color: #0056b3;
            margin-bottom: 20px;
        }
        
        .about-text p {
            margin-bottom: 15px;
            color: #666;
        }
        
        .about-img img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Order Form */
        .order-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #0056b3;
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .submit-btn {
            width: 100%;
            font-size: 1.1rem;
        }
        
        /* Contact Info */
        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .contact-card {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .contact-icon {
            font-size: 2.5rem;
            color: #0056b3;
            margin-bottom: 20px;
        }
        
        .contact-card h3 {
            margin-bottom: 15px;
            color: #0056b3;
        }
        
        .contact-card p {
            color: #666;
            margin-bottom: 10px;
        }
        
        /* Footer */
        footer {
            background-color: #222;
            color: #fff;
            padding: 60px 0 0;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-col h3 {
            color: #fff;
            margin-bottom: 20px;
            font-size: 1.2rem;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #fff;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #333;
            color: #fff;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #444;
            color: #bbb;
            font-size: 0.9rem;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            overflow: auto;
        }
        
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            position: relative;
            animation: modalopen 0.5s;
        }
        
        @keyframes modalopen {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }
        
        .close-modal {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.5rem;
            color: #888;
            cursor: pointer;
            background: none;
            border: none;
        }
        
        .modal-icon {
            text-align: center;
            font-size: 4rem;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        
        .modal h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0056b3;
        }
        
        .modal p {
            text-align: center;
            margin-bottom: 30px;
            color: #666;
        }
        
        /* Auth Modal */
        .auth-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            overflow: auto;
        }
        
        .auth-modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 0;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            position: relative;
            animation: modalopen 0.5s;
            overflow: hidden;
        }
        
        .auth-tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
        }
        
        .auth-tab {
            flex: 1;
            text-align: center;
            padding: 15px;
            cursor: pointer;
            font-weight: 600;
            color: #666;
            transition: all 0.3s ease;
        }
        
        .auth-tab.active {
            color: #0056b3;
            border-bottom: 3px solid #0056b3;
        }
        
        .auth-form {
            padding: 30px;
            display: none;
        }
        
        .auth-form.active {
            display: block;
        }
        
        .auth-form-group {
            margin-bottom: 20px;
        }
        
        .auth-form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .auth-form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .social-auth {
            margin: 30px 0;
            text-align: center;
        }
        
        .social-auth p {
            color: #666;
            margin-bottom: 15px;
            position: relative;
        }
        
        .social-auth p::before,
        .social-auth p::after {
            content: '';
            position: absolute;
            height: 1px;
            width: 30%;
            background-color: #ddd;
            top: 50%;
        }
        
        .social-auth p::before {
            left: 0;
        }
        
        .social-auth p::after {
            right: 0;
        }
        
        .social-auth-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            width: 100%;
        }
        
        .social-auth-btn i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .google-btn {
            background-color: #fff;
            color: #333;
            border: 1px solid #ddd;
        }
        
        .google-btn:hover {
            background-color: #f1f1f1;
        }
        
        .auth-form-footer {
            text-align: center;
            color: #666;
        }
        
        .auth-form-footer a {
            color: #0056b3;
            text-decoration: none;
            font-weight: 600;
        }
        
        /* Invoice Modal */
        #invoice-modal .modal-content {
            max-width: 800px;
        }
        
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .invoice-title h2 {
            color: #0056b3;
            margin-bottom: 5px;
            text-align: right;
        }
        
        .invoice-title p {
            color: #666;
            text-align: right;
        }
        
        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .invoice-from h3,
        .invoice-to h3 {
            color: #0056b3;
            margin-bottom: 15px;
        }
        
        .invoice-meta p {
            text-align: right;
            margin-bottom: 5px;
        }
        
        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .invoice-items th,
        .invoice-items td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .invoice-items th {
            background-color: #f5f5f5;
            font-weight: 600;
        }
        
        .invoice-footer {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .invoice-payment h3,
        .invoice-notes h3 {
            color: #0056b3;
            margin-bottom: 15px;
        }
        
        .invoice-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .about-content {
                grid-template-columns: 1fr;
            }
            
            .about-img {
                order: -1;
            }
        }
        
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                text-align: center;
            }
            
            .logo {
                margin-bottom: 15px;
                justify-content: center;
            }
            
            nav ul {
                flex-direction: column;
                align-items: center;
            }
            
            nav ul li {
                margin: 10px 0;
            }
            
            .auth-dropdown-content {
                right: auto;
                left: 50%;
                transform: translateX(-50%);
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            #main-menu {
                display: none;
                width: 100%;
                text-align: center;
            }
            
            #main-menu.active {
                display: block;
            }
            
            .hero h2 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .btn-outline {
                margin-left: 0;
                margin-top: 15px;
            }
            
            .fruit-gallery {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .services-grid {
                grid-template-columns: 1fr;
            }
            
            .invoice-details,
            .invoice-footer {
                grid-template-columns: 1fr;
            }
            
            .invoice-title h2,
            .invoice-title p,
            .invoice-meta p {
                text-align: left;
            }
            
            .invoice-actions {
                flex-direction: column;
            }
            
            .invoice-actions .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
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
  
    <section class="hero" id="home">
        <video autoplay muted loop playsinline class="hero-video" id="background-video">
            <source src="phi.MOV" type="video/mp4">
            Seu navegador não suporta vídeos HTML5.
        </video>
        <div class="container">
            <h2>Serviços Premium de Abastecimento Naval em Moçambique</h2>
            <p>Seu parceiro confiável em logística marítima e provisões para embarcações ao longo de toda a costa moçambicana</p>
            <a href="#order" class="btn">Solicitar Serviço</a>
            <a href="#contact" class="btn btn-outline">Contate-nos</a>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section" id="services">
        <div class="container">
            <div class="section-title">
                <h2>Nossos Serviços em Moçambique</h2>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-img">
                        <img src="tubo.jpeg" alt="Fuel Supply">
                    </div>
                    <div class="service-content">
                        <h3>Tubos hidráulicos</h3>
                        <p>Fornecemos tubos hidráulicos de alta resistência, ideais para aplicações marítimas e industriais, além de serviços especializados em reparação e manutenção.</p>
                        <a href="#order" class="btn">Solicitar</a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="agua.jpeg" alt="Potable Water">
                    </div>
                    <div class="service-content">
                        <h3>Fornecimento de Água Potável</h3>
                        <p>Água limpa para consumo entregue em sua embarcação em conformidade com os regulamentos de saúde moçambicanos e padrões internacionais.</p>
                        <a href="#order" class="btn">Solicitar</a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="llixo.jpeg" alt="Port Logistics">
                    </div>
                    <div class="service-content">
                        <h3>Garbage Collector</h3>
                        <p>Realizamos a coleta e o manejo adequado de resíduos sólidos e líquidos gerados a bordo de navios, seguindo rigorosamente as normas ambientais nacionais e internacionais.</p>
                        <a href="#order" class="btn">Solicitar</a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="alimento.jpeg" alt="Provisions & Supplies">
                    </div>
                    <div class="service-content">
                        <h3>Provisões e Mantimentos</h3>
                        <p>Provisões frescas, mantimentos secos e itens vinculados entregues em sua embarcação em conformidade com as alfândegas moçambicanas.</p>
                        
                        <div class="fruit-gallery">
                            <div class="fruit-item">
                                <img src="1.jpeg" alt="Frutas Frescas 1">
                            </div>
                            <div class="fruit-item">
                                <img src="2.jpeg" alt="Frutas Frescas 2">
                            </div>
                            <div class="fruit-item">
                                <img src="3.jpeg" alt="Frutas Frescas 3">
                            </div>
                            <div class="fruit-item">
                                <img src="4.jpeg" alt="Frutas Frescas 4">
                            </div>
                        </div>
                        
                        <a href="#order" class="btn">Solicitar</a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="ole.jpeg" alt="Lubricants">
                    </div>
                    <div class="service-content">
                        <h3>Lubrificantes Marítimos</h3>
                        <p>Fornecemos lubrificantes marítimos de alta qualidade, desenvolvidos para atender às demandas específicas de embarcações e motores marinhos.</p>
                        <a href="#order" class="btn">Solicitar</a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="PH1.jpg">
                    </div>
                    <div class="service-content">
                        <h3>Transporte em Offshore</h3>
                        <p>Nós oferecemos serviços completos de transporte em operações offshore, garantindo segurança, agilidade e eficiência em todas as etapas.</p>
                        <a href="#order" class="btn">Solicitar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about" id="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Sobre Nossas Operações em Moçambique</h2>
                    <p>PHIL ASEAN PROVIDER & LOGISTICS é o principal provedor de serviços marítimos especializado na costa moçambicana, com ampla experiência em operações portuárias locais e regulamentações marítimas.</p>
                    <p>Desde 2010, atendemos embarcações em todos os portos moçambicanos, incluindo Maputo, Beira, Nacala, Pemba e Quelimane com disponibilidade 24/7 e tempos de resposta rápidos.</p>
                    <p>Nosso profundo conhecimento dos procedimentos alfandegários moçambicanos e requisitos das autoridades portuárias garante operações suaves para todos os nossos clientes. Mantemos excelentes relacionamentos com todas as autoridades relevantes e fornecedores locais.</p>
                    <p>Nossa equipe consiste em profissionais marítimos com amplo conhecimento local, garantindo conformidade com todas as regulamentações moçambicanas enquanto prestamos um serviço eficiente.</p>
                </div>
                <div class="about-img">
                    <img src="IMG_8120.JPG" alt="Costa Moçambicana">
                </div>
            </div>
        </div>
    </section>

    <!-- Order Section -->
    <section class="section order" id="order">
        <div class="container">
            <div class="section-title">
                <h2>Solicitar Serviços em Moçambique</h2>
            </div>
            <form id="service-order-form" class="order-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nome Completo</label>
                        <input type="text" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="company">Empresa</label>
                        <input type="text" id="company" class="form-control" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefone</label>
                        <input type="tel" id="phone" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="vessel">Nome da Embarcação</label>
                    <input type="text" id="vessel" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="port">Porto Moçambicano</label>
                        <select id="port" class="form-control" required>
                            <option value="">Selecione um porto moçambicano</option>
                            <option value="maputo">Maputo</option>
                            <option value="beira">Beira</option>
                            <option value="nacala">Nacala</option>
                            <option value="pemba">Pemba</option>
                            <option value="quelimane">Quelimane</option>
                            <option value="other">Outro Porto Moçambicano</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Data Estimada</label>
                        <input type="date" id="date" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="service">Serviço Solicitado</label>
                    <select id="service" class="form-control" required>
                        <option value="">Selecione um serviço</option>
                        <option value="fuel">Serviços de Bunkering</option>
                        <option value="water">Fornecimento de Água Potável</option>
                        <option value="lubricants">Lubrificantes Marítimos</option>
                        <option value="provisions">Provisões e Mantimentos</option>
                        <option value="logistics">Logística Portuária</option>
                        <option value="emergency">Serviços de Emergência</option>
                        <option value="other">Outro Serviço</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantidade/Volume (especificar unidade)</label>
                    <input type="text" id="quantity" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="notes">Observações Adicionais</label>
                    <textarea id="notes" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn submit-btn">Enviar Solicitação</button>
            </form>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section" id="contact">
        <div class="container">
            <div class="section-title">
                <h2>Nossos Contatos em Moçambique</h2>
            </div>
            <div class="contact-info">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Sede</h3>
                    <p>Porto de Maputo<br>Moçambique</p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3>Telefones</h3>
                    <p>+258 878979532 (Principal)</p>
                    <p>+258 874883021 (Emergência)</p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p>philasean@philaseanprovider.co.mz</p>
                    <p>shipsupply@philaseanprovider.co.mz</p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Horário de Funcionamento</h3>
                    <p>24 horas por dia, 7 dias por semana</p>
                    <p>Serviços de emergência disponíveis 24/7</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-col">
                    <h3>PHIL ASEAN MOÇAMBIQUE</h3>
                    <p>Seu parceiro confiável em serviços marítimos ao longo da costa moçambicana desde 2010.</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/share/19DV7gvS1T/?mibextid=wwXIfr"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.instagram.com/phil_asean?igsh=djZocnQwcDJkMHF1"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Nossos Serviços</h3>
                    <ul class="footer-links">
                        <li><a href="#">Serviços de Bunkering</a></li>
                        <li><a href="#">Agenciamento Portuário</a></li>
                        <li><a href="#">Provisões para Embarcações</a></li>
                        <li><a href="#">Serviços Técnicos</a></li>
                        <li><a href="#">Desembaraço Aduaneiro</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Links Rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="#">Tarifas Portuárias</a></li>
                        <li><a href="#">Regulamentos Aduaneiros</a></li>
                        <li><a href="#">Informações Portuárias</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Carreiras</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Newsletter</h3>
                    <p>Assine para atualizações sobre condições portuárias e nossos serviços em Moçambique.</p>
                    <form id="newsletter-form">
                        <div class="form-group">
                            <input type="email" placeholder="Seu email" class="form-control" required>
                        </div>
                        <button type="submit" class="btn">Assinar</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 PHIL ASEAN PROVIDER & LOGISTICS - Operações em Moçambique. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

<!-- Order Confirmation Modal -->
    <div class="modal" id="order-modal">
        <div class="modal-content">
            <button class="close-modal" id="close-modal">&times;</button>
            <div class="modal-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Solicitação Enviada com Sucesso!</h2>
            <p>Obrigado por escolher a PHIL ASEAN PROVIDER & LOGISTICS. Sua solicitação foi recebida e nossa equipe moçambicana entrará em contato em breve para confirmar os detalhes.</p>
            <p id="order-reference"></p>
            <button class="btn" id="modal-close-btn">Fechar</button>
        </div>
    </div>

    <!-- Invoice Modal -->
    <div class="modal" id="invoice-modal">
        <div class="modal-content" style="max-width: 800px;">
            <button class="close-modal" id="close-invoice-modal">&times;</button>
            <div class="invoice-header">
                <div class="invoice-logo">
                    <img src="phil.jpeg" alt="PHIL ASEN" style="height: 60px;">
                </div>
                <div class="invoice-title">
                    <h2>FATURA FISCAL</h2>
                    <p>PHIL ASEAN PROVIDER & LOGISTICS</p>
                    <p>Porto de Maputo, Moçambique</p>
                    <p>NIF: MZ123456789</p>
                </div>
            </div>
            
            <div class="invoice-details">
                <div class="invoice-from">
                    <h3>De:</h3>
                    <p>PHIL ASEAN PROVIDER & LOGISTICS</p>
                    <p>Porto de Maputo</p>
                    <p>Moçambique</p>
                    <p>Tel: +258 878979532</p>
                    <p>Email: shipsupply@philaseanprovider.co.mz</p>
                </div>
                
                <div class="invoice-to">
                    <h3>Para:</h3>
                    <div id="invoice-client-details">
                        <!-- Detalhes do cliente serão inseridos aqui via JavaScript -->
                    </div>
                </div>
                
                <div class="invoice-meta">
                    <p><strong>Fatura #:</strong> <span id="invoice-number"></span></p>
                    <p><strong>Data:</strong> <span id="invoice-date"></span></p>
                    <p><strong>Vencimento:</strong> <span id="invoice-due-date"></span></p>
                </div>
            </div>
            
            <table class="invoice-items">
                <thead>
                    <tr>
                        <th>Serviço</th>
                        <th>Descrição</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário (USD)</th>
                        <th>Valor (USD)</th>
                    </tr>
                </thead>
                <tbody id="invoice-items-body">
                    <!-- Itens da fatura serão inseridos aqui via JavaScript -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Subtotal:</strong></td>
                        <td id="invoice-subtotal">$0.00</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>IVA (16%):</strong></td>
                        <td id="invoice-vat">$0.00</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                        <td id="invoice-total">$0.00</td>
                    </tr>
                </tfoot>
            </table>
            
            <div class="invoice-footer">
                <div class="invoice-payment">
                    <h3>Informações de Pagamento</h3>
                    <p><strong>Banco:</strong> Banco Comercial de Moçambique</p>
                    <p><strong>Nome da Conta:</strong> PHIL ASEAN PROVIDER & LOGISTICS</p>
                    <p><strong>Número da Conta:</strong> 1234567890</p>
                    <p><strong>Código SWIFT:</strong> BCMOMZMA</p>
                    <p><strong>Vencimento:</strong> 14 dias a partir da data da fatura</p>
                </div>
                <div class="invoice-notes">                    <h3>Notas</h3>
                    <p>Obrigado pelo seu negócio!</p>
                    <p>Todos os pagamentos devem ser feitos em USD.</p>
                    <p>Por favor, cite o número da fatura ao efetuar o pagamento.</p>
                    <p>Para quaisquer dúvidas, contate nosso departamento financeiro em accounts@philasen.co.mz</p>
                </div>
            </div>
            
            <div class="invoice-actions">
                <button class="btn" id="print-invoice"><i class="fas fa-print"></i> Imprimir Fatura</button>
                <button class="btn" id="download-invoice"><i class="fas fa-download"></i> Baixar PDF</button>
                <button class="btn btn-outline" id="close-invoice-btn">Fechar</button>
            </div>
        </div>
    </div>

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

 // Controle do Menu Mobile
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {            document.getElementById('main-menu').classList.toggle('active');
        });

        // Controle do Modal de Autenticação
        document.getElementById('login-btn').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('auth-modal').style.display = 'block';
            document.getElementById('login-form').style.display = 'block';
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-tab').classList.add('active');
            document.getElementById('register-tab').classList.remove('active');
        });

        document.getElementById('register-btn').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('auth-modal').style.display = 'block';
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
            document.getElementById('login-tab').classList.remove('active');
            document.getElementById('register-tab').classList.add('active');
        });

        // Alternar entre login e registro
        document.getElementById('switch-to-register').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
            document.getElementById('login-tab').classList.remove('active');
            document.getElementById('register-tab').classList.add('active');
        });

        document.getElementById('switch-to-login').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('login-form').style.display = 'block';
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-tab').classList.add('active');
            document.getElementById('register-tab').classList.remove('active');
        });

        // Fechar modal ao clicar fora
        window.addEventListener('click', function(e) {
            if (e.target === document.getElementById('auth-modal')) {
                document.getElementById('auth-modal').style.display = 'none';
            }
            if (e.target === document.getElementById('order-modal')) {
                document.getElementById('order-modal').style.display = 'none';
            }
            if (e.target === document.getElementById('invoice-modal')) {
                document.getElementById('invoice-modal').style.display = 'none';
            }
        });

        // Botões de fechar
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('order-modal').style.display = 'none';
        });

        document.getElementById('modal-close-btn').addEventListener('click', function() {
            document.getElementById('order-modal').style.display = 'none';
        });

        document.getElementById('close-invoice-modal').addEventListener('click', function() {
            document.getElementById('invoice-modal').style.display = 'none';
        });

        document.getElementById('close-invoice-btn').addEventListener('click', function() {
            document.getElementById('invoice-modal').style.display = 'none';
        });

        // Envio do formulário
        document.getElementById('service-order-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Gerar referência aleatória
            const ref = 'PHIL-' + Math.floor(Math.random() * 1000000);
            document.getElementById('order-reference').textContent = 'Sua referência: ' + ref;
            
            // Mostrar modal de confirmação
            document.getElementById('order-modal').style.display = 'block';
            
            // Gerar fatura (simplificado para demonstração)
            generateInvoice();
            
            // Resetar formulário
            this.reset();
        });

        // Gerar fatura de exemplo
        function generateInvoice() {
            // Detalhes do cliente
            const name = document.getElementById('name').value || 'Cliente Exemplo';
            const company = document.getElementById('company').value || 'Empresa Exemplo';
            const email = document.getElementById('email').value || 'cliente@exemplo.com';
            const phone = document.getElementById('phone').value || '+258 123456789';
            
            document.getElementById('invoice-client-details').innerHTML = `
                <p>${name}</p>
                <p>${company}</p>
                <p>${email}</p>
                <p>${phone}</p>
            `;
            
            // Detalhes da fatura
            const today = new Date();
            document.getElementById('invoice-number').textContent = 'FAT-' + today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate() + '-' + Math.floor(Math.random() * 1000);
            document.getElementById('invoice-date').textContent = today.toLocaleDateString();
            
            const dueDate = new Date();
            dueDate.setDate(today.getDate() + 14);
            document.getElementById('invoice-due-date').textContent = dueDate.toLocaleDateString();
            
            // Itens da fatura (dados de exemplo)
            const service = document.getElementById('service').value || 'provisions';
            const quantity = document.getElementById('quantity').value || '100 kg';
            
            let serviceName, description, unitPrice;
            
            switch(service) {
                case 'fuel':
                    serviceName = 'Serviços de Bunkering';
                    description = 'Fornecimento de Combustível Marítimo';
                    unitPrice = 1.25;
                    break;
                case 'water':
                    serviceName = 'Fornecimento de Água Potável';
                    description = 'Água Limpa para Consumo';
                    unitPrice = 0.15;
                    break;
                case 'provisions':
                    serviceName = 'Provisões e Mantimentos';
                    description = 'Frutas e Vegetais Frescos';
                    unitPrice = 2.50;
                    break;
                case 'lubricants':
                    serviceName = 'Lubrificantes Marítimos';
                    description = 'Óleo e Graxa para Motor';
                    unitPrice = 5.75;
                    break;
                default:
                    serviceName = 'Serviço Marítimo';
                    description = 'Serviço Marítimo Padrão';
                    unitPrice = 100.00;
            }
            
            const qty = parseFloat(quantity) || 100;
            const amount = qty * unitPrice;
            
            document.getElementById('invoice-items-body').innerHTML = `
                <tr>
                    <td>${serviceName}</td>
                    <td>${description}</td>
                    <td>${quantity}</td>
                    <td>$${unitPrice.toFixed(2)}</td>
                    <td>$${amount.toFixed(2)}</td>
                </tr>
            `;
            
            // Calcular totais
            const subtotal = amount;
            const vat = subtotal * 0.16;
            const total = subtotal + vat;
            
            document.getElementById('invoice-subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('invoice-vat').textContent = '$' + vat.toFixed(2);
            document.getElementById('invoice-total').textContent = '$' + total.toFixed(2);
        }

        // Imprimir fatura
        document.getElementById('print-invoice').addEventListener('click', function() {
            window.print();
        });

        // Baixar fatura como PDF (simulado)
        document.getElementById('download-invoice').addEventListener('click', function() {
            alert('Fatura baixada como PDF (simulado para demonstração)');
        });

        // Alternar abas no modal de autenticação
        document.getElementById('login-tab').addEventListener('click', function() {
            document.getElementById('login-form').style.display = 'block';
            document.getElementById('register-form').style.display = 'none';
            this.classList.add('active');
            document.getElementById('register-tab').classList.remove('active');
        });

        document.getElementById('register-tab').addEventListener('click', function() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
            this.classList.add('active');
            document.getElementById('login-tab').classList.remove('active');
        });

        // Controle do vídeo de fundo
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('background-video');
            
            // Função para tentar reproduzir o vídeo
            function attemptPlay() {
                video.play()
                    .then(() => {
                        // Vídeo iniciado com sucesso
                    })
                    .catch(error => {
                        // Se autoplay for bloqueado, tentamos com mute
                        video.muted = true;
                        video.play();
                    });
            }

            // Tentar reproduzir imediatamente
            attemptPlay();

            // Tentar novamente se o usuário interagir com a página
            document.addEventListener('click', function() {
                if (video.paused) {
                    attemptPlay();
                }
            }, { once: true });

            // Pausar vídeo quando a página não estiver visível
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    video.pause();
                } else {
                    attemptPlay();
                }
            });
        });
    </script>

</body>
</html>
