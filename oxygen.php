<?php
include('navbar.php');
include('Conn.php');
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

$stmt = $connpdo->prepare("SELECT do_level, last_saved FROM sensor_data ORDER BY last_saved DESC LIMIT 1");
$stmt->execute();
$sensorData = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_GET['action']) && $_GET['action'] === 'fetch_breakdown') {
  try {
      $sql = "SELECT last_saved, do_level FROM sensor_data ORDER BY last_saved DESC LIMIT 3";
      $stmt = $connpdo->query($sql);
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="/icon/PONDTECH__2_-removebg-preview 2.png">
  <title>Aqua Sense</title>
</head>
<body>
  
  <div class="content">
    <div class="head-content">
      <p class="heading-cont">
        Dissolved Oxygen
      </p>

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

      <div class="analytics-admin-portion-ph">
        <div id="line-chart"></div>
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

    function updateBreakdownData() {
        fetch('oxygen.php?action=fetch_breakdown') // Call the same file with the 'fetch_breakdown' action
            .then(response => response.json())
            .then(data => {
                const breakdownContainer = document.getElementById('breakdownRows');

                // Clear existing rows
                breakdownContainer.innerHTML = '';

                // Add new rows
                data.forEach(item => {
                    const row = document.createElement('div');
                    row.classList.add('third-row-break');

                    const date = new Date(item.last_saved);
                    const formattedDate = date.toLocaleString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric',
                        hour12: true,
                    });

            let aiSimulationText;
              if (item.do_level >= 6.5 && item.do_level <= 7.5) {
                aiSimulationText = "Healthy";
              } else {
                aiSimulationText = "Unhealthy";
              }

            row.innerHTML = `
              <p class="third-lvl-head">${formattedDate}</p>
              <p class="third-lvl">${item.do_level.toFixed(1)}Do</p>
              <p class="third-hel">${aiSimulationText}</p>
              <p class="third-elem">None</p>
              <p class="third-stab">--</p>
            `;

            breakdownContainer.appendChild(row);
          });
        })
        .catch(error => console.error('Error fetching breakdown data:', error));
    }

    // Update every 5 seconds
    setInterval(updateBreakdownData, 5000);

    // Initial fetch
    updateBreakdownData();
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.1.0/apexcharts.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="/javascript/do-chart.js"></script>
</body>
</html>