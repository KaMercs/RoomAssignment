<?php
$conn = new mysqli('localhost', 'root', '', 'rooms_db');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a search query is provided
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Base query
$query = "SELECT * FROM rooms";

// Add search condition if applicable
if (!empty($search)) {
    $query .= " WHERE type LIKE '%$search%' OR number LIKE '%$search%'";
}

// Order by latest created_at by default
$query .= " ORDER BY created_at DESC";

$result = $conn->query($query);

$rooms = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

// Return JSON response
echo json_encode($rooms);

// Close the connection
$conn->close();
?>
