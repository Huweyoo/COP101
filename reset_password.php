<?php
include('Conn.php'); // Include your database connection

session_start();

// Redirect if user is not authorized
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Unauthorized access. Please verify your OTP first.'); window.location.href = 'verify_otp.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Sanitize and retrieve user inputs
    $new_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!$new_password) {
        echo "<script>alert('Please enter a valid password.');</script>";
    } else {
        // Hash the new password using Bcrypt
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $email = $_SESSION['email']; // Retrieved from session

        try {
            // Update the password in the database
            $stmt = $connpdo->prepare("UPDATE users SET PASSWORD = :password WHERE EMAIL = :email");
            $stmt->execute([
                'password' => $hashed_password,
                'email' => $email,
            ]);

            if ($stmt->rowCount() > 0) {
                echo "<script>alert('Password reset successful! Redirecting to login page.'); window.location.href = 'Login.php';</script>";
            } else {
                echo "<script>alert('Failed to reset password. Please try again.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
        }

        // Clear the session after successful password reset
        session_unset();
        // Destroy the session
        session_destroy();
        header("Location: ../Login.php");
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/icon/PONDTECH__2_-removebg-preview 2.png">
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed&family=Montserrat&family=Roboto&family=Source+Code+Pro&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Send OTP - Aqua Sense</title>
</head>
<body>
  <div class="cont">
    <div class="left-por-log">
      <img src="/asset/image 15.png" class="img-left-log">
    </div>
    
    <div class="right-por-log">
      <div class="head-log">
        <img src="/icon/new_logo1-removebg-preview.png" class="head-log-sub">
        <p class="up-head-log-txt">RESET PASSWORD</p>
        <p class="sub-heading-log">Enter your new password.</p>
      </div>
<br>
      <form method="POST"> 
      <div class="sub-log">
          <input type="text" name="password" placeholder="Enter new password" class="us-log-inp" required>
        </div>
        <div class="bottom-log">
          <button type="submit" name="submit" class="btn-log" id="send-otp-btn">Submit</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>