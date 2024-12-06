<?php
// book.php

// Include database connection
include('db_connection.php');

// Function to check if the room is available based on the weekly schedule
function checkRoomAvailability($room_id, $day, $start_time, $end_time, $conn) {
    // Query to check if the room is already booked for the given time slot
    $query = "SELECT * FROM weekly_schedule WHERE room_id = ? AND day = ? AND 
              ((start_time BETWEEN ? AND ?) OR (end_time BETWEEN ? AND ?))";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('issssss', $room_id, $day, $start_time, $end_time, $start_time, $end_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return false; // Room is already booked for this time slot
    }

    return true; // Room is available
}

// Function to insert booking into the database
function insertBooking($data, $conn) {
    // Insert the booking into the database
    $query = "INSERT INTO bookings (room_id, day, start_time, end_time, course, year, block, 
                                    subject, subject_code, proof, note, total_hours)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('issssssssssis',
                     $data['room_id'], $data['day'], $data['start_time'], $data['end_time'],
                     $data['course'], $data['year'], $data['block'], $data['subject'],
                     $data['subject_code'], $data['proof'], $data['note'], $data['total_hours']);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect data from the form
    $room_id = $_POST['room_id'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $block = $_POST['block'];
    $subject = $_POST['subject'];
    $subject_code = $_POST['subject_code'];
    $proof = $_POST['proof'];
    $note = $_POST['note'];
    $total_hours = $_POST['total_hours'];

    // Check if the room is available
    if (checkRoomAvailability($room_id, $day, $start_time, $end_time, $conn)) {
        // Insert booking data into the database
        $booking_data = [
            'room_id' => $room_id,
            'day' => $day,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'course' => $course,
            'year' => $year,
            'block' => $block,
            'subject' => $subject,
            'subject_code' => $subject_code,
            'proof' => $proof,
            'note' => $note,
            'total_hours' => $total_hours
        ];

        if (insertBooking($booking_data, $conn)) {
            echo "Booking successfully added.";
        } else {
            echo "Error: Unable to add booking.";
        }
    } else {
        echo "Error: The room is already booked for this time slot.";
    }
}
?>
