<?php 
include('Conn.php');
date_default_timezone_set('Asia/Manila');
$current_timestamp = date('Y-m-d H:i:s');
session_start();

if (!isset($_SESSION['USERID'])) {
    header("Location: Login.php");
    exit();
} else {
    $user_id = $_SESSION['USERID'];
    $statement = $connpdo->prepare("SELECT * FROM USERS WHERE USERID = :userid");
    $statement->bindParam(':userid', $user_id);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
}

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
  exit(); // Stop further script execution for AJAX requests
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
  <div class="header">
    <div class="right-portion">
      <img src="/icon/PONDTECH__2_-removebg-preview 2.png" class="head-right">
    </div>
    <div class="left-portion">
      <p class="tme" id="currentTime">
        <?php echo date("F j, Y - h:i:s A"); ?>
      </p>
      <img src="/icon/image.png" class="head-left">
      <div class="user-name">
        <p class="user-full-name">
          <?php echo $user['LNAME'] . ', ' . $user['FNAME']; ?>
        </p>
        <p class="user-type">
          User
        </p>
      </div>
    </div>
  </div>
  <div class="sidebar">
    <div class="upper-portion">
      <a href="User_Homepg.php">
      <img src="/icon/Vector.png" class="side-wat">
      <p class="drp">
        Water Parameters
      </p>
      </a>
    </div>
    <div class="middle-portion">
      <a href="ph.php">
      <button class="ph">
        <img src="/icon/Group.png" class="ph-icon">
        pH Level
      </button>
      </a>
      <a href="temperature.php">
      <button class="temp">
        <img src="/icon/Vector (1).png" class="temp-icon">
        Temperature
      </button>
      </a>
      <a href="ammonia.php">
      <button class="amn">
        <img src="/icon/Vector (2).png" class="amn-icon">
        Ammonia
      </button>
      </a>
      <a href="oxygen.php">
        <button class="oxy" style="background-color: #BFEDFE;">
          <img src="/icon/Vector (3).png" class="oxy-icon">
          Oxygen
        </button>
      </a>
      <a href="notification.php">
        <button class="not">
          <img src="/icon/notifications.png" class="not-icon">
          Notification
        </button>
      </a>
    </div>
    <div class="bottom-portion">
      <button class="log-out">
        <img src="/icon/solar_logout-2-broken.png" class="side-log">
        <a href="../backend/unset_session.php">
        <p class="log">
          Log Out
        </p>
        </a>
      </button>
    </div>
  </div>
  <div class="content">
    <div class="head-content">
      <p class="heading-cont">
        Oxygen Level
      </p>

      <div class="analytics">
        <img src="/mockup-pic/Group 1673.png" class="analytics">
      </div>

      <div class="breakdown">
    <div class="first-row-break">
      <p>Breakdown Data As of <span class="first-head"><?php echo date('F j, Y'); ?></span></p>
          <button class="ph-report">
            See All Reports
          </button>
    </div>
    <div class="second-row-break">
      <p>Date/Time</p>
      <p>Level</p>
      <p>AI Simulation</p>
      <p>Added Elements</p>
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
        day: 'numeric',        hour12: true,
    };

    timestampElement.textContent = now.toLocaleString('en-US', options);
}

// Update the timestamp every second
setInterval(updateBreakdownTimestamp, 1000);

    function updateBreakdownData() {
        fetch('?action=fetch_breakdown') // Call the same file with the 'fetch_breakdown' action
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

                    row.innerHTML = `
                        <p class="third-lvl-head">${formattedDate}</p>
                        <p class="third-lvl">${item.do_level.toFixed(1)} mg/L</p>
                        <p class="third-hel">Healthy</p>
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

</body>
</html>