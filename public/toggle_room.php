<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';

verificarSesion();

if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    $conn->prepare("
        UPDATE rooms 
        SET is_available = NOT is_available 
        WHERE id=?
    ")->execute([$id]);
}

header("Location: rooms.php");
exit;