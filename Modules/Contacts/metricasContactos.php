<?php

$host = "localhost";
$user = "root";
$pwd = "";
$DB = "agora";


$connection = new mysqli($host, $user, $pwd, $DB);

if ($connection->connect_errno) {
    die("Conexión fallida: " . mysqli_connect_error());
}

$db = mysqli_select_db($connection, $DB);


//Conteo de contactos
$sql = mysqli_query($connection, "SELECT * FROM contacto");
$contador = mysqli_num_rows($sql);


//Conteo de nuevos contactos 
$sql = mysqli_query($connection, "SELECT COUNT(*) FROM contacto WHERE fecha_creacion >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
$row = mysqli_fetch_row($sql);
$conteoMes = $row[0];
?>