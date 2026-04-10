<?php
session_start();

// destruir sesión
session_unset();
session_destroy();

// redirigir al login
header("Location: /hotel/public/index.php");
exit;