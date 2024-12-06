<?php
// submit_booking.php

// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rooms_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$roomNumber = $_POST['roomNumber'];
$day = $_POST['day'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$course = $_POST['course'];
$year = $_POST['year'];
$block = $_POST['block'];
$subject = $_POST['subject'];
$subjectCode = $_POST['subjectCode'];
$proof = $_POST['proof'];
$note = $_POST['note'];
$totalHours = $_POST['totalHours'];

// Insert the booking details into the database
$sql = "INSERT INTO bookings (room_number, day, start_time, end_time, course, year, block, subject, subject_code, proof, note, total_hours) 
        VALUES ('$roomNumber', '$day', '$startTime', '$endTime', '$course', '$year', '$block', '$subject', '$subjectCode', '$proof', '$note', '$totalHours')";

if ($conn->query($sql) === TRUE) {
    echo "Booking successfully submitted!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
