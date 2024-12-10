<?php
// Import PHPMailer classes at the top of the file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer autoload file

include('Conn.php'); // Include your database connection file
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['verify'])) {
    // Sanitize and retrieve the OTP code entered by the user
    $otp_code = filter_input(INPUT_POST, 'otp_code', FILTER_SANITIZE_STRING);
    
    if (!$otp_code) {
        echo "<script>alert('Invalid OTP input. Please enter a valid OTP.');</script>";
    } else {
        // Step 1: Verify OTP
        if (!isset($_SESSION['otp']) || !isset($_SESSION['email'])) {
            echo "<script>alert('Session expired. Please request a new OTP.');</script>";
        } else {
            $expected_otp = $_SESSION['otp'];
            $email = $_SESSION['email'];

            if ($otp_code == $expected_otp) {
                // OTP matches
                $_SESSION['email'] = $email;
                unset($_SESSION['otp']); // Clear OTP after successful verification
                echo "<script>alert('OTP verified successfully! Redirecting to reset password page.'); window.location.href = 'reset_password.php';</script>";
                exit();
            } else {
                // OTP does not match
                echo "<script>alert('Invalid OTP. Please try again.');</script>";
            }
        }
    }
}

// Resend OTP
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['resend'])) {
    if (!isset($_SESSION['email'])) {
        echo "<script>alert('Session expired. Please go back and enter your email again.');</script>";
    } else {
        $email = $_SESSION['email'];
        $otp = random_int(100000, 999999);
        $_SESSION['otp'] = $otp; // Generate and save a new OTP in the session

        $mail = new PHPMailer(true); // PHPMailer instance
        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '4quas3nse@gmail.com'; 
            $mail->Password = 'ontariqamuplakdu'; // ontariqamuplakdu
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('4quas3nse@gmail.com', 'AquaSense');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Resend OTP - AquaSense';
            $mail->Body    = "<p>Your new OTP code is: <strong>$otp</strong></p>";

            $mail->send();
            echo "<script>alert('A new OTP has been sent to your email address.');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error: Could not resend OTP. {$mail->ErrorInfo}');</script>";
        }
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
  <title>Verify OTP - Aqua Sense</title>
</head>
<body>
  <div class="cont">
    <div class="left-por-log">
      <img src="/asset/image 15.png" class="img-left-log">
    </div>
    
    <div class="right-por-log">
      <div class="head-log">
        <img src="/icon/new_logo1-removebg-preview.png" class="head-log-sub">
        <p class="up-head-log-txt">Verify OTP</p>
        <p class="sub-heading-log">Enter the OTP sent to your registered email address.</p>
      </div>

      <form method="POST"> 
        <br>
      <div class="sub-log">
          <input type="number" name="otp_code" placeholder="Enter OTP" class="us-log-inp" required>
        </div>
        
        <div class="bottom-log">
          <button type="submit" name="verify" class="btn-log">Verify OTP</button>
        </div>
      </form>

      <!-- Resend OTP Section -->
       <div class="bottom-log">
        <form method="POST">
            <button type="submit" name="resend" class="btn-log-1">Resend OTP</button>
          </form>
       </div>
    </div>
  </div>
</body>
</html>