<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rooms_db"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch rooms (type and number)
$sql = "SELECT id, type, number FROM rooms"; // Adjusted based on your columns
$result = $conn->query($sql);

// Initialize an empty array to hold room details
$rooms = [];
if ($result->num_rows > 0) {
    // Fetch rooms and store them in the array
    while ($row = $result->fetch_assoc()) {
        $rooms[] = [
            'id' => $row['id'],
            'type' => $row['type'],
            'number' => $row['number']
        ];
    }
} else {
    echo "No rooms available.";
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Room Booking</h2>
        <form action="submit_booking.php" method="POST">
            <div class="mb-3">
                <label for="roomNumber" class="form-label">Room/Lab</label>
                <select id="roomNumber" name="roomNumber" class="form-select" required>
                    <!-- Dynamically populate dropdown with available rooms -->
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?php echo $room['id']; ?>">
                            <?php echo $room['type'] . " " . $room['number']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="day" class="form-label">Day</label>
                <select id="day" name="day" class="form-select" required>
                    <option value="monday">Monday</option>
                    <option value="tuesday">Tuesday</option>
                    <option value="wednesday">Wednesday</option>
                    <option value="thursday">Thursday</option>
                    <option value="friday">Friday</option>
                    <option value="saturday">Saturday</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="startTime" class="form-label">Start Time</label>
                <input type="time" id="startTime" name="startTime" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="endTime" class="form-label">End Time</label>
                <input type="time" id="endTime" name="endTime" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="course" class="form-label">Course</label>
                <input type="text" id="course" name="course" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="text" id="year" name="year" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="block" class="form-label">Block</label>
                <input type="text" id="block" name="block" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" id="subject" name="subject" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="subjectCode" class="form-label">Subject Code</label>
                <input type="text" id="subjectCode" name="subjectCode" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="proof" class="form-label">Proof</label>
                <input type="text" id="proof" name="proof" class="form-control">
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea id="note" name="note" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label for="totalHours" class="form-label">Total Hours</label>
                <input type="text" id="totalHours" name="totalHours" class="form-control" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Submit Booking</button>
        </form>

        <button class="btn btn-secondary mt-3" data-bs-toggle="modal" data-bs-target="#autoSuggestModal">Suggest Available Room</button>
    </div>

    <div class="modal fade" id="autoSuggestModal" tabindex="-1" aria-labelledby="autoSuggestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="autoSuggestModalLabel">Suggest Available Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="requiredHours" class="form-label">Enter Required Hours</label>
                        <input type="number" id="requiredHours" class="form-control" placeholder="Number of hours" min="1" required>
                    </div>
                    <button class="btn btn-primary" id="suggestRoomBtn">Find Available Room</button>
                    <div id="suggestedRoom" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('suggestRoomBtn').addEventListener('click', suggestRoom);

        function suggestRoom() {
            const requiredHours = parseInt(document.getElementById('requiredHours').value);
            const suggestedRoom = document.getElementById('suggestedRoom');

            if (isNaN(requiredHours) || requiredHours <= 0) {
                suggestedRoom.innerHTML = '<div class="alert alert-danger">Please enter a valid number of hours.</div>';
                return;
            }

            const availableRooms = [
                { room: 'Room 1', maxHours: 8 },
                { room: 'Room 2', maxHours: 6 },
                { room: 'Room 3', maxHours: 10 }
            ];

            const room = availableRooms.find(r => r.maxHours >= requiredHours);

            if (room) {
                suggestedRoom.innerHTML = `
                    <div class="alert alert-success">
                        <strong>Available Room: </strong>${room.room} (Max ${room.maxHours} hours)
                    </div>
                    <button class="btn btn-success" onclick="selectRoom('${room.room}')">Select this Room</button>
                `;
            } else {
                suggestedRoom.innerHTML = '<div class="alert alert-danger">No available room for the required hours.</div>';
            }
        }

        function selectRoom(room) {
            document.getElementById('roomNumber').value = room;
            $('#autoSuggestModal').modal('hide');
        }

        document.getElementById('startTime').addEventListener('input', calculateTotalHours);
        document.getElementById('endTime').addEventListener('input', calculateTotalHours);

        function calculateTotalHours() {
            const startTime = document.getElementById('startTime').value;
            const endTime = document.getElementById('endTime').value;

            if (startTime && endTime) {
                const start = new Date(`1970-01-01T${startTime}:00`);
                const end = new Date(`1970-01-01T${endTime}:00`);
                const diff = (end - start) / (1000 * 60 * 60); // Difference in hours
                document.getElementById('totalHours').value = diff;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
