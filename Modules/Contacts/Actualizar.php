<?php
require_once "../../Config/conexion.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_contacto']);
    $nombre = $connection->real_escape_string($_POST['nombre']);
    $apaterno = $connection->real_escape_string($_POST['apaterno']);
    $amaterno = $connection->real_escape_string($_POST['amaterno']);
    $numero_telefonico = $connection->real_escape_string($_POST['numero_telefonico']);
    $whatsapp = $connection->real_escape_string($_POST['whatsapp']);
    $formato = $connection->real_escape_string($_POST['formato']);

    $sql = "UPDATE contacto SET nombre='$nombre', apaterno='$apaterno', amaterno='$amaterno', numero_telefonico='$numero_telefonico', whatsapp='$whatsapp', formato='$formato' WHERE id_contacto=$id";
    if ($connection->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $connection->error]);
    }
    exit;
}
?>
