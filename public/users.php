<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';
require BASE_PATH . '/app/models/User.php';

verificarSesion();
verificarRol([1]);

if($_SESSION['user']['role_id'] != 1){
    exit("Acceso denegado");
}

$users = getUsers($conn);

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<h2>👥 Usuarios</h2>

<a href="create_user.php" class="btn btn-primary mb-3">+ Nuevo Usuario</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>

    <?php foreach($users as $u): ?>
        <tr>
            <td><?= $u['name'] ?></td>
            <td><?= $u['email'] ?></td>
            <td><?= $u['role'] ?></td>
            <td>
                <a href="edit_user.php?id=<?= $u['id'] ?>" 
                class="btn btn-warning btn-sm">Editar</a>

                <a href="delete_user.php?id=<?= $u['id'] ?>" 
                   class="btn btn-danger btn-sm"
                  onclick="return confirm('¿Eliminar usuario?')">
                  Eliminar
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>