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

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    createUser($conn, $_POST);
    header("Location: users.php");
    exit;
}

$roles = $conn->query("SELECT * FROM roles")->fetchAll();

include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<h2>➕ Crear Usuario</h2>

<form method="POST" class="card p-3">

    <div class="mb-3">
        <label>Nombre</label>
        <input name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input name="email" type="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Contraseña</label>
        <input name="password" type="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Rol</label>
        <select name="role_id" class="form-control">
            <?php foreach($roles as $r): ?>
                <option value="<?= $r['id'] ?>"><?= $r['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button class="btn btn-success">Guardar</button>

</form>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>