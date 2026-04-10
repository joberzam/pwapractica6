<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';

verificarSesion();

$id = $_GET['id'] ?? null;

if(!$id){
    header("Location: rooms.php");
    exit;
}

// obtener habitación
$stmt = $conn->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->execute([$id]);
$room = $stmt->fetch();

if(!$room){
    exit("Habitación no encontrada");
}

// actualizar
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $stmt = $conn->prepare("
        UPDATE rooms 
        SET room_number=?, room_type=?, room_price=? 
        WHERE id=?
    ");

    $stmt->execute([
        $_POST['room_number'],
        $_POST['room_type'],
        $_POST['room_price'],
        $id
    ]);

    header("Location: rooms.php");
    exit;
}

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<h2>✏️ Editar Habitación</h2>

<form method="POST" class="card p-4 shadow" style="max-width:500px;">

    <div class="mb-3">
        <label>Número</label>
        <input name="room_number" class="form-control" value="<?= $room['room_number'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Tipo</label>
        <input name="room_type" class="form-control" value="<?= $room['room_type'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Precio</label>
        <input name="room_price" type="number" step="0.01" class="form-control" value="<?= $room['room_price'] ?>" required>
    </div>

    <button class="btn btn-success w-100">Actualizar</button>

</form>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>