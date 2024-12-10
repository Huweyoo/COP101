<?php 
  include('Conn.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/icon/PONDTECH__2_-removebg-preview 2.png">
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Aqua Sense - Forgot Password</title>
</head>
<body>
  <div class="cont">
    <div class="left-por-log">
      <img src="/asset/image 15.png" class="img-left-log">
    </div>
    
    <div class="right-por-log">
      <div class="head-log">
        <img src="/icon/new_logo1-removebg-preview.png" class="head-log-sub">
        <p class="up-head-log-txt">
          Forgot Password
        </p>
        <p class="sub-heading-log">
          Enter your phone number to receive a code.
        </p>
      </div>

      <form method="POST" action="send_otp.php"> <!-- POST to send_otp.php to send OTP -->
        <!-- Step 1: Phone Number Input -->
        <div class="for-pass-aut">
          <div class="forg-log">
            <input type="tel" name="phone_number" id="contact" placeholder="Enter Phone Number" required id="phone-number">
          </div>
        </div>

        <div class="bottom-log">
          <button type="submit" class="btn-log" id="continue-btn">
            Send OTP
          </button>
        </div>
      </form>

      <!-- Step 2: OTP Input (appears after submitting phone number) -->
      <div id="otp-section" style="display:none;">
        <form method="POST" action="verify_otp.php"> <!-- POST to verify_otp.php to verify OTP -->
          <div class="for-pass-aut">
            <div class="forg-log">
              <input type="text" name="otp" placeholder="Enter OTP" required>
            </div>
          </div>

          <div class="bottom-log">
            <button type="submit" class="btn-log">
              Verify OTP
            </button>
          </div>
        </form>
      </div>

      <!-- Step 3: New Password Input (appears after OTP verification) -->
      <div id="new-password-section" style="display:none;">
        <form method="POST" action="reset_password.php"> <!-- POST to reset_password.php for password reset -->
          <div class="for-pass-aut">
            <div class="forg-log">
              <input type="password" name="new_password" placeholder="Enter New Password" required>
            </div>
          </div>

          <div class="bottom-log">
            <button type="submit" class="btn-log">
              Reset Password
            </button>
          </div>
        </form>
      </div>

      <p class="bot-head-log-txt">
        Didn't receive a code? 
        <a href="#">
          <span class="sgn-up-log">Click to Resend</span>
        </a>
      </p>
    </div>
  </div>

  <script>
    const phoneInput = document.getElementById('contact');
    const otpSection = document.getElementById('otp-section');
    const continueBtn = document.getElementById('continue-btn');
    const newPasswordSection = document.getElementById('new-password-section');

    // Show OTP section once OTP is sent
    continueBtn.addEventListener('click', function(event) {
      event.preventDefault();

      const phoneNumber = phoneInput.value.trim();

      if (phoneNumber.length > 0) {
        // Hide phone number input and show OTP input section
        phoneInput.disabled = true;
        otpSection.style.display = 'block';
        continueBtn.style.display = 'none';
      } else {
        alert('Please enter a valid phone number.');
      }
    });

    // Simulate OTP verification (you can integrate actual logic here)
    document.getElementsByName('otp')[0].addEventListener('input', function() {
      const otpInput = document.getElementsByName('otp')[0].value;
      if (otpInput.length >= 4) {  // assuming OTP length is 4
        // Simulate OTP verification success
        newPasswordSection.style.display = 'block'; // Show new password field
      }
    });
  </script>
</body>
</html>
