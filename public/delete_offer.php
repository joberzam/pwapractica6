<?php
session_start();

require __DIR__ . '/../config/bootstrap.php';
require BASE_PATH . '/includes/auth.php';
require BASE_PATH . '/config/db.php';

verificarSesion();
verificarRol([5]);

$id = $_GET['id'] ?? null;

if($id){
    $stmt = $conn->prepare("
        DELETE FROM offers WHERE id=? AND supplier_id=?
    ");
    $stmt->execute([$id, $_SESSION['user']['id']]);
}

header("Location: my_offers.php");
exit;