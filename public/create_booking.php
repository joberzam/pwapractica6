<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';
require BASE_PATH . '/app/models/Booking.php';

verificarSesion();
verificarRol([1,2,3,4]);

$error = null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // 🔴 VALIDAR FECHAS
    if($_POST['check_out_date'] <= $_POST['check_in_date']){
        $error = "La fecha de salida debe ser mayor que la de ingreso";
    }

    // 🔴 VALIDAR DOBLE RESERVA
    if(!$error){

        $stmt = $conn->prepare("
            SELECT COUNT(*) FROM bookings
            WHERE room_id = ?
            AND (
                (check_in_date <= ? AND check_out_date > ?)
                OR
                (check_in_date < ? AND check_out_date >= ?)
            )
        ");

        $stmt->execute([
            $_POST['room_id'],
            $_POST['check_in_date'],
            $_POST['check_in_date'],
            $_POST['check_out_date'],
            $_POST['check_out_date']
        ]);

        if($stmt->fetchColumn() > 0){
            $error = "La habitación ya está reservada en esas fechas";
        }
    }

    if($_SESSION['user']['role_id'] == 4){
    $_POST['user_id'] = $_SESSION['user']['id'];
}

    // 🔴 GUARDAR SOLO SI TODO ESTÁ BIEN
    if(!$error){
        createBooking($conn, $_POST);
        header("Location: bookings.php");
        exit;
    }
}

// usuarios
$users = $conn->query("SELECT * FROM users WHERE role_id = 4")->fetchAll();

// habitaciones disponibles
$rooms = $conn->query("SELECT * FROM rooms WHERE is_available = 1")->fetchAll();

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<h2>➕ Nueva Reserva</h2>

<?php if(isset($error)): ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
<?php endif; ?>

<form method="POST" class="card p-3">

    <div class="mb-3">
        <label>Cliente</label>
        <select name="user_id" class="form-control">
            <?php foreach($users as $u): ?>
                <option value="<?= $u['id'] ?>"><?= $u['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Habitación</label>
        <select name="room_id" class="form-control">
            <?php foreach($rooms as $r): ?>
                <option value="<?= $r['id'] ?>">Habitación <?= $r['room_number'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Fecha ingreso</label>
        <input type="date" name="check_in_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Fecha salida</label>
        <input type="date" name="check_out_date" class="form-control" required>
    </div>

    <button class="btn btn-success">Guardar</button>

</form>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>