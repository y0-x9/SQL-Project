<?php
// Database connection settings
// Change these to match your MySQL setup in phpMyAdmin
$host     = "localhost";
$dbname   = "mysql";   // Change to your actual database name
$username = "root";          // Default XAMPP username
$password = "Rd#0567967826";              // Default XAMPP password is empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die(json_encode(["error" => "Connection failed: " . $e->getMessage()]));
}
?>
