<?php

function verificarSesion() {
    if (!isset($_SESSION['user'])) {
        header("Location: /public/index.php");
        exit;
    }
}

function verificarRol($rolesPermitidos){
    if(!in_array($_SESSION['user']['role_id'], $rolesPermitidos)){
        exit("Acceso denegado");
    }
}