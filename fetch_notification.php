<?php
include('Conn.php');
session_start();

// Get page and calculate offset
$user = $_SESSION['USERID'];
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 4;
$offset = ($page - 1) * $limit;

try {
    // Fetch notifications with pagination
    $stmt = $connpdo->prepare("
    SELECT * 
    FROM notification 
    WHERE USER_ID = :userid
    ORDER BY DATECREATED DESC 
    LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':userid', $user, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();

    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($notifications);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}