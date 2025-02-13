<?php 
include('Conn.php');
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
   <style>
    @media (max-width: 768px) {
  .sidebar {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100vh;
    background: #ffffff;
    box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    
  }

  .sidebar.active {
    display: block;
  }

  .menu-btn {
    display: block;
    position: fixed;
    top: 15px;
    left: 15px;
    background: #007bff;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    z-index: 1100;
    border: none;
  }
  .bottom-portion {
    position: absolute;
    bottom: 60px;
    width: 100%;
}

}

@media (min-width: 769px) {
  .menu-btn {
    display: none;
  }
}
</style>
</head>
<body>
  <div class="header">
    <div class="right-portion">
      <img src="/icon/PONDTECH__2_-removebg-preview 2.png" class="head-right">
    </div>
    <div class="left-portion">
      <p class="tme">
        October 26, 2024 - 12:00:06PM
      </p>
      <img src="/icon/image.png" class="head-left">
      <div class="user-name">
        <p class="user-full-name">
          Imee Nold G. Villarde
        </p>
        <p class="user-type">
          User
        </p>
      </div>
    </div>
  </div>
  <button class="menu-btn" onclick="toggleSidebar()">☰ Menu</button>
  <div class="sidebar">
    <div class="upper-portion" style="background-color: #BFEDFE;">
      <a href="user.html">
      <img src="/icon/Vector.png" class="side-wat">
      <p class="drp">
        Water Parameters
      </p>
      </a>
    </div>
    <div class="middle-portion">
      <a href="ph.html">
      <button class="ph">
        <img src="/icon/Group.png" class="ph-icon">
        PH Level
      </button>
      </a>
      <a href="temperature.html">
        <button class="temp">
          <img src="/icon/Vector (1).png" class="temp-icon">
          Temperature
        </button>
      </a>
      <a href="amonia.html">
        <button class="amn">
          <img src="/icon/Vector (2).png" class="amn-icon">
          Amonia
        </button>
      </a>
      <a href="oxygen.html">
        <button class="oxy">
          <img src="/icon/Vector (3).png" class="oxy-icon">
          Oxygen
        </button>
      </a>
      <a href="notification.html">
        <button class="not">
          <img src="/icon/notifications.png" class="not-icon">
          Notification
        </button>
      </a>
    </div>
    <div class="bottom-portion">
      <button class="log-out">
        <img src="/icon/solar_logout-2-broken.png" class="side-log">
        <p class="log">
          Log Out
        </p>
      </button>
    </div>
  </div>

  <div class="content">
    <div class="head-content">
      <p class="heading-cont-alt-heading">
        Water Parameters
      </p>
      <div class="all-portion-parameter-user">
        <div class="ph-level-stability-user">
          <p>
            <img src="/icon/Vector (19).png" style="width:14px;">PH Level Stability
          </p>
          <p>
            123 Level
          </p>
        </div>
        <div class="temp-level-stability-user">
          <p>
          <img src="/icon/Vector (18).png" style="width:8px;">Temperature Stability Level
          </p>
          <p>
            123 Level
          </p>
        </div>
        <div class="amn-level-stability-user">
          <p>
            <img src="/icon/Vector (2).png" style="width:14px;">Amonia Stability Level
          </p>
          <p>
            123 Level
          </p>
        </div>
        <div class="oxy-level-stability-user">
          <p>
          <img src="/icon/Vector (3).png" style="width:14px;">Oxygen Stability Level
          </p>
          <p>
            123 Level
          </p>
        </div>
      </div>
      <p class="heading-cont-alt-heading">
        Readings
      </p>
      <div class="reading-portion-parameter-user">
        <div class="ph-level-reading-user">
          <p>
            Current PH Level
          </p>
          <p style="font-size: 25px; margin-top: 15px; margin-bottom: 15px;">
            123 Level
          </p>
          <p style="color: #E37400;">
            Moderate
          </p>
        </div>
        <div class="temp-level-reading-user">
          <p>
            Current Temperature Level
          </p>
          <p style="font-size: 25px; margin-top: 15px; margin-bottom: 15px;">
            123 Level
          </p>
          <p style="color: #026C37;">
            Stable
          </p>
        </div>
        <div class="amn-level-reading-user">
          <p>
            Current Amonia Level
          </p>
          <p style="font-size: 25px; margin-top: 15px; margin-bottom: 15px;">
            123 Level
          </p>
          <p style="color: #FF0000;">
            Moderate
          </p>
        </div>
        <div class="oxy-level-reading-user">
          <p>
            Current Oxygen Level
          </p>
          <p style="font-size: 25px; margin-top: 15px; margin-bottom: 15px;">
            123 Level
          </p>
          <p style="color: #026C37;">
            Stable
          </p>
        </div>
      </div>
      <div class="breakdown">
        <div class="first-row-break">
          <p>
            Breakdown Data As of <span class="first-head">October 28, 12:00 PM</span>
          </p>
          <button class="ph-report">
            See All Reports
          </button>
        </div>
        <div class="second-row-break">
          <p>
            Date/Time
          </p>
          <p>
            Level
          </p>
          <p>
            AI Simulation
          </p>
          <p>
            Added Elements
          </p>
          <p>
            Measurement
          </p>
        </div>
        <div class="third-row-break">
          <p class="third-lvl-head">
            October 26,2024, 12:00 PM
          </p>
          <p class="third-lvl">
            6.5PH
          </p>
          <p class="third-hel">
            Healthy
          </p>
          <p class="third-elem">
            None
          </p>
          <p class="third-stab">
            Stable
          </p>
        </div>
        <div class="third-row-break">
          <p class="third-lvl-head">
            October 28,2024, 14:00 PM
          </p>
          <p class="third-lvl">
            6.5PH
          </p>
          <p class="third-hel">
            Healthy
          </p>
          <p class="third-elem">
            None
          </p>
          <p class="third-stab">
            Stable
          </p>
        </div>
      </div>
    </div>

    <!--
    <div class="ai">
      <button class="ai-btn">
        <img src="/icon/Group (1).png" class="ai-icon">
      </button>
    </div>
     -->

  </div>
  <script>
  function toggleSidebar() {
    document.querySelector(".sidebar").classList.toggle("active");
  }
   </script>
</body>
</html>