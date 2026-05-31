<?php
require 'sql.php';
header('Content-Type: application/json');
$action = $_POST['action'] ?? $_GET['action'] ?? '';
switch ($action) {
    case 'getAll':
        echo json_encode($pdo->query("SELECT * FROM CrewMember ORDER BY crew_id")->fetchAll());
        break;
    case 'add':
        $s=$pdo->prepare("INSERT INTO CrewMember (crew_id,first_name,last_name,role,phone,email,license_no,status) VALUES (?,?,?,?,?,?,?,?)");
        $s->execute([$_POST['crew_id'],$_POST['first_name'],$_POST['last_name'],$_POST['role'],$_POST['phone'],$_POST['email'],$_POST['license_no'],$_POST['status']]);
        echo json_encode(["success"=>true,"message"=>"Crew member added successfully."]);
        break;
    case 'update':
        $s=$pdo->prepare("UPDATE CrewMember SET first_name=?,last_name=?,role=?,phone=?,email=?,license_no=?,status=? WHERE crew_id=?");
        $s->execute([$_POST['first_name'],$_POST['last_name'],$_POST['role'],$_POST['phone'],$_POST['email'],$_POST['license_no'],$_POST['status'],$_POST['crew_id']]);
        echo json_encode(["success"=>true,"message"=>"Crew member updated successfully."]);
        break;
    case 'delete':
        $s=$pdo->prepare("DELETE FROM CrewMember WHERE crew_id=?");
        $s->execute([$_POST['crew_id']]);
        echo json_encode(["success"=>true,"message"=>"Crew member deleted successfully."]);
        break;
    default: echo json_encode(["error"=>"Unknown action."]);
}
