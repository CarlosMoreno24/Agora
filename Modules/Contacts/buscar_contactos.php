<?php
require_once "../../Config/conexion.php";
$busqueda = isset($_GET['q']) ? $connection->real_escape_string($_GET['q']) : '';
$sql = "SELECT id_contacto, nombre, apaterno, amaterno, numero_telefonico, whatsapp, formato, fecha_creacion 
        FROM contacto 
        WHERE nombre LIKE '%$busqueda%' 
           OR apaterno LIKE '%$busqueda%' 
           OR amaterno LIKE '%$busqueda%' 
           OR numero_telefonico LIKE '%$busqueda%' 
           OR whatsapp LIKE '%$busqueda%' 
           OR formato LIKE '%$busqueda%'
        ORDER BY fecha_creacion DESC";
$result = $connection->query($sql);

$contactos = [];
while($row = $result->fetch_assoc()) {
    $contactos[] = $row;
}
header('Content-Type: application/json');
echo json_encode($contactos);
?>