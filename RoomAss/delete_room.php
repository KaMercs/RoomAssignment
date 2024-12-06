<?php
$conn = new mysqli('localhost', 'root', '', 'rooms_db');

$id = $_GET['id'];

$sql = "DELETE FROM rooms WHERE id = $id";
$conn->query($sql);

$conn->close();
?>
