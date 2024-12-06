<?php
$conn = new mysqli('localhost', 'root', '', 'rooms_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$type = $_POST['type'];
$number = $_POST['number'];

// Check for duplicate entries
$sqlCheck = "SELECT * FROM rooms WHERE type = ? AND number = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param('si', $type, $number);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    // Room/Lab with the same type and number already exists
    echo json_encode(['status' => 'error', 'message' => 'Room/Lab already exists']);
} else {
    // Insert the new Room/Lab
    $sqlInsert = "INSERT INTO rooms (type, number) VALUES (?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param('si', $type, $number);
    $stmtInsert->execute();

    echo json_encode(['status' => 'success', 'message' => 'Room/Lab added successfully']);
}

$stmtCheck->close();
$conn->close();
?>
