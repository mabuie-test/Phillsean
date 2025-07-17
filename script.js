// ===== AJAX GENERIC HANDLER =====
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
    if (json.success) onSuccess();
  })
  .catch(err => {
    alert(`Falha ao conectar com ${endpoint}:\n${err.message}`);
  });
}

// ===== AJAX: REGISTER =====
document.getElementById('register-btn').addEventListener('click', e => {
  e.preventDefault();
  handleFetch('/register.php', {
    name:     document.getElementById('reg-name').value.trim(),
    email:    document.getElementById('reg-email').value.trim(),
    password: document.getElementById('reg-password').value
  }, showLoginForm);
});

// ===== AJAX: LOGIN =====
document.getElementById('login-btn').addEventListener('click', e => {
  e.preventDefault();
  handleFetch('/login.php', {
    email:    document.getElementById('login-email').value.trim(),
    password: document.getElementById('login-password').value
  }, () => window.location.reload());
});

// ===== AJAX: LOGOUT =====
const logoutBtn = document.getElementById('logout-btn');
if (logoutBtn) {
  logoutBtn.addEventListener('click', e => {
    e.preventDefault();
    handleFetch('/logout.php', {}, () => window.location = '/index.php');
  });
}
