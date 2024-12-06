<?php
include('db_connection.php');

$day = $_GET['day'];
$hours = $_GET['hours']; // Hours to be spent on the booking

// Get all rooms available on the selected day
$sql = "SELECT id, type, number FROM rooms";
$result = $conn->query($sql);

$availableTimes = [];

while ($room = $result->fetch_assoc()) {
    $room_id = $room['id'];
    
    // Get the available time slots for this room
    $scheduleQuery = "SELECT start_time, end_time FROM weekly_schedule WHERE room_id = $room_id AND day = '$day'";
    $scheduleResult = $conn->query($scheduleQuery);

    while ($schedule = $scheduleResult->fetch_assoc()) {
        $start_time = $schedule['start_time'];
        $end_time = $schedule['end_time'];
        
        // Check for time conflicts with existing bookings
        $bookingQuery = "SELECT * FROM room_bookings WHERE room_id = $room_id AND day = '$day' AND start_time <= '$end_time' AND end_time >= '$start_time'";
        $bookingResult = $conn->query($bookingQuery);
        
        if ($bookingResult->num_rows == 0) {
            // Suggest this start time if no conflicts
            $availableTimes[] = ['start_time' => $start_time];
        }
    }
}

echo json_encode($availableTimes);
?>
