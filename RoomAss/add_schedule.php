<?php
$host = 'localhost';
$dbname = 'rooms_db'; // Replace with your database name
$username = 'root';
$password = ''; // Update with your database password if applicable

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Check if a schedule for the same day already exists
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM weekly_schedule WHERE day = ?");
    $checkStmt->execute([$day]);
    $count = $checkStmt->fetchColumn();

    if ($count > 0) {
        echo json_encode(['message' => "A schedule for $day already exists. Please choose another day."]);
        exit;
    }

    // Insert the new schedule if no conflict exists
    $stmt = $pdo->prepare("INSERT INTO weekly_schedule (day, start_time, end_time) VALUES (?, ?, ?)");
    $stmt->execute([$day, $start_time, $end_time]);

    echo json_encode(['message' => 'Schedule added successfully']);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
