<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';
require BASE_PATH . '/app/models/Room.php';

verificarSesion();
verificarRol([1,2]);

$rooms = getRooms($conn);

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<h2>🏨 Habitaciones</h2>

<a href="create_room.php" class="btn btn-primary mb-3">+ Nueva Habitación</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Número</th>
            <th>Tipo</th>
            <th>Precio</th>
            <th>Estado</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach($rooms as $r): ?>
        <tr>
            <td><?= $r['room_number'] ?></td>
            <td><?= $r['room_type'] ?></td>
            <td>$<?= $r['room_price'] ?></td>
            <td>
              <a href="edit_room.php?id=<?= $r['id'] ?>" 
              class="btn btn-warning btn-sm">Editar</a>

                <a href="toggle_room.php?id=<?= $r['id'] ?>" 
                    class="btn btn-secondary btn-sm">
                    <?= $r['is_available'] ? 'Ocupar' : 'Liberar' ?>
                </a>
                <a href="delete_room.php?id=<?= $r['id'] ?>" 
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('¿Eliminar habitación?')">
                    Eliminar
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>