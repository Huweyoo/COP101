<?php 
include('../Conn.php');
if (!isset($_SESSION['USERID'])){
    header("Location: ../Login.php");
  }

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])){

$user_id = $_SESSION['USERID'];
    $input_minph = filter_var($_POST['phminim'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $input_maxph = filter_var($_POST['phmax'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $input_mintemp = filter_var($_POST['tempminim'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $input_maxtemp = filter_var($_POST['tempmax'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $input_minnh3 = filter_var($_POST['nh3minim'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $input_maxnh3 = filter_var($_POST['nh3max'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $input_mino2 = filter_var($_POST['o2minim'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

$statement = $connpdo->prepare("INSERT INTO SAFE_RANGE (USER_ID, PH_MIN, PH_MAX, TEMP_MIN, TEMP_MAX, AMMONIA_MIN,  AMMONIA_MAX, DO_MIN)
VALUES (:userid, :minph, :maxph, :mintemp, :maxtemp, :minnh3, :maxnh3, :mino2)");
$statement->bindParam(':userid', $user_id);
$statement->bindParam(':mino2', $input_mino2);
$statement->bindParam(':minnh3', $input_minnh3);
$statement->bindParam(':maxnh3', $input_maxnh3);
$statement->bindParam(':minph', $input_minph);
$statement->bindParam(':maxph', $input_maxph);
$statement->bindParam(':mintemp', $input_mintemp);
$statement->bindParam(':maxtemp', $input_maxtemp);
$statement->execute();

if($statement->rowCount() > 0){
    $state = $connpdo->prepare("UPDATE USERS SET form_filled = 1 WHERE USERID = :userid");
    $state->bindParam(':userid',$_SESSION['USERID']);
    $state->execute();
    $_SESSION['error_message'] = 'Safe Level are Set!';
    header("Location: ../alt_home.php");

}else{
    $_SESSION['error_message'] = 'Error Failed!';
    header("Location: ../alt_home.php");
}

}

?>