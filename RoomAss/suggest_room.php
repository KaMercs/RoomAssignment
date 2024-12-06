<?php
// suggest_room.php

// Include the database connection
include('db_connection.php');

// Get the data from the AJAX request
$data = json_decode(file_get_contents('php://input'), true);
$day = $data['day'];
$start_time = $data['start_time'];
$end_time = $data['end_time'];

// Query to get available rooms based on the schedule
$query = "SELECT rooms.id, rooms.number 
          FROM rooms 
          WHERE NOT EXISTS (
              SELECT 1 FROM weekly_schedule 
              WHERE weekly_schedule.room_id = rooms.id 
              AND weekly_schedule.day = ? 
              AND (
                  (weekly_schedule.start_time BETWEEN ? AND ?) 
                  OR 
                  (weekly_schedule.end_time BETWEEN ? AND ?)
              )
          )";

// Prepare and execute the query
$stmt = $conn->prepare($query);
$stmt->bind_param('sssss', $day, $start_time, $end_time, $start_time, $end_time);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all available rooms
$rooms = [];
while ($row = $result->fetch_assoc()) {
    $rooms[] = $row;
}

// Return the available rooms as JSON
echo json_encode(['rooms' => $rooms]);

// Close the connection
$stmt->close();
$conn->close();
?>
