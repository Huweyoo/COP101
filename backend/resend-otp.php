<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$email = $_SESSION['email'];

if (isset($_SESSION['otp'], $_SESSION['otp_expiration'])) {
    if (time() > $_SESSION['otp_expiration']) {
              $_SESSION['error_message'] = 'Your OTP has not expired yet.';
        }
    if (isset($_SESSION['error_message'])) {
        header("Location: ../Signup_Verify.php");
        exit();
    }
    else{
        unset($_SESSION['otp'], $_SESSION['otp_expiration']);

        $otp = rand(100000, 999999);// Generate and send OTP
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiration'] = time() + 300;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '4qu4l3nse@gmail.com';
            $mail->Password = 'uwyvvcqhhvvgpdde';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('4qu4l3nse@gmail.com', 'AQUALENSE');
            $mail->addAddress($email);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "Your OTP code is $otp. It will expire in 5 minutes.";

            $mail->send();
            $_SESSION['error_message'] = 'Your OTP has been Emailed.';
            if (isset($_SESSION['error_message'])) {
                header("Location: ../Signup_Verify.php");
                exit();
            }
            exit();
        } catch (Exception $e) {
            echo "Failed to send OTP. Mailer Error: {$mail->ErrorInfo}";
        }

    }
    }

?>