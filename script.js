document.addEventListener('DOMContentLoaded', () => {
  // Mobile Menu Toggle
  const mobileMenuBtn = document.getElementById('mobile-menu-btn');
  const mainMenu      = document.getElementById('main-menu');
  mobileMenuBtn?.addEventListener('click', () => {
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

  // AUTH MODAL HANDLERS
  const authModal      = document.getElementById('auth-modal');
  const loginForm      = document.getElementById('login-form');
  const registerForm   = document.getElementById('register-form');
  const loginTab       = document.getElementById('login-tab');
  const registerTab    = document.getElementById('register-tab');
  const btnNavLogin    = document.getElementById('login-btn-nav');
  const btnNavRegister = document.getElementById('register-btn-nav');
  const closeAuthBtn   = document.getElementById('close-auth-modal');

  console.log('Auth elements:', {
    authModal, loginForm, registerForm,
    btnNavLogin, btnNavRegister,
    document.getElementById('register-btn'),
    document.getElementById('login-btn')
  });

  // Abre modal
  btnNavLogin?.addEventListener('click', e => {
    e.preventDefault();
    authModal.style.display = 'flex';
    showLoginForm();
  });
  btnNavRegister?.addEventListener('click', e => {
    e.preventDefault();
    authModal.style.display = 'flex';
    showRegisterForm();
  });
  closeAuthBtn?.addEventListener('click', () => {
    authModal.style.display = 'none';
  });
  authModal?.addEventListener('click', e => {
    if (e.target === authModal) authModal.style.display = 'none';
  });

  loginTab?.addEventListener('click', showLoginForm);
  registerTab?.addEventListener('click', showRegisterForm);

  function showLoginForm() {
    loginTab.classList.add('active');
    registerTab.classList.remove('active');
    loginForm.style.display    = 'block';
    registerForm.style.display = 'none';
  }
  function showRegisterForm() {
    registerTab.classList.add('active');
    loginTab.classList.remove('active');
    registerForm.style.display = 'block';
    loginForm.style.display    = 'none';
  }

  // GENERIC AJAX HANDLER
  function handleFetch(endpoint, payload, onSuccess) {
    console.log(`Fetch ${endpoint}`, payload);
    fetch(endpoint, {
      method:  'POST',
      headers: {'Content-Type':'application/json'},
      body:    JSON.stringify(payload)
    })
    .then(response => {
      if (!response.ok) {
        return response.text().then(text => {
          alert(`Erro HTTP ${response.status} em ${endpoint}:\n${text}`);
          throw new Error(`HTTP ${response.status}`);
        });
      }
      return response.json();
    })
    .then(json => {
      console.log(`${endpoint} resposta:`, json);
      alert(json.message);
      if (json.success) onSuccess();
    })
    .catch(err => {
      console.error(`Falha ao conectar com ${endpoint}:`, err);
      alert(`Falha ao conectar com ${endpoint}:\n${err.message}`);
    });
  }

  // REGISTER
  const registerBtn = document.getElementById('register-btn');
  registerBtn?.addEventListener('click', e => {
    e.preventDefault();
    console.log('Clicou registrar');
    handleFetch('register.php', {
      name:     document.getElementById('reg-name').value.trim(),
      email:    document.getElementById('reg-email').value.trim(),
      password: document.getElementById('reg-password').value
    }, showLoginForm);
  });

  // LOGIN
  const loginBtn = document.getElementById('login-btn');
  loginBtn?.addEventListener('click', e => {
    e.preventDefault();
    console.log('Clicou login');
    handleFetch('login.php', {
      email:    document.getElementById('login-email').value.trim(),
      password: document.getElementById('login-password').value
    }, () => window.location.reload());
  });

  // LOGOUT
  const logoutBtn = document.getElementById('logout-btn');
  logoutBtn?.addEventListener('click', e => {
    e.preventDefault();
    console.log('Clicou logout');
    handleFetch('logout.php', {}, () => window.location = 'index.php');
  });

  // SERVICE ORDER via AJAX (mantido igual)
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
      .catch(err => {
        console.error('Erro no send_email:', err);
        alert('Erro ao enviar a solicitação.');
      });
    });
  }
});
