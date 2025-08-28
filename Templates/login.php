<?php
session_start();
$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : "";
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Agora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Assets/CSS/login.css">
</head>

<body>
    <div class="auth-container">
        <div class="auth-heading">
            <img src="../Assets/Images/Agora_logo.png" alt="Logo Escuela" style="height: 80px; margin-bottom: 1.5rem;">
            <p>Ingrese sus credenciales de acceso</p>
        </div>

        <?php if (!empty($errorMessage)) : ?>
            <div class="alert alert-danger">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="../Modules/Login/login.php">
            <!-- Campo Email -->
            <div class="input-group-crm">
                <span class="input-icon">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" class="form-control-crm" id="email" name="email" 
                       placeholder="correo@gmail.com" required>
            </div>

            <!-- Campo Contraseña -->
            <div class="input-group-crm">
                <span class="input-icon">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" class="form-control-crm" id="password" name="password" 
                       placeholder="Contraseña" required>
                <span class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye"></i>
                </span>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Ingresar
            </button>

            <div class="text-center mt-4">
                <a href="reset_password.html" class="text-decoration-none text-muted small">
                    ¿Olvidó su Contraseña?
                </a>
                <br>
                <a href="register.php" class="text-decoration-none text-muted small">
                    ¿No tienes cuenta? <span style="color: #FF4F5E;">Regístrate</span>
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
    </script>
</body>

</html>
