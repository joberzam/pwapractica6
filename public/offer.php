<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';

verificarSesion();
verificarRol([5]); // solo proveedor

$id = $_GET['id'] ?? null;

if(!$id){
    header("Location: supplies.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $stmt = $conn->prepare("
        INSERT INTO offers (supplier_id, supply_id, price)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $_SESSION['user']['id'],
        $id,
        $_POST['price']
    ]);

    header("Location: my_offers.php");
    exit;
}

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<h2>💰 Ofertar</h2>

<div class="card p-4 shadow" style="max-width:400px;">

<form method="POST">

    <div class="mb-3">
        <label>Precio</label>
        <input name="price" type="number" step="0.01" class="form-control" required>
    </div>

    <button class="btn btn-success w-100">Enviar oferta</button>

</form>

</div>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>