<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/CSS/crearContacto.css">
</head>

<body>
    <div class="container form-container">
        <div class="form-box">
            <a href="../../Templates/contactos.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>

            <!-- Formulario -->
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" autocomplete="off" novalidate>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Ingresa el nombre" required
                        name="name" minlength="2" maxlength="50">
                </div>
                <div class="form-group">
                    <label for="apaterno">Apellido Paterno:</label>
                    <input type="text" class="form-control" id="apaterno" placeholder="Ingresa el apellido paterno"
                        required name="apaterno" minlength="2" maxlength="50">
                </div>
                <div class="form-group">
                    <label for="amaterno">Apellido Materno:</label>
                    <input type="text" class="form-control" id="amaterno" placeholder="Ingresa el apellido materno"
                        required name="amaterno" minlength="2" maxlength="50">
                </div>
                <div class="form-group">
                    <label for="telefono">Número Telefónico:</label>
                    <input type="tel" class="form-control" id="telefono" placeholder="Ingresa el número telefónico"
                        maxlength="15" pattern="[0-9+]{8,15}" required name="num">
                </div>
                <div class="form-group">
                    <label for="whatsapp">WhatsApp:</label>
                    <select class="form-control" id="whatsapp" required name="whatsapp">
                        <option value="">Selecciona una opción</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="formato">Formato:</label>
                    <select class="form-control" id="formato" required name="formato">
                        <option value="">Selecciona una opción</option>
                        <option value="Facebook">Facebook</option>
                        <option value="Familiar">Familiar</option>
                        <option value="Instagram">Instagram</option>
                        <option value="TikTok">TikTok</option>
                        <option value="Amigo">Amigo</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="submit">Guardar</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha384-rOA1PnstxnOBLzCLhp8LecxB8KG8D0x8qs5coC5pPYlq6N9VV+8zjG04R4p9IjOj" crossorigin="anonymous"></script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
        require '../../Config/conexion.php'; // Aquí ya tienes $pdo configurado con PDO seguro

        // Validación básica del lado del servidor
        $name      = trim($_POST["name"] ?? '');
        $apaterno  = trim($_POST["apaterno"] ?? '');
        $amaterno  = trim($_POST["amaterno"] ?? '');
        $num       = trim($_POST["num"] ?? '');
        $whatsapp  = $_POST["whatsapp"] ?? '';
        $formato   = $_POST["formato"] ?? '';

        if ($name && $apaterno && $amaterno && preg_match("/^[0-9+]{8,15}$/", $num) && in_array($whatsapp, ["Sí", "No"]) && !empty($formato)) {
            try {
                $sql = "INSERT INTO contacto (nombre, apaterno, amaterno, numero_telefonico, whatsapp, formato) 
                        VALUES (:nombre, :apaterno, :amaterno, :num, :whatsapp, :formato)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':nombre'   => $name,
                    ':apaterno' => $apaterno,
                    ':amaterno' => $amaterno,
                    ':num'      => $num,
                    ':whatsapp' => $whatsapp,
                    ':formato'  => $formato
                ]);

                echo "<script>
                    window.onload = function() {
                        document.getElementById('overlay').style.display = 'flex';
                    }
                </script>";
            } catch (PDOException $e) {
                error_log('Error al crear contacto: ' . $e->getMessage());
                echo "<div class='alert alert-danger text-center'>Error al crear el contacto.</div>";
            }
        } else {
            echo "<div class='alert alert-warning text-center'>Datos inválidos. Verifica el formulario.</div>";
        }
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha384-ZvpUoO/+Pw5y+q2K6YhEcnPwBOG3bH6z6lXFWjT3zVjwD5JpN96CB2TF+qsSVqU0" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

<!-- Ventana emergente -->
<div class="overlay" id="overlay" style="display: none;">
    <div class="popup">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark-check" fill="none" stroke="#BBCD5D" stroke-width="5"
                d="M14.1 27.2l7.1 7.2 16.7-16.8" />
        </svg>
        <p>¡Operación exitosa!</p>
        <button class="btn-primary" onclick="closePopup()">Aceptar</button>
    </div>
</div>

<script>
    function closePopup() {
        document.getElementById('overlay').style.display = 'none';
    }
</script>

</html>
