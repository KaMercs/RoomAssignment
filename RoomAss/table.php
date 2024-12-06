<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Time Schedule</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: #f2f2f2;
    }
    .form-container {
      margin-bottom: 20px;
    }
    .highlight {
      background-color: lightblue;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Schedule Input</h2>
    <form id="scheduleForm">
      <label for="startTime">Start Time:</label>
      <input type="time" id="startTime" required>
      <label for="endTime">End Time:</label>
      <input type="time" id="endTime" required>
      <label for="day">Day:</label>
      <select id="day" required>
        <option value="Monday">Monday</option>
        <option value="Tuesday">Tuesday</option>
        <option value="Wednesday">Wednesday</option>
        <option value="Thursday">Thursday</option>
        <option value="Friday">Friday</option>
      </select>
      <button type="button" onclick="addSchedule()">Add Schedule</button>
    </form>
  </div>

  <table id="scheduleTable">
    <thead>
      <tr>
        <th>Time</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
      </tr>
    </thead>
    <tbody>
      <!-- Rows with times -->
      <script>
        for (let hour = 0; hour < 24; hour++) {
          const time = hour.toString().padStart(2, '0') + ':00';
          document.write(`<tr><td>${time}</td><td></td><td></td><td></td><td></td><td></td></tr>`);
        }
      </script>
    </tbody>
  </table>

  <script>
    function addSchedule() {
      const startTime = document.getElementById("startTime").value;
      const endTime = document.getElementById("endTime").value;
      const day = document.getElementById("day").value;

      if (!startTime || !endTime || !day) {
        alert("Please fill in all fields.");
        return;
      }

      const table = document.getElementById("scheduleTable");
      const dayIndex = {
        "Monday": 1,
        "Tuesday": 2,
        "Wednesday": 3,
        "Thursday": 4,
        "Friday": 5
      }[day];

      const rows = table.getElementsByTagName("tr");
      for (let i = 1; i < rows.length; i++) {
        const timeCell = rows[i].cells[0].textContent;
        if (timeCell >= startTime && timeCell < endTime) {
          rows[i].cells[dayIndex].classList.add("highlight");
        }
      }
    }
  </script>
</body>
</html>
