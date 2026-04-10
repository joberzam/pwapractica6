<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sistema Hotelero</title>

<link href="assets/css/style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold">🏨 Sistema de Gestión Hotelera</h1>
        <p class="text-muted">Plataforma para administración de habitaciones, reservas y proveedores</p>
    </div>

    <div class="row text-center mb-5">

        <div class="col-md-4">
            <h5>Habitaciones</h5>
            <p class="text-muted">Gestión y control de disponibilidad</p>
        </div>

        <div class="col-md-4">
            <h5>Reservas</h5>
            <p class="text-muted">Registro y seguimiento de clientes</p>
        </div>

        <div class="col-md-4">
            <h5>Proveedores</h5>
            <p class="text-muted">Gestión de suministros y ofertas</p>
        </div>

    </div>

    <div class="text-center">
        <a href="../app/views/auth/login.php" class="btn btn-primary btn-lg px-4">
            Iniciar sesión
        </a>
    </div>

    <div class="text-center mt-5">
        <small class="text-muted">
            PROGRAMACIÓN WEB AVANZADA <br>
            CLASE PRACTICA #6 <br>
            Elaborado por Jhonny Bermudez <br>
        </small>
    </div>

</div>

</body>
</html>