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
      <a href="notification.html">
        <button class="not" style="background-color: #BFEDFE;">
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

  <div class="notification">
    <div class="head-notif">
      <img src="/icon/Group (2).png" class="notif-head">
      <p class="list-notif-head">
        List of Notifications
      </p>
    </div>
    <div class="sub-notif">
      <div class="left-notif">
        15 Notifications
      </div>
      <div class="mid-notif">
        <input type="text" class="input-notif" placeholder="Search">
      </div>

      <div class="right-notif">
        <div class="ph-notif">
          <button class="ph-notif-btn">
            <p class="ph-txt-notif">
              PH-Level
            </p>
            <img src="/icon/gridicons_dropdown.png" class="drop-ph-notif">
          </button>
        </div>
        <div class="temp-notif">
            <button class="temp-notif-drop">
              <p class="ph-txt-notif">
                Temperature
              </p>
              <img src="/icon/gridicons_dropdown.png" class="drop-temp-notif">
            </button>
        </div>
        <div class="amn-notif">
          <button class="amn-notif-btn">
            <p class="ph-txt-notif">
              Amonia
            </p>
            <img src="/icon/gridicons_dropdown.png" class="drop-amn-notif">
          </button>
        </div>

        <div class="oxy-notif">
          <button class="oxy-notif-btn">
            <p class="ph-txt-notif">
              Oxygen
            </p>
            <img src="/icon/gridicons_dropdown.png" class="drop-oxy-notif">
          </button>
        </div>
      </div>
    </div>

    <div class="middle-notif">

      <div class="left-heading-notif">
        <img src="/icon/notifications.png" class="pos-icon">
        <p class="left-heading-num">
          15
        </p>
        <p class="left-heading-prim">
          Primary
        </p>
      </div>

      <div class="middle-heading-notif">
        <img src="/icon/notifications.png" class="pos-icon">
        <p class="num-heading">
          5
        </p>
        <p class="num-read">
          Unread
        </p>
      </div>

      <div class="right-heading-notif">
        <button class="mnth-head">
          <p class="ph-txt-notif">
            Month
          </p>
          <img src="/icon/gridicons_dropdown.png" class="drop-amn-notif">
        </button>
        <button class="day-head">
          <p class="ph-txt-notif">
            Day
          </p>
          <img src="/icon/gridicons_dropdown.png" class="drop-amn-notif">
        </button>
        <button class="yr-head">
          <p class="ph-txt-notif">
            Year
          </p>
          <img src="/icon/gridicons_dropdown.png" class="drop-amn-notif">
        </button>
      </div>
    </div>
    <div class="content">
      <div class="left-content">
        <img src="/icon/Vector (7).png" class="">
        <p>
          As of 1:09 PM The PH Level is in Normal Condition.
        </p>
      </div>
      <div class="mid-content">
        <img src="/icon/Vector (5).png" class="">
      </div>
      <div class="right">
        <div class="p">
          Just Now
        </div>
      </div>
    </div>
  </div>
</body>
</html>