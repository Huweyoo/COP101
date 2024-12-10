<?php 
include('Conn.php');

session_start();

// Check if there's an error message in the session
if (isset($_SESSION['error_message'])) {
    echo "<script type='text/javascript'>
            alert('" . $_SESSION['error_message'] . "');
          </script>";
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/icon/PONDTECH__2_-removebg-preview 2.png">
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Aqua Sense</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="cont-signup">

    <div class="left-por-log">
      <img src="/asset/image 15.png" class="img-left-signup-1">
    </div>

    <div class="right-por-log-signup">
      <div class="head-log">
        <img src="/icon/new_logo1-removebg-preview.png" class="head-signup-sub">
        <p class="up-head-log-txt">
          Sign Up
        </p>
        <p class="sub-heading-log">
          Sign Up to have an account
        </p>
      </div>
      <div class="full-name-sign-up">
        
      </div>
      <form action="../backend/register-process.php" method="POST" id="signup-form">

      <div class="sub-log">
        <p class="pas-head-log-txt">
          First Name
        </p>
        <input type="input" placeholder="Enter First Name" name="fname" class="us-log-inp" required>
      </div>

      <div class="sub-log">
        <p class="pas-head-log-txt">
          Last Name
        </p>
        <input type="input" placeholder="Enter Last Name" name="lname" class="us-log-inp" required>
      </div>
      <div class="sub-log">
        <p class="pas-head-log-txt">
          Middle Name
        </p>
        <input type="input" placeholder="Enter Middle Nname" name="mname" class="us-log-inp" >
      </div>

      <div class="sub-log">
        <p class="pas-head-log-txt">
          Username
        </p>
        <input type="input" placeholder="Enter Username" name="username" id="username" class="us-log-inp" required>
      </div>

      <div class="sub-log">
  <p class="pas-head-log-txt">
    Phone Number
  </p>
  <input 
    type="text" 
    placeholder="Enter Phone Number" 
    name="contact" 
    class="us-log-inp" 
    required 
    pattern="^\d{11}$" 
    title="Phone number must be exactly 11 digits.">
</div>

      <div class="sub-log">
        <p class="pas-head-log-txt">
          Email
        </p>
        <input type="email" placeholder="Enter Email" name="email" id="email" class="us-log-inp" required>
      </div>

      <div class="sub-log">
        <p class="pas-head-log-txt">
          Password
        </p>
        <input type="password" placeholder="Enter Password" name="password" id="password" class="us-log-inp" minlength="8" title="Password must be at least 8 characters long." required>
      </div>

      <div class="sub-log">
        <p class="pas-head-log-txt">
          Confirm Password
        </p>
        <input type="password" placeholder="Confirm Password" name="cpassword" id="cpassword" class="us-log-inp" required>
      </div>

      <div class="bottom-log">
        <button class="btn-log" name="submit" type="submit">
          Sign Up
        </button>
        
</form>
        <p class="bot-head-log-txt">
          Already have an account?
          <a href="Login.php">
          <span class="sgn-up-log"> Log In </span>
        </a>
        </p>
      </div>
    </div>
  </div>
  
</body>




</html>