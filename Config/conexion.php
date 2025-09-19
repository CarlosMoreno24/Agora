
<?php
<<<<<<< HEAD
$host = "72.60.123.239";   
$port = 3306;              
$user = "crm_user";        
$pwd  = "90a49c9fa750d43e34db";     
$DB   = "agora";           
=======
//descarga composer y usa el codigo para instalar la extension (composer require vlucas/phpdotenv)
require __DIR__ . '/../vendor/autoload.php';
>>>>>>> 65b148b5ccb4a7f55acce752b81ee09bf6c32467

use Dotenv\Dotenv;

<<<<<<< HEAD
$connection = new mysqli($host, $user, $pwd, $DB, $port);


if ($connection->connect_errno) {
    error_log("Error de conexión MySQL ({$connection->connect_errno}): {$connection->connect_error}");
    die("Error de conexión con la base de datos. Contacta al administrador.");
}


if (!$connection->set_charset("utf8mb4")) {
    error_log("Error configurando charset: " . $connection->error);
}

?>
=======
// Cargar variables desde el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$db   = $_ENV['DB_DATABASE'];
$user = $_ENV['DB_USERNAME'];
$pass = $_ENV['DB_PASSWORD'];
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Manejo de errores con excepciones
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,      // Fetch en array asociativo
    PDO::ATTR_EMULATE_PREPARES   => false,                 // Usar prepared statements nativos
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Nunca mostrar errores directamente en producción
    error_log("Error de conexión: " . $e->getMessage());
    die("Error de conexión a la base de datos.");
}
>>>>>>> 65b148b5ccb4a7f55acce752b81ee09bf6c32467
