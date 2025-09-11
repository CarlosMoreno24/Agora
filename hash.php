<?php

// Definir la contraseña en texto plano que deseas hashear
$contrasena_a_hashear = "1234";

// Generar el hash de la contraseña usando un algoritmo fuerte y seguro
// PASSWORD_DEFAULT utiliza el algoritmo más actual y recomendado (actualmente, Argon2id o Bcrypt)
$hash_generado = password_hash($contrasena_a_hashear, PASSWORD_DEFAULT);

// Mostrar el resultado en la pantalla
echo "<h1>Hash de Contraseña Generado</h1>";
echo "<p>Contraseña en texto plano: <strong>" . htmlspecialchars($contrasena_a_hashear) . "</strong></p>";
echo "<p>Hash para la base de datos:</p>";
echo "<code><strong>" . htmlspecialchars($hash_generado) . "</strong></code>";
echo "<p>Copia el valor del hash y pégalo en el campo 'password' de tu tabla de usuarios.</p>";
?>