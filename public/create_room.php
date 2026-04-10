<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';
require BASE_PATH . '/app/models/Room.php';

verificarSesion();

$error = null;

// SOLO CUANDO SE ENVÍA EL FORMULARIO
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // VALIDAR DUPLICADO
    $stmt = $conn->prepare("SELECT COUNT(*) FROM rooms WHERE room_number = ?");
    $stmt->execute([$_POST['room_number']]);

    if($stmt->fetchColumn() > 0){
        $error = "El número de habitación ya existe";
    } else {

        // CREAR HABITACIÓN
        createRoom($conn, $_POST);

        header("Location: rooms.php");
        exit;
    }
}

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<h2>➕ Crear Habitación</h2>

<div class="card p-4 shadow" style="max-width:500px;">

    <?php if($error): ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label>Número</label>
            <input name="room_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tipo</label>
            <input name="room_type" class="form-control" placeholder="Simple, Doble..." required>
        </div>

        <div class="mb-3">
            <label>Precio</label>
            <input name="room_price" type="number" step="0.01" class="form-control" required>
        </div>

        <button class="btn btn-success w-100">Guardar</button>

    </form>

</div>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>