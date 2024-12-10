<?php
include('Conn.php');
session_start();
 //Check if there's an error message in the session
if (isset($_SESSION['error_message'])) {
    echo "<script type='text/javascript'>
            alert('" . $_SESSION['error_message'] . "');
          </script>";
    unset($_SESSION['error_message']);
}
if(!isset($_SESSION['fname'], $_SESSION['lname'], $_SESSION['mname'],
    $_SESSION['username'], $_SESSION['password'],  $_SESSION['email'],  $_SESSION['contact'])){
        header("Location: Signup.php");
    }
if (isset($_SESSION['otp'], $_SESSION['otp_expiration'])) {
    if (time() > $_SESSION['otp_expiration']) {
        unset($_SESSION['otp'], $_SESSION['otp_expiration']); // Clear expired OTP
        echo "<script type='text/javascript'>
                    alert('The OTP has expired. Please request a new one.');
            </script>";
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="icon" href="/icon/new_logo1-removebg-preview.png">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed&family=Montserrat&family=Roboto&family=Source+Code+Pro&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">

</head>
<body>
  <div class="cont">
    <div class="left-por-log">
      <img src="/asset/image 15.png" class="img-left-log">
    </div>
    
    <div class="right-por-log">

      <form action="../backend/Signup-verify-process.php" method="POST">
        <div class="header-verification-sign-up">
          <img src="/icon/PONDTECH__2_-removebg-preview 2.png" class="head-log-sub-verif-sgn-up" style="width: 150px;">
          <p style="margin-top: -30px; color: grey; margin-bottom: 20px; font-size: 14px;">
            Sign Up Verify to have an account
          </p>
          <input type="number" id="otp" placeholder="Enter OTP" maxlength="6" name="input_otp" autocomplete="off" required pattern="[0-9]{6}" />
          <button name="submit" type="submit" class="verify-sgn-up" style="margin-top: 10px;"> Verify </button>
        </div>
      </form>

      <form action="../backend/resend-otp.php" medthod="POST">
        <div class="sgn-up-verify-resend-section">
          <p style="font-size: 13px;">Did not Receive Code? Click Resend for New OTP</p>
          <button name="resend" type="submit" class="resend-sgn-up" style="margin-top: 10px;"> Resend </button>
        </div>
      </form>

    </div>
  </div>
</body>


</html>