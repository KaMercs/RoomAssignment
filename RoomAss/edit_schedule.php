<?php
$host = 'localhost';
$dbname = 'rooms_db'; // Replace with your database name
$username = 'root';
$password = ''; // Update with your database password if applicable

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_POST['id'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $stmt = $pdo->prepare("UPDATE weekly_schedule SET day = ?, start_time = ?, end_time = ? WHERE id = ?");
    $stmt->execute([$day, $start_time, $end_time, $id]);

    echo json_encode(['message' => 'Schedule updated successfully']);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
