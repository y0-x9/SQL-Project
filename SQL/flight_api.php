<?php
require 'sql.php';
header('Content-Type: application/json');
$action = $_POST['action'] ?? $_GET['action'] ?? '';
switch ($action) {
    case 'getAll':
        echo json_encode($pdo->query("SELECT * FROM Flight ORDER BY flight_id")->fetchAll());
        break;
    case 'add':
        $s=$pdo->prepare("INSERT INTO Flight (flight_id,flight_no,departure_datetime,arrival_datetime,status,aircraft_id,origin_airport_code,destination_airport_code) VALUES (?,?,?,?,?,?,?,?)");
        $s->execute([$_POST['flight_id'],$_POST['flight_no'],$_POST['departure_datetime'],$_POST['arrival_datetime'],$_POST['status'],$_POST['aircraft_id'],$_POST['origin_airport_code'],$_POST['destination_airport_code']]);
        echo json_encode(["success"=>true,"message"=>"Flight added successfully."]);
        break;
    case 'update':
        $s=$pdo->prepare("UPDATE Flight SET flight_no=?,departure_datetime=?,arrival_datetime=?,status=?,aircraft_id=?,origin_airport_code=?,destination_airport_code=? WHERE flight_id=?");
        $s->execute([$_POST['flight_no'],$_POST['departure_datetime'],$_POST['arrival_datetime'],$_POST['status'],$_POST['aircraft_id'],$_POST['origin_airport_code'],$_POST['destination_airport_code'],$_POST['flight_id']]);
        echo json_encode(["success"=>true,"message"=>"Flight updated successfully."]);
        break;
    case 'delete':
        $s=$pdo->prepare("DELETE FROM Flight WHERE flight_id=?");
        $s->execute([$_POST['flight_id']]);
        echo json_encode(["success"=>true,"message"=>"Flight deleted successfully."]);
        break;
    default: echo json_encode(["error"=>"Unknown action."]);
}
