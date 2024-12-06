<?php
$pdo = new PDO("mysql:host=localhost;dbname=rooms_db", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$data = [
    'room_id' => $_POST['roomType'],
    'day' => $_POST['day'],
    'start_time' => $_POST['suggestedTime'],
    'end_time' => date('H:i:s', strtotime($_POST['suggestedTime']) + ($_POST['timeSpent'] * 3600)),
    'course' => $_POST['course'],
    'year_level' => $_POST['yearLevel'],
    'block' => $_POST['block'],
    'subject' => $_POST['subject'],
    'professor' => $_POST['professor'],
    'notes' => $_POST['notes']
];

$stmt = $pdo->prepare("INSERT INTO bookings (room_id, day, start_time, end_time, course, year_level, block, subject, professor, notes) 
                       VALUES (:room_id, :day, :start_time, :end_time, :course, :year_level, :block, :subject, :professor, :notes)");
$stmt->execute($data);

echo json_encode(['message' => 'Booking successfully added']);
?>
