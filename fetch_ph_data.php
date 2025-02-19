<?php
session_start();
include('Conn.php');

// Ensure the user is logged in
if (!isset($_SESSION['USERID'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['USERID'];

// Fetch the latest pH readings
$query = "SELECT ph_level, last_saved FROM sensor_data ORDER BY last_saved DESC LIMIT 5";
$stmt = $connpdo->prepare($query);
$stmt->execute();
$ph_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch the user's safe pH range
$safe_query = "SELECT PH_MIN, PH_MAX FROM safe_range WHERE USER_ID = :user_id";
$safe_stmt = $connpdo->prepare($safe_query);
$safe_stmt->bindParam(':user_id', $user_id);
$safe_stmt->execute();
$safe_range = $safe_stmt->fetch(PDO::FETCH_ASSOC);

// Combine data and safe range
$response = [
    'ph_data' => $ph_data,
    'safe_range' => $safe_range
];

echo json_encode($response);
?>
