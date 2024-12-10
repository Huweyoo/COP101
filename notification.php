<?php 
include('navbar.php');
include('Conn.php');

session_start();

if (!isset($_SESSION['USERID'])) {
  header("Location: Login.php");
  exit();
}
$user_id = $_SESSION['USERID'];
$fetch_all = '0';
$fetch_allunread = '0';

try {
  // Prepare the statement
  $statement = $connpdo->prepare("
      SELECT PARAMETERS, READINGS, DATECREATED
      FROM notification
      WHERE USER_ID = :userid AND notif_read IS NULL
      ORDER BY DATECREATED DESC
  ");
  // Bind the parameter
  $statement->bindParam(':userid', $user_id, PDO::PARAM_INT);
  // Execute the query
  $statement->execute();
  // Fetch all unread notifications
  $fetch_notread = $statement->fetchAll(PDO::FETCH_ASSOC);
  // Count unread notifications
  $fetch_allunread = count($fetch_notread);
} catch (PDOException $e) {
  echo "Database error: " . $e->getMessage();
  die();
}

try {
  // Prepare the statement
  $statement1 = $connpdo->prepare("
      SELECT PARAMETERS, READINGS, DATECREATED, notif_read 
      FROM notification 
      WHERE USER_ID = :userid 
      ORDER BY DATECREATED DESC
  ");
  // Bind the parameter
  $statement1->bindParam(':userid', $user_id, PDO::PARAM_INT);
  // Execute the query
  $statement1->execute();
  // Fetch all unread notifications
  $fetch_notifAll = $statement1->fetchAll(PDO::FETCH_ASSOC);
  // Count unread notifications
  $fetch_all = count($fetch_notifAll);
} catch (PDOException $e) {
  echo "Database error: " . $e->getMessage();
  die();
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
  <link rel="stylesheet" href="/chatbot-components/style.css">
  <link rel="icon" href="/icon/PONDTECH__2_-removebg-preview 2.png">
  <title>Aqua Sense</title>
  <style>
    .upper-portion{
      width: 200px;
      margin-left: -26px;
    }
  </style>
</head>
<body>
<div class="sidebar">
    <div class="upper-portion" style="background-color: #BFEDFE;">
      <a href="alt_home.php">
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
        PH Level
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
          Amonia
        </button>
      </a>
      <a href="oxygen.php">
        <button class="oxy">
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
  <div class="notification">
    <div class="head-notif">
      <img src="/icon/Group (2).png" class="notif-head">
      <p class="list-notif-head">
        List of Notifications
      </p>
    </div>
    <div class="sub-notif">
      <div class="left-notif">
        <?php echo $fetch_all ?> Notifications
      </div>
    </div>

    <div class="middle-notif">
      <div class="left-heading-notif">
        <img src="/icon/notifications.png" class="pos-icon">
        <p class="left-heading-num">
          <?php echo $fetch_allunread?>
        </p>
        <p class="left-heading-prim">
          Primary
        </p>
      </div>

      <div class="right-heading-notif">
        <label for="notif_r">Notification:</label>
          <select id="notif_r">
              <option value="NULL" class="">Unread</option>
              <option value=1>Read</option>
          </select>
        <label for="parameter">Parameter:</label>
        <select id="parameter">
            <option value="all">All</option>
            <option value="ph">pH</option>
            <option value="o2">Oxygen (O2)</option>
            <option value="nh3">Ammonia (NH3)</option>
            <option value="temp">Temperature</option>
        </select>
        <label for="timeframe">Timeframe:</label>
        <select id="timeframe">
            <option value="all">All</option>
            <option value="day">Last Day</option>
            <option value="week">Last Week</option>
            <option value="month">Last Month</option>
        </select>
      </div>
    </div>

<div id="notifications-container">
    <!-- Initial notifications will be loaded here -->
</div>
<button id="load-more-btn">Load More</button>



  </div>
  <script>
    let currentPage = 1;

    // Function to load notifications
    function loadNotifications() {
        fetch(`fetch_notification.php?page=${currentPage}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    const container = document.getElementById('notifications-container');
                    data.forEach(notif => {
                        const notifDiv = document.createElement('div');
                        notifDiv.className = `content-notification${notif.notif_read == 1 ? '-white' : ''}`;
                        notifDiv.innerHTML = `
                        
                            <a href="list_of_notification.php?id=${notif.id}" class="color-anchor">
                                <div class="l-content">
                                    <img src="/icon/Vector (7).png" class="notifier-icon">
                                    <p class="notifier-txt">
                                        As of ${new Date(notif.DATECREATED).toLocaleTimeString()}, 
                                        the ${notif.PARAMETERS} level is ${notif.READINGS}.
                                    </p>
                                    <p>Status: ${notif.notif_read == 1 ? 'Read' : 'Unread'}</p>
                                </div>
                                <div class="mid-content">
                                    ${notif.notif_read == null ? '<img src="/icon/Vector (5).png" class="unread-notifier">' : ''}
                                </div>
                                <div class="right-notifier-txt">
                                    <div class="p">
                                        ${new Date(notif.DATECREATED).toLocaleDateString()}
                                    </div>
                                </div>
                            </a>
                        `;
                        container.appendChild(notifDiv);
                    });
                } else {
                    document.getElementById('load-more-btn').disabled = true;
                    document.getElementById('load-more-btn').innerText = 'No more notifications';
                }
            })
            .catch(err => console.error('Error fetching notifications:', err));
    }

    // Initial load
    loadNotifications();

    // Load more notifications on button click
    document.getElementById('load-more-btn').addEventListener('click', () => {
        currentPage++;
        loadNotifications();
    });
</script>
</body>
</html>