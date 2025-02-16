<?php
session_start();
include('Conn.php');
include('navbar.php');
// Fetch sensor data from ESP32
$esp32_url = 'http://192.168.5.143/sensor_data'; // Ensure this is the correct IP
$userID = $_SESSION['USERID'];
// Initialize variables with default values

if (isset($_SESSION['error_message'])) {
  echo "<script type='text/javascript'>
          alert('" . $_SESSION['error_message'] . "');
        </script>";
  unset($_SESSION['error_message']);
}

$form_filled = '--';
$ph = '--';
$temperature = '--';
$ammonia = '--';
$do_level = '--';
$PHmin = '--';
$PHmax = '--';
$TEMPmin = '--';
$TEMPmax = '--';
$NH3min = '--';
$NH3max = '--';
$DOmin = '--';

  try {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $esp32_url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Timeout after 5 seconds

        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            throw new Exception('Error fetching data from ESP32: ' . curl_error($ch));
        }

        // Get HTTP status code
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Check if the request was successful (HTTP 200)
        if ($http_code !== 200) {
            throw new Exception("HTTP status code $http_code");
        }

        // Decode the JSON data from ESP32
        $data = json_decode($response, true);

        // Ensure we have valid data before assigning to variables
        if ($data !== null) {
          $ph = isset($data['ph_level']) ? $data['ph_level'] : '--';
          $temperature = isset($data['temperature']) ? $data['temperature'] : '--';
          $ammonia = isset($data['ammonia_level']) ? $data['ammonia_level'] : '--';
          $do_level = isset($data['do_level']) ? $data['do_level'] : '--';
      }

    } catch (Exception $e) {
        // Log the error (optional)
        error_log($e->getMessage());
    }


if (!isset($_SESSION['USERID'])) {
    header("Location: Login.php");
    exit();
} else {
    $user_id = $_SESSION['USERID'];
    $statementuser = $connpdo->prepare("SELECT * FROM USERS WHERE USERID = :userid");
    $statementuser->bindParam(':userid', $user_id);
    $statementuser->execute();
    $user = $statementuser->fetch(PDO::FETCH_ASSOC);

    $statement = $connpdo->prepare("SELECT EMAIL, CONTACT FROM USERS WHERE USERID = :userid ");
    $statement->bindParam(':userid', $_SESSION['USERID']);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    $statement_levels = $connpdo->prepare("SELECT * FROM SAFE_RANGE WHERE USER_ID = :userid ");
    $statement_levels->bindParam(':userid', $_SESSION['USERID']);
    $statement_levels->execute();
    $result_lvl = $statement_levels->fetch(PDO::FETCH_ASSOC);
    if ($statement_levels->rowCount() == 1) {
      $PHmin = $result_lvl['PH_MIN'];
      $PHmax = $result_lvl['PH_MAX'];
      $TEMPmin = $result_lvl['TEMP_MIN'];
      $TEMPmax = $result_lvl['TEMP_MAX'];
      $NH3min = $result_lvl['AMMONIA_MIN'];
      $NH3max = $result_lvl['AMMONIA_MAX'];
      $DOmin = $result_lvl['DO_MIN'];

      // Data to be stored in JSON file
        $sessionData = [
          'session_id' => $_SESSION['USERID'],
          'email' => $result['EMAIL'],
          'contact' => $result['CONTACT'],
          'minPH' => $result_lvl['PH_MIN'],
          'maxPH' => $result_lvl['PH_MAX'],
          'minTEMP' => $result_lvl['TEMP_MIN'],
          'maxTEMP' => $result_lvl['TEMP_MAX'],
          'minNH3' => $result_lvl['AMMONIA_MIN'],
          'maxNH3' => $result_lvl['AMMONIA_MAX'],
          'minDO' => $result_lvl['DO_MIN'],
      ];

      // File path for storing JSON data
      $jsonFile = 'user_data.json';
      
      // Overwrite the content of the file if it already exists, or create the file if it doesn't
      file_put_contents($jsonFile, json_encode($sessionData, JSON_PRETTY_PRINT));
    }

    $stmt = $connpdo->prepare("SELECT form_filled FROM USERS WHERE USERID = :userid");
    $stmt->bindParam(':userid', $user_id);
    $stmt->execute();
    $resultform = $stmt->fetch(PDO::FETCH_ASSOC);
    $form_filled = isset($resultform['form_filled']) && $resultform['form_filled'] == 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/chatbot-components/style.css">
  <script src="/chatbot-components/script.js" defer></script>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="/icon/PONDTECH__2_-removebg-preview 2.png">
  <title>Aqua Lense</title>
  <style>
        /* Basic styling for popup */
        .popup-form {
    display: <?php echo $form_filled ? 'none' : 'block'; ?>;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white !important; /* Ensures solid white background */
    padding: 20px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    z-index: 1001; /* Ensure it is above the overlay */
}
        .overlay {
            display: <?php echo $form_filled ? 'none' : 'block'; ?>;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
              .overlay {
          z-index: 1000; /* Layer beneath the popup */
      }
      .popup-form {
          z-index: 1001; /* Layer above the overlay */
      }
    
    .upper-portion{
      width: 190px;
      margin-left: -9px;
    }
  
    </style>
</head>
<body>

<!-- Form Popup start -->
<div class="overlay"></div>
    <div class="popup-form">
        <h2>Let Start by Setting Your Fish Safe Ranges</h2>
        <form action="../backend/set_water_params.php" method="POST">
            <label for="name">PH Minimum:</label>
            <input type="number" name="phminim" step="0.001" required>
            <br>
            <label for="email">PH Maximum:</label>
            <input type="number" name="phmax" step="0.001" required>
            <br>
            <label for="name">Temperature Minimum:</label>
            <input type="number" name="tempminim" step="0.001" required>
            <br>
            <label for="email">Temperature Maximum:</label>
            <input type="number" name="tempmax" step="0.001" required>
            <br>
            <label for="name">Ammonia Minimum:</label>
            <input type="number" name="nh3minim" step="0.001" required>
            <br>
            <label for="email">Ammonia Maximum:</label>
            <input type="number" name="nh3max" step="0.001" required>
            <br>
            <label for="name">Oxygen Minimum:</label>
            <input type="number" name="o2minim" step="0.001" required>
            <br>
            <button type="submit" name="submit">Set Safe Range</button>
        </form>
    </div> 
  <!-- end of pop-up form -->
  <div class="content">
    <div class="head-content">
      <p class="heading-cont-alt-heading">
        Water Parameters
      </p>
      <div class="all-portion-parameter-user">
        <div class="ph-level-stability-user">
          <p>
            <img src="/icon/Vector (19).png" style="width:14px;">PH Level Stability
          </p>
          <p>
          <?php echo $PHmin; ?> - <?php echo $PHmax; ?> pH
          </p>
        </div>
        <div class="temp-level-stability-user">
          <p>
          <img src="/icon/Vector (18).png" style="width:8px;">Temperature Stability Level
          </p>
          <p>
          <?php echo $TEMPmin; ?> - <?php echo $TEMPmax; ?> °C
          </p>
        </div>
        <div class="amn-level-stability-user">
          <p>
            <img src="/icon/Vector (2).png" style="width:14px;">Amonia Stability Level
          </p>
          <p>
          <?php echo $NH3min; ?> - <?php echo $NH3max; ?> ppm
          </p>
        </div>
        <div class="oxy-level-stability-user">
          <p>
          <img src="/icon/Vector (3).png" style="width:14px;">Oxygen Stability Level
          </p>
          <p>
           minimum of <?php echo $DOmin; ?> mg/L
          </p>
        </div>
        <div class="oxy-level-stability-user">
          <p>
          <img src="/icon/saline.png" style="width:14px;">Salinity Stability Level
          </p>
          <p>
           minimum of <?php echo $DOmin; ?> ppt
          </p>
        </div>
      </div>
      <p class="heading-cont-alt-heading">
        Readings
      </p>
      <div class="reading-portion-parameter-user">
        <div class="ph-level-reading-user">
          <p>
            Current PH Level
          </p>
          <p style="font-size: 25px; margin-top: 15px; margin-bottom: 15px;">
          <span id="phReading" class="reading">
            <?php echo $ph; ?>
          </span>
          </p>
        </div>
        <div class="temp-level-reading-user">
          <p>
            Current Temperature Level
          </p>
          <p style="font-size: 25px; margin-top: 15px; margin-bottom: 15px;">
          <span id="temperatureReading" class="reading">
            <?php echo $temperature; ?> °C
          </span>
          </p>
        </div>
        <div class="amn-level-reading-user">
          <p>
            Current Amonia Level
          </p>
          <p style="font-size: 25px; margin-top: 15px; margin-bottom: 15px;">
          <span id="ammoniaReading" class="reading">
            <?php echo $ammonia; ?> ppm
          </span>
          </p>
        </div>
        <div class="oxy-level-reading-user">
          <p>
            Current Oxygen Level
          </p>
          <p style="font-size: 25px; margin-top: 15px; margin-bottom: 15px;">
          <span id="doReading" class="reading">
            <?php echo $do_level; ?> mg/L
          </span>
          </p>
        </div>
        <div class="oxy-level-reading-user">
          <p>
            Current Salinity Level
          </p>
          <p style="font-size: 25px; margin-top: 15px; margin-bottom: 15px;">
          <span id="salinityReading" class="reading">
            <?php echo $salinity_level; ?> ppt
          </span>
          </p>
        </div>
      </div>
    <div class="ai-analyze">
      <p class="water-qual-header">
        Water Quality <span id="waterQualityResult"></span>
      </p>
      <p class="issue-head">
        Issue:
        <ul id="recommendationsList">
          <!-- Recommendations will be appended here -->
        </ul>
      </p>
      <p>
        Recommendation:
        <ul id="recommendationsList">
          <!-- Recommendations will be appended here -->
        </ul>
      </p>
    </div>

    <div class="ai-prediction">
      <p class="water-qual-header">
        Water Prediction <span id="waterQualityResult"></span>
      </p>
      <p class="issue-head">
        Possibilities:
        <ul id="recommendationsList">
          <!-- Recommendations will be appended here -->
        </ul>
      </p>
      <p>
        Prevention:
        <ul id="recommendationsList">
          <!-- Recommendations will be appended here -->
        </ul>
      </p>
    </div>


      <!-- BUton for executing test.js for automatic insertdata and notification -->

       
       <form method="post">
        <button type="submit" name="startCron">Start Readings Parameters</button>
        <button type="submit" name="stopCron">Stop Readings Parameters</button>
        </form>
        

        <?php
        if (isset($_POST['startCron'])) {
            // Automatically find the COP1 directory relative to the current script
            $cop1_directory = __DIR__;
            // Run the Node.js script with local PM2
            $command = "cd $cop1_directory && node_modules\\.bin\\pm2 start test.js --name 'auto-to-db-aqualense'";
            // Execute the command
            $output = shell_exec($command);
            // Output the result
            echo "<script type='text/javascript'>
                            alert('Automated Reading Started');
                            window.location.href = 'alt_home.php';
                          </script>";
            exit;
        }

        if (isset($_POST['stopCron'])) {
          $cop1_directory = __DIR__;
          // Stop the Node.js script managed by PM2
          $command = "cd $cop1_directory && node_modules\\.bin\\pm2 stop 'auto-to-db-aqualense'"; // Stop by process name
          $output = shell_exec($command);
          echo "<script type='text/javascript'>
                            alert('Automated Reading Stopped');
                            window.location.href = 'alt_home.php';
                          </script>";
          exit;
      }
        ?>
    </div>
  </div>
    <!-- CHATBOT AND AI -->
    <div class="chatbot-toggler">
    <span class="materials-symbols-outlined"><img src="/chatbot-components/Group (6).png" class="icon-chatbot" style="width: 25px;"></span>
    <span class="materials-symbols-outlined" style="display: flex; justify-content: center; align-items: center;"><img src="/chatbot-components/Vector (33).png" class="icon-chatbot" style="width: 20px;"></span>
  </div>

  <!--Chatbot Portion-->

  <div class="chatbot-portion">
    <header>
      <button class="btn-analysis">  
        <img src="/chatbot-components/Vector (34).png" style="width: 20px;">
      </button>
      <h2>
        Chatbot
      </h2>
      <span class="close-btn materials-symbols-outlined"><img src="/chatbot-components/Vector (33).png" class="icon-chatbot" style="width: 20px;"></span>
    </header>
    <ul class="chatbox">
      <li class="chat incoming">
        <span class="materials-symbols-outlined"><img src="/chatbot-components/new_logo-removebg-preview.png" class="icon-chatbot"></span>
        <p>Hi there <br>How can i help you today?</p>
      </li>
    </ul>
    <div class="chat-input">
      <textarea name="" id="" placeholder="Enter a message..." required></textarea>
      <span id="send-btn" class="materials-symbols-outlined"><img src="/chatbot-components/send.png" alt="" style="width: 25px;"></span>
    </div>
  </div>

  <script>
// Function to fetch sensor data from ESP32 and update the page
function fetchSensorData() {
    fetch('http://192.168.5.143/sensor_data')  // Use your ESP32's IP address

    .then(response => response.json())  // Convert the response to JSON
    .then(data => {
        // Update pH level reading
        document.getElementById('phReading').innerHTML = data.ph_level.toFixed(2) + '<br><span>pH</span>';
        
        // Update Ammonia level reading
        document.getElementById('ammoniaReading').innerHTML = data.ammonia_level.toFixed(2) + ' <span>ppm</span>';

        document.getElementById('salinityReading').innerHTML = data.salinity_level.toFixed(2) + ' <span>ppt</span>';
        
        // Update Temperature reading
        document.getElementById('temperatureReading').innerHTML = data.temperature.toFixed(2) + '°C';  // Ensure temperature includes °C

        // Update Dissolved Oxygen reading (if available in the response)
        if (data.do_level) {
            document.getElementById('doReading').innerHTML = data.do_level.toFixed(2) + ' mg/L';
        }
    })
    .catch(error => console.error('Error fetching sensor data:', error));  // Handle any fetch errors
}

// Fetch the data initially on page load
fetchSensorData();

// Update the data every 2 seconds (ensure it only runs once)
setInterval(fetchSensorData, 1000);  // 120000 ms = 2 minutes

document.querySelector('.ai-analyze-btn').addEventListener('click', async () => {
    const temperature = parseFloat(document.getElementById('temperatureReading').innerText) || 0;
    const phLevel = parseFloat(document.getElementById('phReading').innerText) || 0;
    const ammoniaLevel = parseFloat(document.getElementById('ammoniaReading').innerText) || 0;
    const dissolvedOxygen = parseFloat(document.getElementById('doReading').innerText) || 0;

    const data = {
        "Temperature": temperature,
        "pH Level": phLevel,
        "Ammonia Level": ammoniaLevel,
        "Dissolved Oxygen": dissolvedOxygen
    };

    try {
        const response = await fetch('http://127.0.0.1:5001/predict', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
            const { water_quality, recommendations } = result;

            // Update the water quality result
            document.getElementById('waterQualityResult').innerText = water_quality;

            // Update the recommendations
            const recommendationsList = document.getElementById('recommendationsList');
            recommendationsList.innerHTML = ''; // Clear any existing recommendations
            recommendations.forEach(rec => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `<strong>${rec.issue}:</strong> ${rec.recommendation}`;
                recommendationsList.appendChild(listItem);
            });
        } else {
            alert(result.error || 'An error occurred while analyzing water quality.');
        }
    } catch (err) {
        console.error('Error:', err);
        alert('Failed to fetch water quality data.');
    }
});




function updateTime() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        
        // Format time in 12-hour format
        hours = hours % 12;
        hours = hours ? hours : 12; // 0 should be 12
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        var strTime = now.toLocaleString('en-us', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ' - ' + hours + ':' + minutes + ':' + seconds + ' ' + ampm;

        // Set the time in the element with id "currentTime"
        document.getElementById('currentTime').textContent = strTime;
    }

    updateTime();

    // Update the time every second
    setInterval(updateTime, 1000);

</script>
</body>
</html>