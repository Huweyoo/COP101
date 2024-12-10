<?php

include('Conn.php'); // Include database connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['email'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (!$username || !$email) {
        echo "<script>alert('Please provide a valid username and email.');</script>";
    } else {
        // Step 1: Check if the username exists
        $stmt = $connpdo->prepare("SELECT * FROM users WHERE USERNAME = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if (!$user) {
            // If the username is not found in the database
            echo "<script>alert('The username does not exist. Please try again.');</script>";
        } elseif ($user['EMAIL'] !== $email) {
            // Step 2: Check if the email matches the username
            echo "<script>alert('The email address is not registered to the provided username.');</script>";
        } else {
            // Step 3: Generate a 6-digit OTP
            $otp = random_int(100000, 999999);
            $_SESSION['otp'] = $otp; // Store OTP in the session
            $_SESSION['email'] = $email; // Store email for verification later

            // Step 4: Prepare and send the email
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = '4qu4l3nse@gmail.com'; 
                $mail->Password = 'uwyvvcqhhvvgpdde'; // ontariqamuplakdu
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('4qu4l3nse@gmail.com', 'AquaLense'); // Sender details
                $mail->addAddress($email); // Recipient's email

                $mail->isHTML(true);
                $mail->Subject = 'AquaLense - OTP for Password Reset';
                $mail->Body = "<p>Your OTP code is: <strong>$otp</strong></p>";

                $mail->send();
                echo "<script>alert('OTP sent successfully to $email. Redirecting to OTP verification.');</script>";
                header('Location: verify_otp.php');
                exit;
            } catch (Exception $e) {
                echo "<script>alert('Error: Could not send email. {$mail->ErrorInfo}');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/icon/new_logo1-removebg-preview.png">
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed&family=Montserrat&family=Roboto&family=Source+Code+Pro&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Aqua Sense</title>
</head>
<body>
  <div class="cont">
    <div class="left-por-log">
      <img src="/asset/image 15.png" class="img-left-log">
    </div>
    
    <div class="right-por-log">
      <div class="head-log">
        <img src="/icon/new_logo1-removebg-preview.png" class="head-log-sub">
        <p class="up-head-log-txt">Forgot Password</p>
        <p class="sub-heading-log">Enter your username and registered email to receive a code.</p>
      </div>

      <form method="POST"> 
        <div class="sub-log">
          <p class="us-head-log-txt">Username</p>
          <input type="text" name="username" placeholder="Enter Username" class="us-log-inp" required>
        </div>
        <div class="sub-log">
          <p class="pas-head-log-txt">Email</p>
          <input type="email" name="email" placeholder="Enter registered email" class="us-log-inp" required>
        </div>
        <br>
        <div class="bottom-log">
          <button type="submit" name="submit" class="btn-log" id="send-otp-btn">Send OTP</button>
        </div>
      </form>
      <div class="forg-pas">
        <a href="Login.php">
          <p class="forg-pas-txt">Back to login</p>
        </a>
      </div>
    </div>
  </div>
</body>
</html>
