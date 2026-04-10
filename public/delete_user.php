<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';
require BASE_PATH . '/app/models/User.php';

verificarSesion();

// SOLO ADMIN
if($_SESSION['user']['role_id'] != 1){
    exit("Acceso denegado");
}

// VALIDAR ID
if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    // evitar que se elimine a sí mismo
    if($id != $_SESSION['user']['id']){
        deleteUser($conn, $id);
    }
}

// redirigir
header("Location: users.php");
exit;