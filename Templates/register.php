<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Agora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Assets/CSS/login.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-heading">
            <h1>Crear Cuenta</h1>
            <p>Registra tus datos para acceder al sistema</p>
        </div>
        <div id="registerAlert" style="display:none;" class="alert"></div>
        <form id="registerForm" autocomplete="off">
            <div class="input-group-crm">
                <span class="input-icon">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" class="form-control-crm" id="nombre" name="nombre" placeholder="Nombre completo" required>
            </div>
            <div class="input-group-crm">
                <span class="input-icon">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" class="form-control-crm" id="email" name="email" placeholder="Correo Electrónico" required>
            </div>
            <div class="input-group-crm">
                <span class="input-icon">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" class="form-control-crm" id="password" name="password" placeholder="Contraseña" required>
                <span class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-user-plus me-2"></i>Registrar
            </button>
            <div class="text-center mt-4">
                <a href="login.php" class="text-decoration-none text-muted small">
                    ¿Ya tienes cuenta? <span style="color: #FF4F5E;">Inicia sesión</span>
                </a>
            </div>
        </form>
    </div>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('.password-toggle i');
            if(passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const nombre = document.getElementById('nombre').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const alertDiv = document.getElementById('registerAlert');
            alertDiv.style.display = 'none';

            try {
                const response = await fetch('../Modules/Gestion_Usuarios/crear_usuario.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({nombre, email, password})
                });
                const data = await response.json();
                if (data.success) {
                    alertDiv.className = 'alert alert-success';
                    alertDiv.textContent = '¡Registro exitoso! Redirigiendo...';
                    alertDiv.style.display = 'block';
                    setTimeout(() => { window.location.href = 'login.php'; }, 1500);
                } else {
                    alertDiv.className = 'alert alert-danger';
                    alertDiv.textContent = data.mensaje || 'Error al registrar';
                    alertDiv.style.display = 'block';
                }
            } catch {
                alertDiv.className = 'alert alert-danger';
                alertDiv.textContent = 'Error de conexión';
                alertDiv.style.display = 'block';
            }
        });
    </script>
</body>
</html>