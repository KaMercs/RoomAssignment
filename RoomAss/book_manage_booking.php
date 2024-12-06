<?php
$pdo = new PDO("mysql:host=localhost;dbname=rooms_db", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$action = $_POST['action'];
$bookingId = $_POST['id'];

if ($action === 'delete') {
    $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->execute([$bookingId]);
    echo json_encode(['message' => 'Booking deleted successfully']);
} elseif ($action === 'edit') {
    $data = [
        'id' => $bookingId,
        'room_id' => $_POST['roomType'],
        'day' => $_POST['day'],
        'start_time' => $_POST['startTime'],
        'end_time' => $_POST['endTime'],
        'course' => $_POST['course'],
        'year_level' => $_POST['yearLevel'],
        'block' => $_POST['block'],
        'subject' => $_POST['subject'],
        'professor' => $_POST['professor'],
        'notes' => $_POST['notes']
    ];

    $stmt = $pdo->prepare("UPDATE bookings SET room_id = :room_id, day = :day, start_time = :start_time, end_time = :end_time, 
                           course = :course, year_level = :year_level, block = :block, subject = :subject, 
                           professor = :professor, notes = :notes WHERE id = :id");
    $stmt->execute($data);

    echo json_encode(['message' => 'Booking updated successfully']);
}
?>
