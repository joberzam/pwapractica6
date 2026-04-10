<?php

function findUserByEmail($conn, $email) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUsers($conn) {
    $stmt = $conn->query("
        SELECT u.*, r.name as role 
        FROM users u
        JOIN roles r ON u.role_id = r.id
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createUser($conn, $data) {

    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        INSERT INTO users (name, email, password, role_id)
        VALUES (?, ?, ?, ?)
    ");

    return $stmt->execute([
        $data['name'],
        $data['email'],
        $password,
        $data['role_id']
    ]);
}

function deleteUser($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$id]);
}