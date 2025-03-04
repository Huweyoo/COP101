<?php 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include('Conn.php');

if (!isset($_SESSION['USERID'])) {
    header("Location: Login.php");
    exit();
} 

$user_id = $_SESSION['USERID'];
$statementuser = $connpdo->prepare("SELECT * FROM USERS WHERE USERID = :userid");
$statementuser->bindParam(':userid', $user_id);
$statementuser->execute();
$user = $statementuser->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="icon/new_logo1-removebg-preview.png">
    <title>Aqua Lense</title>
    <style>
   /* Default styles for sidebar (visible on larger screens) */
.sidebar {
    position: fixed;
    top: 0;
    left: 0; /* Visible by default on larger screens */
    width: 250px;
    height: 100%;
    background: white;
    transition: left 0.3s ease-in-out; /* Smooth transition */
    z-index: 1000;
}

/* Overlay (hidden by default) */
.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

.overlay.active {
    display: block;
}

/* Hamburger menu (hidden on larger screens) */
.hamburger-menu {
    display: none; /* Hidden by default */
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1000;
    background: #02457A;
    border: none;
    padding: 10px;
    cursor: pointer;
}

.hamburger-menu img {
    width: 24px;
    height: 24px;
}

/* Mobile view (max-width: 768px) */
@media (max-width: 768px) {
    .hamburger-menu {
        display: block; /* Show hamburger menu in mobile view */
    }

    .sidebar {
        left: -250px; /* Hide sidebar by default on mobile */
    }

    .sidebar.open {
        left: 0; /* Show sidebar when open */
    }
}
    </style>
</head>
<body>
    <div class="header">
        <div class="right-portion">
            <img src="/icon/new_logo1-removebg-preview.png" class="head-right">
        </div>
        <div class="left-portion">
            <p class="tme" id="currentTime"></p>
            <img src="/icon/Ellipse 337.png" class="head-left">
            <div class="user-name">
                <p class="user-full-name">
                    <?php echo $user['LNAME'] . ', ' . $user['FNAME']; ?>
                </p>
                <p class="user-type">User</p>
            </div>
        </div>
    </div>

    <button class="hamburger-menu" id="hamburger-menu">
        <img src="/icon/hamburjerr.png" alt="Menu" class="menu-icon">
    </button>

    <div class="overlay" id="overlay"></div>
    <div class="sidebar" id="sidebar">
        <div class="upper-portion"> 
            <a href="alt_home.php" class="wat-par">
                <img src="/icon/Vector.png" class="side-wat">
                <p class="drp">Water Parameters</p>
            </a>
        </div>
        <div class="middle-portion">
            <a href="ph.php"><button class="ph"><img src="/icon/Group.png" class="ph-icon"> pH Level</button></a>
            <a href="temperature.php"><button class="temp"><img src="/icon/Vector (1).png" class="temp-icon"> Temperature</button></a>
            <a href="ammonia.php"><button class="amn"><img src="/icon/Vector (2).png" class="amn-icon"> Ammonia</button></a>
            <a href="oxygen.php"><button class="oxy"><img src="/icon/Vector (3).png" class="oxy-icon"> Oxygen</button></a>
            <a href="salinity.php"><button class="oxy"><img src="/icon/saline.png" class="oxy-icon"> Salinity</button></a>
            <a href="notification.php"><button class="not"><img src="/icon/notifications.png" class="not-icon"> Notification</button></a>
        </div>
        <div class="bottom-portion">
            <button class="log-out">
                <img src="/icon/solar_logout-2-broken.png" class="side-log">
                <a href="../backend/unset_session.php"><p class="log">Log Out</p></a>
            </button>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const hamburgerMenu = document.getElementById('hamburger-menu');

    if (!sidebar || !overlay || !hamburgerMenu) {
        console.error("Sidebar, overlay, or hamburger menu not found!");
        return;
    }

    // Function to toggle sidebar
    function toggleSidebar() {
        const isOpen = sidebar.classList.toggle('open');
        overlay.classList.toggle('active', isOpen);

        if (isOpen) {
            sidebar.style.left = "0";
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        } else {
            sidebar.style.left = "-250px";
            document.body.style.overflow = ''; // Allow scrolling
        }
    }

    // Event listeners for mobile view
    hamburgerMenu.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // Reset sidebar on window resize
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            // Reset sidebar to visible state on larger screens
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            sidebar.style.left = "0"; // Ensure sidebar is visible
            document.body.style.overflow = ''; // Allow scrolling
        } else {
            // Ensure sidebar is hidden on smaller screens
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            sidebar.style.left = "-250px"; // Hide sidebar
            document.body.style.overflow = ''; // Allow scrolling
        }
    });
});

    </script>
</body>
</html>