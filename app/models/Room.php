<?php

function getRooms($conn){
    return $conn->query("SELECT * FROM rooms")->fetchAll(PDO::FETCH_ASSOC);
}

function createRoom($conn, $data){

    $stmt = $conn->prepare("
        INSERT INTO rooms (room_number, room_type, room_price, is_available)
        VALUES (?, ?, ?, 1)
    ");

    return $stmt->execute([
        $data['room_number'],
        $data['room_type'],
        $data['room_price']
    ]);
}

function deleteRoom($conn, $id){
    $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
    return $stmt->execute([$id]);
}