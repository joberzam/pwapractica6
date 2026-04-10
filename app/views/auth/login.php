<?php
session_start();

require __DIR__ . '/../../../config/bootstrap.php';
require BASE_PATH . '/config/db.php';
require BASE_PATH . '/app/controllers/AuthController.php';

$error = null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $error = login($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Hotel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">

    <div class="card shadow p-4" style="width:350px;">

        <h3 class="text-center mb-3">🏨 Hotel</h3>
        <p class="text-center text-muted">Iniciar sesión</p>

        <form method="POST">

            <div class="mb-3">
                <label>Correo</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Ingresar</button>

        </form>

        <?php if($error): ?>
            <div class="alert alert-danger mt-3">
                <?= $error ?>
            </div>
        <?php endif; ?>

    </div>

</div>

</body>
</html>