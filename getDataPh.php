<?php
// Include the database connection file
include('Conn.php'); // Replace with the actual path to your connection file

// Check if the time frame is provided
if (isset($_GET['timeFrame'])) {
    $timeFrame = $_GET['timeFrame'];

    // Check if the time frame is 24H
    if ($timeFrame === '24H') {
        // Fetch data for the last 24 hours grouped by hour
        try {
            // Query to get the hourly data for the last 24 hours
            $stmt = $connpdo->prepare("
                SELECT
                    HOUR(last_saved) AS hour,
                    AVG(ph_level) AS ph_level
                FROM sensor_data
                WHERE last_saved >= NOW() - INTERVAL 24 HOUR
                GROUP BY hour
                ORDER BY last_saved ASC  -- Ensure the data is ordered by timestamp
            ");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Prepare data for chart
            $categories = [];
            $phLevels = [];

            foreach ($data as $row) {
                // Ensure the hour is formatted correctly (e.g., "0:00", "1:00", ...)
                $categories[] = str_pad($row['hour'], 2, '0', STR_PAD_LEFT) . ":00";
                $phLevels[] = round($row['ph_level'], 2); // pH level with 2 decimal points
            }

            // Return data as JSON
            echo json_encode([
                'categories' => $categories,
                'phLevels' => $phLevels
            ]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    } 
    // Check if the time frame is 7D
    elseif ($timeFrame === '7D') {
        // Fetch data for the last 7 days, grouped by day
        try {
            // Query to get the daily data for the last 7 days
            $stmt = $connpdo->prepare("
                SELECT
                    DATE(last_saved) AS day,
                    AVG(ph_level) AS ph_level
                FROM sensor_data
                WHERE last_saved >= NOW() - INTERVAL 7 DAY
                GROUP BY day
                ORDER BY last_saved ASC  -- Ensure the data is ordered by timestamp
            ");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Prepare data for chart
            $categories = [];
            $phLevels = [];

            foreach ($data as $row) {
                $categories[] = $row['day']; // Day as a category (e.g., "2024-12-01")
                $phLevels[] = round($row['ph_level'], 2); // pH level with 2 decimal points
            }

            // Return data as JSON
            echo json_encode([
                'categories' => $categories,
                'phLevels' => $phLevels
            ]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid time frame']);
    }
} else {
    echo json_encode(['error' => 'No time frame specified']);
}
?>
