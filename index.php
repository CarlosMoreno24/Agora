<?php
/* Archivo principal del sistema Agora */
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: Templates/login.php');
    exit();
}

if (!isset($_SESSION['id_usuario'])) {
    die("No estás autenticado.");
}

// Base URL para imágenes de usuario
define('BASE_URL', '/Agora/Modules/Config_User/');

// Incluir conexión centralizada con PDO
require_once __DIR__ . '/Config/conexion.php';

$usuario_id = $_SESSION['id_usuario'];

// Consulta segura con PDO
$sql = "SELECT ruta 
        FROM imagenes 
        WHERE usuario_id = :usuario_id 
        ORDER BY id DESC 
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute(['usuario_id' => $usuario_id]);
$row = $stmt->fetch();

if ($row) {
    $imagePath = BASE_URL . $row['ruta'];
} else {
    $imagePath = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/css/index.css">
</head>
<body>
    <!-- Sidebar -->
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

    <!-- Contenedor principal -->
    <div id="main-container">
        <div id="topbar">
            <button class="mobile-menu-btn" id="mobile-menu-toggle"><i class="fas fa-bars"></i></button>
            
            <div class="topbar-right">
                <div class="user-info" onclick="toggleUserConfig()">
                    <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Avatar" class="user-avatar">
                    <div class="user-details">
                        <div class="user-name"><?php echo htmlspecialchars($_SESSION['nombre']); ?></div>
                        <div class="user-role">Administrador</div>
                    </div>
                    <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                </div>
                
                <input type="checkbox" id="btn-user" style="display: none;">
                <div class="user-config" id="user-config">
                    <div class="user-config-header">
                        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
                        <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    </div>
                    <a href="Modules/Login/logout.php" class="btn-logout">Cerrar Sesión</a>
                </div>
            </div>
        </div>

        <!-- Menú móvil -->
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

        <!-- Contenido principal -->
        <iframe id="main-frame" src="Templates/home.php"></iframe>
    </div>
 <script src="Assets/js/index1.js"></script>

</body>
</html>
