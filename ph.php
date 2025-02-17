<?php
session_start();
include('Conn.php');
include('navbar.php');
date_default_timezone_set('Asia/Manila');
$current_timestamp = date('Y-m-d H:i:s'); // Include the database connection

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
  <style>
.breakdown-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    border: none; /* Remove table border */
}

.breakdown-table th, .breakdown-table td {
    padding: 8px;
    text-align: center;
    border: none; /* Remove inner borders */
}

.breakdown-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}
.break-table{
  background-color: red;
}
  </style>
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
    <table class="breakdown-table">
    <thead>
        <tr class="break-table">
            <th>Date/Time</th>
            <th>Level</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="breakdownRows">
        <!-- Dynamic rows will be added here -->
    </tbody>
</table>
  </div>
    </div>
  </div>

  <script>
    function updateTime() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        
        // Format time in 12-hour format
        hours = hours % 12;
        hours = hours ? hours : 12; // 0 should be 12
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        var strTime = now.toLocaleString('en-us', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ' - ' + hours + ':' + minutes + ':' + seconds + ' ' + ampm;

        // Set the time in the element with id "currentTime"
        document.getElementById('currentTime').textContent = strTime;
    }

    // Update the time every second
    setInterval(updateTime, 1000);

    function updateBreakdownTimestamp() {
    const timestampElement = document.querySelector('.first-head');
    const now = new Date();

    // Format the current time as "Month Day, Year, Hour:Minute AM/PM"
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour12: true,
    };

    timestampElement.textContent = now.toLocaleString('en-US', options);
}

// Update the timestamp every second
setInterval(updateBreakdownTimestamp, 1000);

function fetchBreakdownData() {
    fetch('fetch_ph_data.php')
        .then(response => response.json())
        .then(data => {
            let breakdownTable = document.getElementById('breakdownRows');
            breakdownTable.innerHTML = ""; // Clear previous rows

            data.forEach(row => {
                let dateTime = new Date(row.last_saved).toLocaleString('en-US', { 
                    month: 'short', day: '2-digit', year: 'numeric', 
                    hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true 
                });

                let newRow = `
                    <tr>
                        <td>${dateTime}</td>
                        <td>${row.ph_level}</td>
                        <td>--</td>  <!-- Placeholder for AI Simulation -->
                    </tr>
                `;

                breakdownTable.innerHTML += newRow;
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Fetch data every 5 minutes (300,000 ms)
setInterval(fetchBreakdownData, 300000);
fetchBreakdownData(); // Initial call
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.1.0/apexcharts.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="/javascript/ph-chart.js"></script>
</body>
</html>