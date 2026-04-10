<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';
require BASE_PATH . '/app/models/Room.php';

verificarSesion();

if(isset($_GET['id'])){
    deleteRoom($conn, $_GET['id']);
}

header("Location: rooms.php");
exit;