// Mobile Menu Toggle
const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const mainMenu      = document.getElementById('main-menu');
mobileMenuBtn.addEventListener('click', () => {
  mainMenu.classList.toggle('show');
});

// Smooth Scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    e.preventDefault();
    const tgt = document.querySelector(this.getAttribute('href'));
    if (tgt) {
      mainMenu.classList.remove('show');
      window.scrollTo({ top: tgt.offsetTop - 80, behavior: 'smooth' });
    }
  });
});

// ===== AUTH MODAL HANDLERS =====
const authModal      = document.getElementById('auth-modal');
const loginForm      = document.getElementById('login-form');
const registerForm   = document.getElementById('register-form');
const loginTab       = document.getElementById('login-tab');
const registerTab    = document.getElementById('register-tab');
const btnNavLogin    = document.getElementById('login-btn-nav');
const btnNavRegister = document.getElementById('register-btn-nav');
const closeAuthBtn   = document.getElementById('close-auth-modal');

// Abre o modal em modo Login
btnNavLogin.addEventListener('click', e => {
  e.preventDefault();
  authModal.style.display = 'flex';
  showLoginForm();
});

// Abre o modal em modo Registrar
btnNavRegister.addEventListener('click', e => {
  e.preventDefault();
  authModal.style.display = 'flex';
  showRegisterForm();
});

// Fecha ao clicar no “×”
closeAuthBtn.addEventListener('click', () => {
  authModal.style.display = 'none';
});

// Fecha ao clicar fora do conteúdo do modal
authModal.addEventListener('click', e => {
  if (e.target === authModal) {
    authModal.style.display = 'none';
  }
});

// Troca de abas
loginTab.addEventListener('click', showLoginForm);
registerTab.addEventListener('click', showRegisterForm);

function showLoginForm() {
  loginTab.classList.add('active');
  registerTab.classList.remove('active');
  loginForm.style.display     = 'block';
  registerForm.style.display  = 'none';
}

function showRegisterForm() {
  registerTab.classList.add('active');
  loginTab.classList.remove('active');
  registerForm.style.display  = 'block';
  loginForm.style.display     = 'none';
}

// ===== AJAX: REGISTER =====
document.getElementById('register-btn').addEventListener('click', e => {
  e.preventDefault();
  const payload = {
    name:     document.getElementById('reg-name').value.trim(),
    email:    document.getElementById('reg-email').value.trim(),
    password: document.getElementById('reg-password').value
  };
  fetch('register.php', {
    method:  'POST',
    headers: {'Content-Type':'application/json'},
    body:    JSON.stringify(payload)
  })
  .then(r => r.json())
  .then(js => {
    alert(js.message);
    if (js.success) showLoginForm();
  })
  .catch(() => alert('Erro ao conectar com o servidor.'));
});

// ===== AJAX: LOGIN =====
document.getElementById('login-btn').addEventListener('click', e => {
  e.preventDefault();
  const payload = {
    email:    document.getElementById('login-email').value.trim(),
    password: document.getElementById('login-password').value
  };
  fetch('login.php', {
    method:  'POST',
    headers: {'Content-Type':'application/json'},
    body:    JSON.stringify(payload)
  })
  .then(r => r.json())
  .then(js => {
    alert(js.message);
    if (js.success) window.location.reload();
  })
  .catch(() => alert('Erro ao conectar com o servidor.'));
});

// ===== AJAX: LOGOUT =====
const logoutBtn = document.getElementById('logout-btn');
if (logoutBtn) {
  logoutBtn.addEventListener('click', e => {
    e.preventDefault();
    fetch('logout.php', { method: 'POST' })
      .then(r => r.json())
      .then(js => {
        if (js.success) window.location = 'index.php';
        else alert('Falha no logout.');
      })
      .catch(() => alert('Erro ao conectar com o servidor.'));
  });
}

// ===== SERVICE ORDER (reserva) via AJAX =====
const orderForm = document.getElementById('service-order-form');
if (orderForm) {
  orderForm.addEventListener('submit', e => {
    e.preventDefault();
    const data = {
      name:     document.getElementById('name').value,
      company:  document.getElementById('company').value,
      email:    document.getElementById('email').value,
      phone:    document.getElementById('phone')?.value || '',
      vessel:   document.getElementById('vessel')?.value || '',
      port:     document.getElementById('port')?.value || '',
      date:     document.getElementById('date')?.value || '',
      service:  document.getElementById('service')?.value || '',
      quantity: document.getElementById('quantity')?.value || '',
      notes:    document.getElementById('notes')?.value || ''
    };
    fetch('send_email.php', {
      method:  'POST',
      headers: {'Content-Type':'application/json'},
      body:    JSON.stringify(data)
    })
    .then(r => r.json())
    .then(js => {
      const fm = document.getElementById('form-messages');
      fm.className = js.success ? 'success' : 'error';
      fm.innerHTML = `<i class="fas fa-${js.success?'check-circle':'exclamation-circle'}"></i> ${js.message}`;
      if (js.success) orderForm.reset();
    })
    .catch(() => alert('Erro ao enviar a solicitação.'));
  });
}
