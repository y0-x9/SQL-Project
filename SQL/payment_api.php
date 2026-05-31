<?php
require 'sql.php';
header('Content-Type: application/json');
$action = $_POST['action'] ?? $_GET['action'] ?? '';
switch ($action) {
    case 'getAll':
        echo json_encode($pdo->query("SELECT * FROM Payment ORDER BY payment_id")->fetchAll());
        break;
    case 'add':
        $s=$pdo->prepare("INSERT INTO Payment (payment_id,payment_date,amount,payment_method,payment_status,booking_id) VALUES (?,?,?,?,?,?)");
        $s->execute([$_POST['payment_id'],$_POST['payment_date'],$_POST['amount'],$_POST['payment_method'],$_POST['payment_status'],$_POST['booking_id']]);
        echo json_encode(["success"=>true,"message"=>"Payment added successfully."]);
        break;
    case 'update':
        $s=$pdo->prepare("UPDATE Payment SET payment_date=?,amount=?,payment_method=?,payment_status=?,booking_id=? WHERE payment_id=?");
        $s->execute([$_POST['payment_date'],$_POST['amount'],$_POST['payment_method'],$_POST['payment_status'],$_POST['booking_id'],$_POST['payment_id']]);
        echo json_encode(["success"=>true,"message"=>"Payment updated successfully."]);
        break;
    case 'delete':
        $s=$pdo->prepare("DELETE FROM Payment WHERE payment_id=?");
        $s->execute([$_POST['payment_id']]);
        echo json_encode(["success"=>true,"message"=>"Payment deleted successfully."]);
        break;
    default: echo json_encode(["error"=>"Unknown action."]);
}