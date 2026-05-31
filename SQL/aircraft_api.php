<?php
require 'sql.php';
header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {

    // ── Get all records ─────────────────────────────────────────────
    case 'getAll':
        $stmt = $pdo->query("SELECT * FROM Aircraft ORDER BY aircraft_id");
        echo json_encode($stmt->fetchAll());
        break;

    // ── Add new record ───────────────────────────────────────────────
    case 'add':
        $stmt = $pdo->prepare("INSERT INTO Aircraft
            (aircraft_id, model, manufacturer, capacity, registration_no, status)
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['aircraft_id'],
            $_POST['model'],
            $_POST['manufacturer'],
            $_POST['capacity'],
            $_POST['registration_no'],
            $_POST['status']
        ]);
        echo json_encode(["success" => true, "message" => "Aircraft added successfully."]);
        break;

    // ── Update existing record ───────────────────────────────────────
    case 'update':
        $stmt = $pdo->prepare("UPDATE Aircraft SET
            model=?, manufacturer=?, capacity=?, registration_no=?, status=?
            WHERE aircraft_id=?");
        $stmt->execute([
            $_POST['model'],
            $_POST['manufacturer'],
            $_POST['capacity'],
            $_POST['registration_no'],
            $_POST['status'],
            $_POST['aircraft_id']
        ]);
        echo json_encode(["success" => true, "message" => "Aircraft updated successfully."]);
        break;

    // ── Delete record ────────────────────────────────────────────────
    case 'delete':
        $stmt = $pdo->prepare("DELETE FROM Aircraft WHERE aircraft_id=?");
        $stmt->execute([$_POST['aircraft_id']]);
        echo json_encode(["success" => true, "message" => "Aircraft deleted successfully."]);
        break;

    default:
        echo json_encode(["error" => "Unknown action."]);
}
?>
