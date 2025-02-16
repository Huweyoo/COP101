<?php
include('Conn.php');
include('navbar.php');
date_default_timezone_set('Asia/Manila');
$current_timestamp = date('Y-m-d H:i:s'); // Include the database connection
session_start();

// Check if user is logged in
if (!isset($_SESSION['USERID'])) {
    header("Location: Login.php");
    exit();
} else {
    // Fetch user details
    $user_id = $_SESSION['USERID'];
    $statement = $connpdo->prepare("SELECT * FROM USERS WHERE USERID = :userid");
    $statement->bindParam(':userid', $user_id);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
}

$stmt = $connpdo->prepare("SELECT ph_level, last_saved FROM sensor_data ORDER BY last_saved DESC LIMIT 1");
$stmt->execute();
$sensorData = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_GET['action']) && $_GET['action'] === 'fetch_breakdown') {
    try {
        $user_id = $_SESSION['USERID']; // Get logged-in user's ID
        
        $sql = "SELECT LAST_SAVED, PH_LEVEL 
                FROM sensor_data 
                WHERE USER_ID = :user_id 
                ORDER BY LAST_SAVED DESC 
                LIMIT 3";
                
        $stmt = $connpdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $breakdownData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($breakdownData);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode([]);
    }
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="/icon/PONDTECH__2_-removebg-preview 2.png">
  <title>Aqua Sense</title>
</head>

<body>
  
  <div class="content">
    <div class="head-content-sensor">
      
      <p class="heading-cont">
        PH Level
      </p>

      <div class="analytics-admin-portion-ph">
        <div id="line-chart"></div>
      </div>

      <p class="text-predict">
        Prediction
      </p>

      <div class="prediction-admin-portion-ph">
        <div id="predict-chart"></div>
      </div>

      <div class="row-header-picker">
        <button class="btn-24h-header">
          24H
        </button>
        <button class="btn-7D-header">
          7D
        </button>
        <button class="btn-1M-header">
          1M
        </button>
        <button class="btn-3M-header">
          3M
        </button>
        <button class="btn-1Y-header">
          1Y
        </button>
      </div>
      
      <div class="breakdown">
    <div class="first-row-break">
      <p>Breakdown Data As of <span class="first-head"><?php echo date('F j, Y'); ?></span></p>
    </div>
    <div class="second-row-break">
      <p>Date/Time</p>
      <p>Level</p>
      <p>AI Simulation</p>
      <p>Measurement</p>
    </div>
    <!-- Dynamic rows will be added here -->
    <div id="breakdownRows"></div>
  </div>
    </div>
  </div>

 
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="./javascript/ph-chart.js"></script>
  <script src="./javascript/predic-ph-chart.js"></script>

</body>
</html>