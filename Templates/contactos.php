<?php
require_once "../Config/conexion.php";

// Consulta de contactos
$sql = "SELECT id_contacto, nombre, apaterno, amaterno, numero_telefonico, whatsapp, formato, fecha_creacion FROM contacto ORDER BY fecha_creacion DESC";
$result = $connection->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos CRM</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Assets/CSS/crm.css">
    <link rel="stylesheet" href="../Assets/CSS/contactos.css">
</head>
<body>
    <div class="crm-container">
        <!-- Encabezado y acciones principales -->
        <div class="crm-header">
            <div class="crm-header-left">
                <h1 class="crm-header-title">Contactos</h1>
                <span class="crm-header-count"><?php echo $result->num_rows; ?> registros</span>
            </div>
            <div class="crm-header-actions">
                <button class="crm-btn crm-btn-secondary">
                    <i class="fas fa-upload"></i> Importar
                </button>
                <a href="../Modules/Contacts/Crear.php" class="crm-btn crm-btn-primary">
                    <i class="fas fa-user-plus"></i> Crear contacto
                </a>
            </div>
        </div>

        <!-- Filtros tipo chips/pestañas -->
        <div class="crm-filters-bar">
            <div class="crm-chip active">Todos los contactos</div>
            <div class="crm-chip">Suscriptores del boletín</div>
            <div class="crm-chip">Suscripción cancelada</div>
            <div class="crm-chip">Todos los clientes</div>
            <div class="crm-chip crm-chip-add">
                <i class="fas fa-plus"></i> Agregar vista
            </div>
            <div class="crm-chip crm-chip-link">Todas las vistas</div>
        </div>

        <!-- Filtros avanzados y búsqueda -->
        <div class="crm-toolbar">
            <div class="crm-toolbar-filters">
                <select class="crm-select">
                    <option>Propietario del contacto</option>
                </select>
                <select class="crm-select">
                    <option>Fecha de creación</option>
                </select>
                <select class="crm-select">
                    <option>Última actividad</option>
                </select>
                <select class="crm-select">
                    <option>Estado del lead</option>
                </select>
                <button class="crm-btn crm-btn-link">
                    <i class="fas fa-filter"></i> Filtros avanzados
                </button>
            </div>
            <div class="crm-search-container">
                <i class="fas fa-search crm-search-icon"></i>
                <input type="text" class="crm-search" placeholder="Buscar nombre, teléfono, correo...">
            </div>
        </div>

        <!-- Tabla de contactos -->
        <div class="table-container">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox"></th>
                        <th>Nombre</th>
                        <th>Correo electrónico</th>
                        <th>Número de teléfono</th>
                        <th>WhatsApp</th>
                        <th>Formato</th>
                        <th>Fecha de creación</th>
                        <th style="width: 100px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>
                                <div class="contact-info">
                                    <div class="crm-avatar">
                                        <?php
                                            $iniciales = strtoupper(mb_substr($row['nombre'],0,1) . mb_substr($row['apaterno'],0,1));
                                            echo $iniciales;
                                        ?>
                                    </div>
                                    <div>
                                        <div class="contact-name"><?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apaterno'] . ' ' . $row['amaterno']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>--</td>
                            <td><?php echo htmlspecialchars($row['numero_telefonico']); ?></td>
                            <td><?php echo htmlspecialchars($row['whatsapp']); ?></td>
                            <td><?php echo htmlspecialchars($row['formato']); ?></td>
                            <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($row['fecha_creacion']))); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="../Modules/Contacts/Actualizar.php?id=<?php echo $row['id_contacto']; ?>" class="icon-btn edit-btn"><i class="fas fa-edit"></i></a>
                                    <a href="../Modules/Contacts/Eliminar.php?id=<?php echo $row['id_contacto']; ?>" class="icon-btn delete-btn"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align:center;color:var(--text-secondary);">No hay contactos registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación y controles -->
        <div class="crm-pagination">
            <div class="pagination-info">Mostrando <?php echo $result->num_rows; ?> de <?php echo $result->num_rows; ?> contactos</div>
            <div class="pagination-controls">
                <select class="crm-select">
                    <option>25 por página</option>
                    <option>50 por página</option>
                    <option>100 por página</option>
                </select>
                <button class="crm-btn crm-btn-link" disabled>
                    <i class="fas fa-chevron-left"></i> Anterior
                </button>
                <span>1</span>
                <button class="crm-btn crm-btn-link">
                    Siguiente <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Notificación global -->
    <div id="crm-notification" class="crm-notification"></div>

    <!-- Sidebar Modal para editar contacto -->
    <div id="editSidebar" class="crm-sidebar-modal">
        <div class="crm-sidebar-content">
            <div class="crm-sidebar-header">
                <h2>Editar Contacto</h2>
                <button class="crm-sidebar-close" onclick="closeSidebar()"><i class="fas fa-times"></i></button>
            </div>
            <form id="editContactForm">
                <input type="hidden" name="id_contacto" id="edit_id_contacto">
                <div class="crm-form-group">
                    <label for="edit_nombre">Nombre</label>
                    <input type="text" name="nombre" id="edit_nombre" required>
                </div>
                <div class="crm-form-group">
                    <label for="edit_apaterno">Apellido Paterno</label>
                    <input type="text" name="apaterno" id="edit_apaterno" required>
                </div>
                <div class="crm-form-group">
                    <label for="edit_amaterno">Apellido Materno</label>
                    <input type="text" name="amaterno" id="edit_amaterno" required>
                </div>
                <div class="crm-form-group">
                    <label for="edit_numero_telefonico">Número Telefónico</label>
                    <input type="text" name="numero_telefonico" id="edit_numero_telefonico" required>
                </div>
                <div class="crm-form-group">
                    <label for="edit_whatsapp">WhatsApp</label>
                    <select name="whatsapp" id="edit_whatsapp">
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="crm-form-group">
                    <label for="edit_formato">Formato</label>
                    <input type="text" name="formato" id="edit_formato">
                </div>
                <div class="crm-sidebar-actions">
                    <button type="submit" class="crm-btn crm-btn-primary">Guardar</button>
                    <button type="button" class="crm-btn crm-btn-secondary" onclick="closeSidebar()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Funcionalidad básica para los chips
        document.querySelectorAll('.crm-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                if (!this.classList.contains('crm-chip-add') && !this.classList.contains('crm-chip-link')) {
                    document.querySelectorAll('.crm-chip').forEach(c => {
                        c.classList.remove('active');
                    });
                    this.classList.add('active');
                }
            });
        });

        // Abrir sidebar y cargar datos del contacto
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                // Obtener el id_contacto desde la URL
                const id = url.split('=')[1];
                fetch('../Modules/Contacts/fetch_contacto.php?id=' + id)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit_id_contacto').value = data.id_contacto;
                        document.getElementById('edit_nombre').value = data.nombre;
                        document.getElementById('edit_apaterno').value = data.apaterno;
                        document.getElementById('edit_amaterno').value = data.amaterno;
                        document.getElementById('edit_numero_telefonico').value = data.numero_telefonico;
                        document.getElementById('edit_whatsapp').value = data.whatsapp;
                        document.getElementById('edit_formato').value = data.formato;
                        document.getElementById('editSidebar').classList.add('open');
                    });
            });
        });

        const searchInput = document.querySelector('.crm-search');
        const tableBody = document.querySelector('.crm-table tbody');

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            fetch(`../Modules/Contacts/buscar_contactos.php?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length === 0) {
                        tableBody.innerHTML = `<tr>
                            <td colspan="8" style="text-align:center;color:var(--text-secondary);">No hay contactos encontrados.</td>
                        </tr>`;
                        return;
                    }
                    data.forEach(row => {
                        const iniciales = (row.nombre ? row.nombre.charAt(0) : '') + (row.apaterno ? row.apaterno.charAt(0) : '');
                        tableBody.innerHTML += `
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>
                                <div class="contact-info">
                                    <div class="crm-avatar">${iniciales.toUpperCase()}</div>
                                    <div>
                                        <div class="contact-name">${row.nombre} ${row.apaterno} ${row.amaterno}</div>
                                    </div>
                                </div>
                            </td>
                            <td>--</td>
                            <td>${row.numero_telefonico}</td>
                            <td>${row.whatsapp}</td>
                            <td>${row.formato}</td>
                            <td>${row.fecha_creacion ? row.fecha_creacion.substring(0,10) : ''}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="../Modules/Contacts/Actualizar.php?id=${row.id_contacto}" class="icon-btn edit-btn"><i class="fas fa-edit"></i></a>
                                    <a href="../Modules/Contacts/Eliminar.php?id=${row.id_contacto}" class="icon-btn delete-btn"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>`;
                    });
                    // Re-asigna eventos a los nuevos botones de editar
                    document.querySelectorAll('.edit-btn').forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const url = this.getAttribute('href');
                            const id = url.split('=')[1];
                            fetch('../Modules/Contacts/fetch_contacto.php?id=' + id)
                                .then(res => res.json())
                                .then(data => {
                                    document.getElementById('edit_id_contacto').value = data.id_contacto;
                                    document.getElementById('edit_nombre').value = data.nombre;
                                    document.getElementById('edit_apaterno').value = data.apaterno;
                                    document.getElementById('edit_amaterno').value = data.amaterno;
                                    document.getElementById('edit_numero_telefonico').value = data.numero_telefonico;
                                    document.getElementById('edit_whatsapp').value = data.whatsapp;
                                    document.getElementById('edit_formato').value = data.formato;
                                    document.getElementById('editSidebar').classList.add('open');
                                });
                        });
                    });
                });
        });

        function closeSidebar() {
            document.getElementById('editSidebar').classList.remove('open');
        }

        // Guardar cambios
        document.getElementById('editContactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('../Modules/Contacts/Actualizar.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(resp => {
                if (resp.success) {
                    showNotification('Contacto actualizado correctamente', 'success');
                    setTimeout(() => location.reload(), 1200);
                    closeSidebar();
                } else {
                    showNotification('Error al guardar los cambios', 'error');
                }
            });
        });
    </script>
    <script src="../Assets/JS/crm.js"></script>
</body>
</html>