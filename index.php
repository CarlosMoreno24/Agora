<?php
/* En algunos archivos se adjuntan instrucciones para el desarrollo del sistema.
La persona que esté encargado de esto le pido que lea detenidamente, no escribo esto por gusto.
Este es el archivo principal que carga el sistema de gestión de usuarios de Agora. */
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: Templates/login.php');
    exit();
}

if (!isset($_SESSION['id_usuario'])) {
    die("No estás autenticado.");
}

define('BASE_URL', '/Agora/Modules/Config_User/');

$conn = new mysqli("localhost", "root", "", "Agora");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$usuario_id = $_SESSION['id_usuario'];

$sql = "SELECT ruta FROM imagenes WHERE usuario_id = $usuario_id ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagePath = BASE_URL . $row['ruta'];
} else {
    $imagePath = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #FF4F5E;
            --primary-light: #FFE9EB;
            --primary-lighter: #FFF4F5;
            --primary-dark: #E53E4D;
            --text-primary: #2c3e50;
            --text-secondary: #546e7a;
            --bg-light: #f8fafc;
            --sidebar-width: 250px;
            --sidebar-collapsed: 70px;
            --topbar-height: 70px;
            --card-shadow: 0 4px 20px rgba(255, 79, 94, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-primary);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar mejorado - más estrecho y sin bordes */
        #sidebar {
            width: var(--sidebar-width);
            background: white;
            box-shadow: var(--card-shadow);
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: width 0.3s ease;
        }

        #sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .logo-container {
            padding: 0 20px 25px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo i {
            color: var(--primary);
            font-size: 24px;
        }

        #menu-toggle {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: var(--text-secondary);
            padding: 6px;
            border-radius: 6px;
            transition: background-color 0.2s;
        }

        #menu-toggle:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            color: var(--text-secondary);
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            margin: 6px 0;
        }

        .menu-item:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .menu-item.active {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .menu-item i {
            margin-right: 16px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        #sidebar.collapsed .menu-item span {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        #sidebar.collapsed .menu-item i {
            margin-right: 0;
        }

        /* Main container */
        #main-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Topbar mejorada - sin título */
        #topbar {
            height: var(--topbar-height);
            background: white;
            padding: 0 30px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            z-index: 90;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--text-secondary);
            cursor: pointer;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .user-info:hover {
            background-color: var(--primary-light);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 500;
            font-size: 14px;
            color: var(--text-primary);
        }

        .user-role {
            font-size: 12px;
            color: var(--text-secondary);
        }

        /* Configuración de usuario */
        .user-config {
            position: absolute;
            background-color: white;
            width: 250px;
            top: calc(var(--topbar-height) + 10px);
            right: 20px;
            box-shadow: var(--card-shadow);
            padding: 20px;
            border-radius: 12px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        #btn-user:checked ~ .user-config {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-config-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
        }

        .user-config-header h2 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--text-primary);
        }

        .user-config-header p {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .btn-logout {
            display: block;
            width: 100%;
            padding: 10px;
            background: none;
            border: 1px solid var(--primary);
            color: var(--primary);
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            text-decoration: none;
        }

        .btn-logout:hover {
            background-color: var(--primary);
            color: white;
        }

        /* Iframe principal */
        #main-frame {
            flex-grow: 1;
            border: none;
            width: 100%;
            height: calc(100vh - var(--topbar-height));
            background: white;
        }

        /* Menú móvil */
        #mobile-menu {
            display: none;
            position: fixed;
            top: var(--topbar-height);
            left: 0;
            width: 100%;
            height: calc(100vh - var(--topbar-height));
            background-color: white;
            z-index: 99;
            padding: 20px;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        #mobile-menu.open {
            transform: translateX(0);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            #sidebar {
                position: fixed;
                left: 0;
                height: 100vh;
                transform: translateX(-100%);
                z-index: 100;
            }
            
            #sidebar.open {
                transform: translateX(0);
            }
            
            .mobile-menu-btn {
                display: block;
                position: absolute;
                left: 20px;
            }
        }

        @media (max-width: 768px) {
            #topbar {
                padding: 0 20px;
            }
            
            .user-details {
                display: none;
            }
            
            .user-config {
                width: 230px;
                right: 10px;
            }
        }

        /* Utilidades */
        .hidden {
            display: none;
        }
    </style>
</head>

<body>

    <!-- Menú lateral -->
    <div id="sidebar">
        <div class="logo-container">
            <button id="menu-toggle"><i class="fas fa-bars"></i></button>
        </div>
        
        <div class="menu-item active" onclick="loadPage('Templates/home.php', this)">
            <i class="fas fa-home"></i><span>Inicio</span>
        </div>
        <div class="menu-item" onclick="loadPage('Templates/contactos.php', this)">
            <i class="fas fa-user"></i><span>Contactos</span>
        </div>
        <div class="menu-item" onclick="loadPage('Templates/Gestion_usuarios.html', this)">
            <i class="fa-solid fa-users"></i><span>Gestión de usuarios</span>
        </div>
        <div class="menu-item" onclick="loadPage('Modules/Config_User/config.php', this)">
            <i class="fas fa-cog"></i><span>Configuración</span>
        </div>
    </div>

    <!-- Contenido principal con barra superior e iframe -->
    <div id="main-container">
        <!-- Barra superior - sin título -->
        <div id="topbar">
            <button class="mobile-menu-btn" id="mobile-menu-toggle"><i class="fas fa-bars"></i></button>
            
            <div class="topbar-right">
                <div class="user-info" onclick="toggleUserConfig()">
                    <img src="<?php echo $imagePath; ?>" alt="Avatar" class="user-avatar">
                    <div class="user-details">
                        <div class="user-name"><?php echo $_SESSION['nombre']; ?></div>
                        <div class="user-role">Administrador</div>
                    </div>
                    <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                </div>
                
                <input type="checkbox" id="btn-user" style="display: none;">
                <div class="user-config" id="user-config">
                    <div class="user-config-header">
                        <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?></h2>
                        <p><?php echo $_SESSION['email']; ?></p>
                    </div>
                    <a href="Modules/Login/logout.php" class="btn-logout">Cerrar Sesión</a>
                </div>
            </div>
        </div>

        <!-- Menú desplegable para móviles -->
        <div id="mobile-menu">
            <div class="menu-item" onclick="loadPage('Templates/home.php', this)">
                <i class="fas fa-home"></i><span>Inicio</span>
            </div>
            <div class="menu-item" onclick="loadPage('Templates/contactos.php', this)">
                <i class="fas fa-user"></i><span>Contactos</span>
            </div>
            <div class="menu-item" onclick="loadPage('Templates/Gestion_usuarios.html', this)">
                <i class="fa-solid fa-users"></i><span>Gestión de usuarios</span>
            </div>
            <div class="menu-item" onclick="loadPage('Modules/Config_User/config.php', this)">
                <i class="fas fa-cog"></i><span>Configuración</span>
            </div>
        </div>

        <!-- Frame principal para mostrar el contenido -->
        <iframe id="main-frame" src="Templates/home.php"></iframe>
    </div>

    <script>
        // Toggle sidebar
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
        
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('open');
        });
        
        // Toggle user config
        function toggleUserConfig() {
            const btnUser = document.getElementById('btn-user');
            btnUser.checked = !btnUser.checked;
        }
        
        // Close user config when clicking outside
        document.addEventListener('click', function(event) {
            const userConfig = document.getElementById('user-config');
            const userInfo = document.querySelector('.user-info');
            const btnUser = document.getElementById('btn-user');
            
            if (btnUser.checked && !userConfig.contains(event.target) && !userInfo.contains(event.target)) {
                btnUser.checked = false;
            }
        });
        
        // Load page and update active menu item
        function loadPage(url, element) {
            document.getElementById('main-frame').src = url;
            
            // Update active menu item
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => item.classList.remove('active'));
            element.classList.add('active');
            
            // Close mobile menu after selection
            mobileMenu.classList.remove('open');
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (mobileMenu.classList.contains('open') && 
                !mobileMenu.contains(event.target) && 
                !mobileMenuToggle.contains(event.target)) {
                mobileMenu.classList.remove('open');
            }
        });
    </script>
</body>

</html>