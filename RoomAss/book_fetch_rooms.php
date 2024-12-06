<?php
$pdo = new PDO("mysql:host=localhost;dbname=rooms_db", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = $pdo->query("SELECT id, type, number FROM rooms");
$rooms = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rooms);
?>
