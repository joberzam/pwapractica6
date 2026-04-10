<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';
require BASE_PATH . '/app/models/Booking.php';

verificarSesion();
verificarRol([1,2,3,4]);

$bookings = getBookings($conn);

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<h2>📅 Reservas</h2>

<a href="create_booking.php" class="btn btn-primary mb-3">+ Nueva Reserva</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Habitación</th>
            <th>Ingreso</th>
            <th>Salida</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach($bookings as $b): ?>
        <tr>
            <td><?= $b['user'] ?></td>
            <td><?= $b['room_number'] ?></td>
            <td><?= $b['check_in_date'] ?></td>
            <td><?= $b['check_out_date'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>