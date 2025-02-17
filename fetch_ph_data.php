<?php
include('Conn.php'); // Database connection

header('Content-Type: application/json');

$query = "SELECT last_saved, ph_level FROM sensor_data ORDER BY last_saved DESC LIMIT 4"; 
$stmt = $connpdo->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
?>