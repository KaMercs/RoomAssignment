<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'rooms_db'; // Replace with your database name
$username = 'root';
$password = ''; // Update with your database password if applicable

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM weekly_schedule");
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($schedules);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
