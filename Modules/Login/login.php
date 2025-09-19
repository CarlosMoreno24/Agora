<?php
session_start();
require_once "../../Config/conexion.php"; // aquí ya tienes $pdo creado con PDO y .env

// 1. Sanitizar entrada básica
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    $_SESSION['error'] = "Datos inválidos.";
    header('Location: ../../Templates/login.php');
    exit();
}

// 2. Consulta preparada para obtener al usuario
$sql = "SELECT id_usuario, nombre, apaterno, amaterno, email, password, estado, tipo_usuario 
        FROM usuario 
        WHERE email = :email 
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch();

if ($user) {
    // 3. Verificar contraseña con hash seguro
    if (password_verify($password, $user['password'])) {
        if ($user['estado'] == 1) {
            // 4. Guardar datos en sesión
            $_SESSION['id_usuario']   = $user['id_usuario'];
            $_SESSION['nombre']       = $user['nombre'];
            $_SESSION['apaterno']     = $user['apaterno'];
            $_SESSION['amaterno']     = $user['amaterno'];
            $_SESSION['email']        = $user['email'];
            $_SESSION['tipo_usuario'] = $user['tipo_usuario'];
            $_SESSION['usuario']      = $user['email'];

            header('Location: ../../index.php');
            exit();
        } else {
            $_SESSION['error'] = "Usuario inactivo.";
        }
    } else {
        $_SESSION['error'] = "Contraseña incorrecta.";
    }
} else {
    $_SESSION['error'] = "Usuario no encontrado.";
}

// Redirigir siempre al login si hay error
header('Location: ../../Templates/login.php');
exit();
