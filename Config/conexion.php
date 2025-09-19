<?php
$host = "72.60.123.239";   
$port = 3306;              
$user = "crm_user";        
$pwd  = "90a49c9fa750d43e34db";     
$DB   = "agora";           


$connection = new mysqli($host, $user, $pwd, $DB, $port);


if ($connection->connect_errno) {
    error_log("Error de conexión MySQL ({$connection->connect_errno}): {$connection->connect_error}");
    die("Error de conexión con la base de datos. Contacta al administrador.");
}


if (!$connection->set_charset("utf8mb4")) {
    error_log("Error configurando charset: " . $connection->error);
}

?>
