<?php
require_once "../../Config/conexion.php";
$id = intval($_GET['id']);
$sql = "SELECT * FROM contacto WHERE id_contacto = $id LIMIT 1";
$res = $connection->query($sql);
if ($res && $row = $res->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode([]);
}
?>
