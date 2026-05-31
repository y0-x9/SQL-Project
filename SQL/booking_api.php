<?php
require 'sql.php';
header('Content-Type: application/json');
$action = $_POST['action'] ?? $_GET['action'] ?? '';
switch ($action) {
    case 'getAll':
        echo json_encode($pdo->query("SELECT * FROM Booking ORDER BY booking_id")->fetchAll());
        break;
    case 'add':
        $s=$pdo->prepare("INSERT INTO Booking (booking_id,booking_date,booking_status,total_amount,passenger_id,flight_id,seat_id) VALUES (?,?,?,?,?,?,?)");
        $s->execute([$_POST['booking_id'],$_POST['booking_date'],$_POST['booking_status'],$_POST['total_amount'],$_POST['passenger_id'],$_POST['flight_id'],$_POST['seat_id']]);
        echo json_encode(["success"=>true,"message"=>"Booking added successfully."]);
        break;
    case 'update':
        $s=$pdo->prepare("UPDATE Booking SET booking_date=?,booking_status=?,total_amount=?,passenger_id=?,flight_id=?,seat_id=? WHERE booking_id=?");
        $s->execute([$_POST['booking_date'],$_POST['booking_status'],$_POST['total_amount'],$_POST['passenger_id'],$_POST['flight_id'],$_POST['seat_id'],$_POST['booking_id']]);
        echo json_encode(["success"=>true,"message"=>"Booking updated successfully."]);
        break;
    case 'delete':
        $s=$pdo->prepare("DELETE FROM Booking WHERE booking_id=?");
        $s->execute([$_POST['booking_id']]);
        echo json_encode(["success"=>true,"message"=>"Booking deleted successfully."]);
        break;
    default: echo json_encode(["error"=>"Unknown action."]);
}
