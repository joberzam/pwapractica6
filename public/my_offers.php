<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';

verificarSesion();
verificarRol([5]); // solo proveedor

$stmt = $conn->prepare("
    SELECT o.id, s.name, o.price, o.created_at
    FROM offers o
    JOIN supplies s ON o.supply_id = s.id
    WHERE o.supplier_id = ?
    ORDER BY o.id DESC
");

$stmt->execute([$_SESSION['user']['id']]);
$offers = $stmt->fetchAll();

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<h2>💰 Mis Ofertas</h2>

<div class="card p-3 shadow">

<table class="table table-striped">

    <thead>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Fecha</th>
            <th>Acción</th>
        </tr>
    </thead>

    <tbody>

    <?php if(count($offers) == 0): ?>
        <tr>
            <td colspan="3" class="text-center text-muted">
                No has realizado ofertas
            </td>
        </tr>
    <?php else: ?>

    <?php foreach($offers as $o): ?>
        <tr>
            <td><?= $o['name'] ?></td>
            <td>$<?= $o['price'] ?></td>
            <td><?= $o['created_at'] ?></td>
            <td>
                <a href="edit_offer.php?id=<?= $o['id'] ?>" 
                class="btn btn-warning btn-sm">Editar</a>

                <a href="delete_offer.php?id=<?= $o['id'] ?>" 
                class="btn btn-danger btn-sm"
                onclick="return confirm('¿Eliminar oferta?')">
                Eliminar
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

    <?php endif; ?>

    </tbody>

</table>

</div>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>