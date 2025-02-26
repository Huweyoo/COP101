<?php
include('Conn.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');
  $password = htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8');

  try {
      $stmt = $connpdo->prepare("SELECT USERID, PASSWORD FROM USERS WHERE USERNAME = :username");
      $stmt->bindParam(':username', $username);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
          $user = $stmt->fetch(PDO::FETCH_ASSOC);

          if (password_verify($password, $user['PASSWORD'])) {
              $_SESSION['USERID'] = $user['USERID'];

              header("Location: alt_home.php");
              exit;
          } else {
            echo "<script>alert('Invalid Password');</script>";
          }
      } else {
        echo "<script>alert('No user found with this username.');</script>";
      }
  } catch (PDOException $e) {
      error_log("Login error: " . $e->getMessage());
      $error = "An error occurred. Please try again.";
  }
}

if (isset($error)) {
  echo "<p style='color: red;'>$error</p>";
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
<style>
  @media (max-width: 600px) {
    .left-por-log{
      display: none;
    }
    .form{
    }

    .cont{
      background-color: #f5f5f5;
    }

    .right-por-log{
      position: absolute;
      left: -285px;
      top: 30px;
    }

    .bot-head-log-txt{
      display: none;
    }

    .forg-pas-txt{
      margin-left: 115px;
      margin-top: 15px;
      font-size: 12px;
    }

    .btn-log{
      background-color: #1557A4;
      border-radius: 20px;
      width: 200px;
      padding: 10px;
      color: white;
      font-size: 13px;
      margin-top: 15px;
    }

    .head-log-sub{
      width: 350px;
      height: 350px;
      margin-left: 10px;
      position: absolute;
      top: -275px;
      background-image: url('/icon/image144.jpg');
    }

    .up-head-log-txt{
      font-size: 25px;
      font-family: 'Montserrat', sans-serif;
      margin-bottom: 15px;
    }

    .sub-heading-log{
      font-size: 12px;
      font-family: 'Montserrat', sans-serif;
      margin-bottom: 10px;
    }

    .us-head-log-txt{
      font-size: 15px;
      font-family: 'Montserrat', sans-serif;
    }

    .pas-head-log-txt{
      font-size: 15px;
      font-family: 'Montserrat', sans-serif;
    }
  }
</style>
<body style="overflow: hidden; position: fixed ">
  <div class="background-cover">
    <img src="./icon/log-back.png" class="log-back">
  </div> 
  <div class="cont">
    <div class="left-por-log">
      <img src="/icon/log-left-back.png" class="img-left-log">
    </div>
    <form method ="POST" class="form">
    <div class="right-por-log">
      <div class="head-log">
        <p class="up-head-log-txt">
          Welcome!
        </p>
        <p class="sub-heading-log">
          Enter your username and password to continue
        </p>
      </div>
      <div class="sub-log">
        <p class="us-head-log-txt">
          Username
        </p>
        <input type="text" name="username" placeholder="Enter Username" class="us-log-inp" required>
      </div>
      <div class="sub-log">
        <p class="pas-head-log-txt">
          Password
        </p>
        <input type="password" name="password" placeholder="Enter Password" class="us-log-inp" required>
      </div>
      <div class="sub-log">
        <div class="input-log">
          <div class="forg-pas">
            <a href="email_otp.php">
              <p class="forg-pas-txt">
                Forgot Password
              </p>
            </a>
          </div>
        </div>
      </div>
        <a href="/signup.html">
        <button type="submit" class="btn-log">Login</button>
       </a>
      </form>
      </div>
    </div>
  </div>
</body>
</html>