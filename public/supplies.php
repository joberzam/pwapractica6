<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';

verificarSesion();
verificarRol([5]); // SOLO proveedor

$supplies = $conn->query("SELECT * FROM supplies")->fetchAll();

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<h2>📦 Necesidades del Hotel</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Descripción</th>
            <th>Ofertar</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach($supplies as $s): ?>
        <tr>
            <td><?= $s['name'] ?></td>
            <td><?= $s['description'] ?></td>
            <td>
                <a href="offer.php?id=<?= $s['id'] ?>" class="btn btn-primary btn-sm">
                    Ofertar
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>