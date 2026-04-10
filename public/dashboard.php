<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';

verificarSesion();

$rol = $_SESSION['user']['role_id'];

// KPIs
$totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalRooms = $conn->query("SELECT COUNT(*) FROM rooms")->fetchColumn();
$availableRooms = $conn->query("SELECT COUNT(*) FROM rooms WHERE is_available = 1")->fetchColumn();
$totalBookings = $conn->query("SELECT COUNT(*) FROM bookings")->fetchColumn();

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<?php if($rol == 2): ?>

<h2>🏨 Panel del Gerente</h2>

<div class="row">

    <div class="col-md-4">
        <div class="card p-3 text-white bg-success shadow">
            <h5>Habitaciones</h5>
            <h2><?= $totalRooms ?></h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 text-white bg-primary shadow">
            <h5>Disponibles</h5>
            <h2><?= $availableRooms ?></h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 text-white bg-warning shadow">
            <h5>Reservas</h5>
            <h2><?= $totalBookings ?></h2>
        </div>
    </div>

</div>

<div class="mt-4">
    <a href="rooms.php" class="btn btn-success">Gestionar habitaciones</a>
    <a href="offers.php" class="btn btn-primary">Ver ofertas</a>
</div>

<?php elseif($rol == 5): ?>

<h2>📦 Panel del Proveedor</h2>

<div class="card p-4 shadow" style="max-width:600px;">
    <p>Bienvenido. Aquí puedes:</p>
    <ul>
        <li>Ver necesidades del hotel</li>
        <li>Enviar ofertas</li>
        <li>Gestionar tus ofertas</li>
    </ul>

    <a href="supplies.php" class="btn btn-primary">Ver suministros</a>
    <a href="my_offers.php" class="btn btn-success">Mis ofertas</a>
</div>

<?php elseif($rol == 4): ?>

<h2>🧑‍💼 Panel del Cliente</h2>

<div class="mb-3">
    <a href="create_booking.php" class="btn btn-primary">🛎 Nueva reserva</a>
</div>

<h4>📅 Mis Reservas</h4>

<table class="table table-striped">

    <thead>
        <tr>
            <th>Habitación</th>
            <th>Ingreso</th>
            <th>Salida</th>
        </tr>
    </thead>

    <tbody>

    <?php
    $stmt = $conn->prepare("
        SELECT b.*, r.room_number
        FROM bookings b
        JOIN rooms r ON b.room_id = r.id
        WHERE b.user_id = ?
        ORDER BY b.id DESC
    ");
    $stmt->execute([$_SESSION['user']['id']]);
    $reservas = $stmt->fetchAll();
    ?>

    <?php if(count($reservas) == 0): ?>
        <tr>
            <td colspan="3" class="text-center text-muted">
                No tienes reservas
            </td>
        </tr>
    <?php else: ?>

    <?php foreach($reservas as $r): ?>
        <tr>
            <td><?= $r['room_number'] ?></td>
            <td><?= $r['check_in_date'] ?></td>
            <td><?= $r['check_out_date'] ?></td>
        </tr>
    <?php endforeach; ?>

    <?php endif; ?>

    </tbody>

</table>

<?php else: ?>

<h2 class="mb-4">📊 Dashboard</h2>

<div class="row">

    <div class="col-md-3">
        <div class="card p-3 text-white bg-primary shadow">
            <h5>Usuarios</h5>
            <h2><?= $totalUsers ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-white bg-success shadow">
            <h5>Habitaciones</h5>
            <h2><?= $totalRooms ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-white bg-warning shadow">
            <h5>Disponibles</h5>
            <h2><?= $availableRooms ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-white bg-danger shadow">
            <h5>Reservas</h5>
            <h2><?= $totalBookings ?></h2>
        </div>
    </div>

</div>

<h4 class="mt-4">Últimas Reservas</h4>

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
    <?php 
    $recent = $conn->query("
        SELECT b.*, u.name as user, r.room_number
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN rooms r ON b.room_id = r.id
        ORDER BY b.id DESC LIMIT 5
    ")->fetchAll();

    foreach($recent as $r): ?>
        <tr>
            <td><?= $r['user'] ?></td>
            <td><?= $r['room_number'] ?></td>
            <td><?= $r['check_in_date'] ?></td>
            <td><?= $r['check_out_date'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>