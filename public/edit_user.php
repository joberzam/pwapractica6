<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';
require BASE_PATH . '/app/models/User.php';

verificarSesion();

if($_SESSION['user']['role_id'] != 1){
    exit("Acceso denegado");
}

$id = $_GET['id'] ?? null;

if(!$id){
    header("Location: users.php");
    exit;
}

// Obtener usuario
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if(!$user){
    exit("Usuario no encontrado");
}

// Actualizar
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $stmt = $conn->prepare("
        UPDATE users 
        SET name=?, email=?, role_id=? 
        WHERE id=?
    ");

    $stmt->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['role_id'],
        $id
    ]);

    header("Location: users.php");
    exit;
}

$roles = $conn->query("SELECT * FROM roles")->fetchAll();

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<h2>✏️ Editar Usuario</h2>

<form method="POST" class="card p-3">

    <div class="mb-3">
        <label>Nombre</label>
        <input name="name" class="form-control" value="<?= $user['name'] ?>">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input name="email" class="form-control" value="<?= $user['email'] ?>">
    </div>

    <div class="mb-3">
        <label>Rol</label>
        <select name="role_id" class="form-control">
            <?php foreach($roles as $r): ?>
                <option value="<?= $r['id'] ?>" 
                    <?= $r['id']==$user['role_id'] ? 'selected' : '' ?>>
                    <?= $r['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button class="btn btn-success">Actualizar</button>

</form>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>