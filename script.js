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

  // AJAX generic handler
  function handleFetch(endpoint, payload, onSuccess) {
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
      alert(json.message);
      if (json.success && typeof onSuccess === 'function') {
        onSuccess(json);
      }
    })
    .catch(err => {
      alert(`Falha ao conectar com ${endpoint}:\n${err.message}`);
    });
  }

  // REGISTER via AJAX
  document.getElementById('register-submit-btn')?.addEventListener('click', e => {
    e.preventDefault();
    handleFetch('register.php', {
      name:     document.getElementById('reg-name').value.trim(),
      email:    document.getElementById('reg-email').value.trim(),
      password: document.getElementById('reg-password').value
    }, showLoginForm);
  });

  // LOGIN via AJAX
  document.getElementById('login-submit-btn')?.addEventListener('click', e => {
    e.preventDefault();
    handleFetch('login.php', {
      email:    document.getElementById('login-email').value.trim(),
      password: document.getElementById('login-password').value
    }, () => window.location.reload());
  });

  // LOGOUT via AJAX
  document.getElementById('logout-btn')?.addEventListener('click', e => {
    e.preventDefault();
    handleFetch('logout.php', {}, () => window.location = 'index.php');
  });

  // SERVICE ORDER via AJAX (form)
  const orderForm = document.getElementById('service-order-form');
  if (orderForm) {
    orderForm.addEventListener('submit', e => {
      e.preventDefault();
      const data = {
        service:  document.getElementById('service').value || '',
        name:     document.getElementById('name').value,
        email:    document.getElementById('email').value,
        details: {
          company:  document.getElementById('company').value,
          phone:    document.getElementById('phone').value,
          vessel:   document.getElementById('vessel').value,
          port:     document.getElementById('port').value,
          date:     document.getElementById('date').value,
          quantity: document.getElementById('quantity').value,
          notes:    document.getElementById('notes').value
        }
      };
      handleFetch('create_order.php', data, () => {
        // mostra modal de confirmação
        document.getElementById('order-modal').style.display = 'flex';
        orderForm.reset();
      });
    });
  }

  // SERVICE CARD “Solicitar” buttons
  document.querySelectorAll('.request-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const service = btn.dataset.service;
      const payload = {
        service,
        name:  prompt('Seu nome'),
        email: prompt('Seu email'),
        details: {}  // sem detalhes adicionais nesse fluxo
      };
      if (!payload.name || !payload.email) {
        return alert('Nome e email são necessários.');
      }
      handleFetch('create_order.php', payload, () => {
        // após criar, redireciona ao portal ou mostra alerta
        window.location.href = 'client-portal.php';
      });
    });
  });
});
