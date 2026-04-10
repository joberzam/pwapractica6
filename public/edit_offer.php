<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';

verificarSesion();
verificarRol([5]);

$id = $_GET['id'] ?? null;

if(!$id){
    header("Location: my_offers.php");
    exit;
}

// obtener oferta
$stmt = $conn->prepare("SELECT * FROM offers WHERE id=? AND supplier_id=?");
$stmt->execute([$id, $_SESSION['user']['id']]);
$offer = $stmt->fetch();

if(!$offer){
    exit("Acceso denegado");
}

// actualizar
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $stmt = $conn->prepare("
        UPDATE offers SET price=? WHERE id=? AND supplier_id=?
    ");

    $stmt->execute([
        $_POST['price'],
        $id,
        $_SESSION['user']['id']
    ]);

    header("Location: my_offers.php");
    exit;
}

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<h2>✏️ Editar Oferta</h2>

<form method="POST" class="card p-3" style="max-width:400px;">

    <div class="mb-3">
        <label>Precio</label>
        <input name="price" type="number" step="0.01" 
               class="form-control" value="<?= $offer['price'] ?>" required>
    </div>

    <button class="btn btn-success">Actualizar</button>

</form>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>