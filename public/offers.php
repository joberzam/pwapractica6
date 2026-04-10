<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';

verificarSesion();
verificarRol([1,2]); // admin y gerente

$offers = $conn->query("
    SELECT o.id, o.price, o.created_at,
           s.name AS product,
           u.name AS supplier
    FROM offers o
    JOIN supplies s ON o.supply_id = s.id
    JOIN users u ON o.supplier_id = u.id
    ORDER BY o.id DESC
")->fetchAll();

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<h2>💼 Ofertas de Proveedores</h2>

<div class="card p-3 shadow">

<table class="table table-striped">

    <thead>
        <tr>
            <th>Producto</th>
            <th>Proveedor</th>
            <th>Precio</th>
            <th>Fecha</th>
        </tr>
    </thead>

    <tbody>

    <?php if(count($offers) == 0): ?>
        <tr>
            <td colspan="4" class="text-center text-muted">
                No hay ofertas registradas
            </td>
        </tr>
    <?php else: ?>

    <?php foreach($offers as $o): ?>
        <tr>
            <td><?= $o['product'] ?></td>
            <td><?= $o['supplier'] ?></td>
            <td>$<?= $o['price'] ?></td>
            <td><?= $o['created_at'] ?></td>
        </tr>
    <?php endforeach; ?>

    <?php endif; ?>

    </tbody>

</table>

</div>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>