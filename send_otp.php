<?php
include('Conn.php'); // Include your database connection file

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    // Sanitize and retrieve user inputs
    $input_contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_STRING);

    // Step 1: Generate OTP
    $otpResponse = generateOTP($input_contact);

    // Debug: Output the response to check the structure
    echo '<pre>';
    print_r($otpResponse); // This will help you see the full response
    echo '</pre>';

    // Step 2: Check if the response has the success key
    if (isset($otpResponse['success']) && $otpResponse['success'] == true) {
        // Store OTP ID in the session for verification
        $_SESSION['otp_id'] = $otpResponse['otp_id'];
        $_SESSION['contact'] = $input_contact;
        exit(); // You can exit after saving the OTP data, or continue further as needed
    } else {
        die("Failed to send OTP. Please try again.");
    }
}

function generateOTP($contact) {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://d7-verify.p.rapidapi.com/verify/v1/otp/verify-otp",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'originator' => 'SignOTP',
            'recipient' => $contact,
            'content' => 'Your OTP code is: {}',
            'expiry' => '600'
        ]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Token: 8d781b8d26msh126795205ee961cp135e37jsn00f13102d90e",
            "x-rapidapi-host: d7-verify.p.rapidapi.com",
            "x-rapidapi-key: 8d781b8d26msh126795205ee961cp135e37jsn00f13102d90e" // Replace with your actual API key
        ],
    ]);

    // Execute the request and capture the response
    $response = curl_exec($curl);

    // Check for errors in the cURL request
    if ($response === false) {
        die('Error in API request: ' . curl_error($curl));
    }

    curl_close($curl);

    // Return the response as an associative array
    return json_decode($response, true);
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
      <img src="/asset/image 130.png" class="img-left-log">
    </div>
    
    <div class="right-por-log">
      <div class="head-log">
        <img src="/icon/PONDTECH__2_-removebg-preview 2.png" class="head-log-sub">
        <p class="up-head-log-txt">Forgot Password</p>
        <p class="sub-heading-log">Enter your phone number to receive a code.</p>
      </div>

      <form method="POST" action="send_otp.php"> 
        <div class="for-pass-aut">
          <div class="forg-log">
            <input type="tel" name="contact" placeholder="Enter Phone Number" required id="phone-number">
          </div>
        </div>
        
        <div class="bottom-log">
          <button type="submit" name="submit" class="btn-log" id="continue-btn">Send OTP</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>