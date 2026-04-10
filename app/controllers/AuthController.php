<?php
require BASE_PATH . '/app/models/User.php';

function login($conn) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = findUserByEmail($conn, $email);

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user'] = $user;

            switch ($user['role_id']) {
                case 1:
                    header("Location: " . BASE_URL . "dashboard.php");
                    break;
                case 2:
                    header("Location: " . BASE_URL . "dashboard.php");
                    break;
                case 3:
                    header("Location: " . BASE_URL . "dashboard.php");
                    break;
                case 4:
                    header("Location: " . BASE_URL . "dashboard.php");
                    break;
                case 5:
                    header("Location: " . BASE_URL . "dashboard.php");
                    break;
            }

            exit;
        }

        return "Credenciales incorrectas";
    }

    return null;
}