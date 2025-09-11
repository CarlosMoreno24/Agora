
<?php
//descarga composer y usa el codigo para instalar la extension (composer require vlucas/phpdotenv)
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

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