<?php
$host = 'localhost';
$dbname = 'rooms_db'; // Replace with your database name
$username = 'root';
$password = ''; // Update with your database password if applicable

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM weekly_schedule WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['message' => 'Schedule deleted successfully']);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
