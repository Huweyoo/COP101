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
    <div class="upper-portion">
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
      <button class="temp">
        <img src="/icon/Vector (1).png" class="temp-icon">
        Temperature
      </button>
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
      <div class="end-portion-user" style="background-color: #BFEDFE;">
        <img src="/icon/notifications.png" class="notification-user-user">
          <p class="notif-sidebar-new">
              Notification
          </p>
      </div>
    </div>
    <div class="bottom-portion">
      <a href="login.html">
      <button class="log-out">
        <img src="/icon/solar_logout-2-broken.png" class="side-log">
        <p class="log">
          Log Out
        </p>
      </button>
    </a>
    </div>
  </div>

  <div class="notification">
    <div class="head-notif">
      <img src="/icon/Group (2).png" class="notif-head">
      <p class="list-notif-head">
        List of Notifications
      </p>
    </div>

    <div class="mid-list-of-notif">
      <div class="icon-heading-list-of-notif">
        <img src="/icon/Vector (7).png" class="icon-list-of-notif">
      </div>
      <div class="txt-heading-list-of-notif">
        <p class="danger-list-of-notif">
          Danger Water Amonia Too High
        </p>
        <p class="time-list-of-notif">
          October 20, 2024, 1:08 PM
        </p>
      </div>
    </div>

    <div class="middle-sub-txt-list-of-notif">
      <div class="middle-sub-list-of-notif-a">
        <p>
          <strong>Water Ammonia:</strong> <span></span>0.30mg/L(Too HIGH)
        </p>
        <p class="font-status-list-of-notif">
          <strong>Status: </strong> <span class="font-weight-list-of-notif">Danger</span>
        </p>
      </div>
      <div class="middle-sub-list-of-notif-b">
        <p>
          <strong>Date:</strong>  October 26, 2024
        </p>
        <p class="font-status-list-of-notif-1">
          <strong>Status:</strong>  0.30mg/L(Too HIGH)
        </p>
      </div>
      <div class="middle-sub-list-of-notif-c">
        <p>
          <strong>Time:</strong> 2:20 PM
        </p>
      </div>
    </div>
  
    
    <div class="gen-ai-con">
      <h4>Generated AI Simulation</h4>

      <h5>Water Temperature Needed: 6-14°C</h5>
      <p>Step by step Process</p>

      <p>1. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>78
        
      <p>2. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
  </div>
</body>
</html>