<?php

function getBookings($conn){

    // CLIENTE → solo sus reservas
    if($_SESSION['user']['role_id'] == 4){

        $stmt = $conn->prepare("
            SELECT b.*, u.name as user, r.room_number
            FROM bookings b
            JOIN users u ON b.user_id = u.id
            JOIN rooms r ON b.room_id = r.id
            WHERE b.user_id = ?
            ORDER BY b.id DESC
        ");

        $stmt->execute([$_SESSION['user']['id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // OTROS ROLES → todo
    return $conn->query("
        SELECT b.*, u.name as user, r.room_number
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN rooms r ON b.room_id = r.id
        ORDER BY b.id DESC
    ")->fetchAll(PDO::FETCH_ASSOC);
}

function createBooking($conn, $data){

    $stmt = $conn->prepare("
        INSERT INTO bookings (user_id, room_id, booking_date, check_in_date, check_out_date)
        VALUES (?, ?, CURDATE(), ?, ?)
    ");

    return $stmt->execute([
        $data['user_id'],
        $data['room_id'],
        $data['check_in_date'],
        $data['check_out_date']
    ]);
}