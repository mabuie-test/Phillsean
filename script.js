// Mobile Menu Toggle
const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const mainMenu = document.getElementById('main-menu');
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

// AUTH: login / register via AJAX
const authModal = document.getElementById('auth-modal');
const loginForm  = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');
const loginTab = document.getElementById('login-tab');
const registerTab = document.getElementById('register-tab');

function showLoginForm() {
  loginTab.classList.add('active'); registerTab.classList.remove('active');
  loginForm.style.display  = 'block'; registerForm.style.display = 'none';
}
function showRegisterForm() {
  registerTab.classList.add('active'); loginTab.classList.remove('active');
  registerForm.style.display = 'block'; loginForm.style.display = 'none';
}

document.getElementById('login-btn').addEventListener('click', e => {
  e.preventDefault();
  fetch('login.php', {
    method: 'POST',
    headers: {'Content-Type':'application/json'},
    body: JSON.stringify({
      email: document.getElementById('login-email').value,
      password: document.getElementById('login-password').value
    })
  })
  .then(r => r.json()).then(js => {
    alert(js.message);
    if (js.success) location.reload();
  });
});

document.getElementById('register-btn').addEventListener('click', e => {
  e.preventDefault();
  fetch('register.php', {
    method: 'POST',
    headers: {'Content-Type':'application/json'},
    body: JSON.stringify({
      name: document.getElementById('reg-name').value,
      email: document.getElementById('reg-email').value,
      password: document.getElementById('reg-password').value
    })
  })
  .then(r => r.json()).then(js => {
    alert(js.message);
    if (js.success) showLoginForm();
  });
});

// SERVICE ORDER (reserva) via AJAX → send_email.php
const orderForm = document.getElementById('service-order-form');
if (orderForm) {
  orderForm.addEventListener('submit', e => {
    e.preventDefault();
    const data = {
      name: document.getElementById('name').value,
      company: document.getElementById('company').value,
      email: document.getElementById('email').value,
      phone: document.getElementById('phone')?.value || '',
      vessel: document.getElementById('vessel')?.value || '',
      port: document.getElementById('port')?.value || '',
      date: document.getElementById('date')?.value || '',
      service: document.getElementById('service')?.value || '',
      quantity: document.getElementById('quantity')?.value || '',
      notes: document.getElementById('notes')?.value || ''
    };
    fetch('send_email.php', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify(data)
    })
    .then(r => r.json()).then(js => {
      const fm = document.getElementById('form-messages');
      fm.className = js.success ? 'success' : 'error';
      fm.innerHTML = `<i class="fas fa-${js.success?'check-circle':'exclamation-circle'}"></i> ${js.message}`;
      if (js.success) orderForm.reset();
    });
  });
}
