<?php
require 'sql.php';
header('Content-Type: application/json');
$action = $_POST['action'] ?? $_GET['action'] ?? '';
switch ($action) {
    case 'getAll':
        echo json_encode($pdo->query("SELECT * FROM Airport ORDER BY airport_code")->fetchAll());
        break;
    case 'add':
        $s=$pdo->prepare("INSERT INTO Airport (airport_code,airport_name,city,country) VALUES (?,?,?,?)");
        $s->execute([$_POST['airport_code'],$_POST['airport_name'],$_POST['city'],$_POST['country']]);
        echo json_encode(["success"=>true,"message"=>"Airport added successfully."]);
        break;
    case 'update':
        $s=$pdo->prepare("UPDATE Airport SET airport_name=?,city=?,country=? WHERE airport_code=?");
        $s->execute([$_POST['airport_name'],$_POST['city'],$_POST['country'],$_POST['airport_code']]);
        echo json_encode(["success"=>true,"message"=>"Airport updated successfully."]);
        break;
    case 'delete':
        $s=$pdo->prepare("DELETE FROM Airport WHERE airport_code=?");
        $s->execute([$_POST['airport_code']]);
        echo json_encode(["success"=>true,"message"=>"Airport deleted successfully."]);
        break;
    default: echo json_encode(["error"=>"Unknown action."]);
}