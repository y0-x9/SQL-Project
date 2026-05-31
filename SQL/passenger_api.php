<?php
require 'sql.php';
header('Content-Type: application/json');
$action = $_POST['action'] ?? $_GET['action'] ?? '';
switch ($action) {
    case 'getAll':
        echo json_encode($pdo->query("SELECT * FROM Passenger ORDER BY passenger_id")->fetchAll());
        break;
    case 'add':
        $s=$pdo->prepare("INSERT INTO Passenger (passenger_id,first_name,last_name,gender,date_of_birth,phone,email,passport_no,nationality) VALUES (?,?,?,?,?,?,?,?,?)");
        $s->execute([$_POST['passenger_id'],$_POST['first_name'],$_POST['last_name'],$_POST['gender'],$_POST['date_of_birth'],$_POST['phone'],$_POST['email'],$_POST['passport_no'],$_POST['nationality']]);
        echo json_encode(["success"=>true,"message"=>"Passenger added successfully."]);
        break;
    case 'update':
        $s=$pdo->prepare("UPDATE Passenger SET first_name=?,last_name=?,gender=?,date_of_birth=?,phone=?,email=?,passport_no=?,nationality=? WHERE passenger_id=?");
        $s->execute([$_POST['first_name'],$_POST['last_name'],$_POST['gender'],$_POST['date_of_birth'],$_POST['phone'],$_POST['email'],$_POST['passport_no'],$_POST['nationality'],$_POST['passenger_id']]);
        echo json_encode(["success"=>true,"message"=>"Passenger updated successfully."]);
        break;
    case 'delete':
        $s=$pdo->prepare("DELETE FROM Passenger WHERE passenger_id=?");
        $s->execute([$_POST['passenger_id']]);
        echo json_encode(["success"=>true,"message"=>"Passenger deleted successfully."]);
        break;
    case 'search':
        $s=$pdo->prepare("SELECT * FROM passenger WHERE passenger_id=?");
        $s->execute([$_GET['passenger_id']]);
        $r=$s->fetch();
        echo json_encode($r ?: ["error"=>"No passenger found with that ID."]);
        break;
    default: echo json_encode(["error"=>"Unknown action."]);
}
?>