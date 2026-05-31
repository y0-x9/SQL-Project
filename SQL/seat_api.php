<?php
require 'sql.php';
header('Content-Type: application/json');
$action = $_POST['action'] ?? $_GET['action'] ?? '';
switch ($action) {
    case 'getAll':
        echo json_encode($pdo->query("SELECT * FROM Seat ORDER BY seat_id")->fetchAll());
        break;
    case 'add':
        $s=$pdo->prepare("INSERT INTO Seat (seat_id,seat_number,class_type,availability_status,aircraft_id) VALUES (?,?,?,?,?)");
        $s->execute([$_POST['seat_id'],$_POST['seat_number'],$_POST['class_type'],$_POST['availability_status'],$_POST['aircraft_id']]);
        echo json_encode(["success"=>true,"message"=>"Seat added successfully."]);
        break;
    case 'update':
        $s=$pdo->prepare("UPDATE Seat SET seat_number=?,class_type=?,availability_status=?,aircraft_id=? WHERE seat_id=?");
        $s->execute([$_POST['seat_number'],$_POST['class_type'],$_POST['availability_status'],$_POST['aircraft_id'],$_POST['seat_id']]);
        echo json_encode(["success"=>true,"message"=>"Seat updated successfully."]);
        break;
    case 'delete':
        $s=$pdo->prepare("DELETE FROM Seat WHERE seat_id=?");
        $s->execute([$_POST['seat_id']]);
        echo json_encode(["success"=>true,"message"=>"Seat deleted successfully."]);
        break;
    default: echo json_encode(["error"=>"Unknown action."]);
}
