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
                    HOUR(LAST_SAVED) AS hour,
                    AVG(TEMPERATURE) AS temperature
                FROM sensor_data
                WHERE LAST_SAVED >= NOW() - INTERVAL 24 HOUR
                GROUP BY hour
                ORDER BY LAST_SAVED ASC
            ");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Prepare data for chart
            $categories = [];
            $temperatures = [];

            foreach ($data as $row) {
                // Ensure the hour is formatted correctly (e.g., "0:00", "1:00", ...)
                $categories[] = str_pad($row['hour'], 2, '0', STR_PAD_LEFT) . ":00";
                $temperatures[] = round($row['temperature'], 2); // Temperature with 2 decimal points
            }

            // Return data as JSON
            echo json_encode([
                'categories' => $categories,
                'temperatures' => $temperatures
            ]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    } 
    // Check if the time frame is 7D
    elseif ($timeFrame === '7D') {
        // Fetch data for the last 7 days, with daily grouping and averaging
        try {
            // Query to get the daily average for the last 7 days
            $stmt = $connpdo->prepare("
                SELECT
                    DATE(LAST_SAVED) AS day,
                    AVG(TEMPERATURE) AS temperature
                FROM sensor_data
                WHERE LAST_SAVED >= NOW() - INTERVAL 7 DAY
                GROUP BY day
                ORDER BY day ASC
            ");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Prepare data for chart
            $categories = [];
            $temperatures = [];

            foreach ($data as $row) {
                $categories[] = $row['day']; // Day as a category (e.g., "2024-12-01")
                $temperatures[] = round($row['temperature'], 2); // Temperature with 2 decimal points
            }

            // Return data as JSON
            echo json_encode([
                'categories' => $categories,
                'temperatures' => $temperatures
            ]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    } 
    // Check if the time frame is 1M
    elseif ($timeFrame === '1M') {
        // Fetch data for the last 30 days grouped into 4-day intervals
        try {
            $stmt = $connpdo->prepare("
                SELECT
                    CONCAT(DATE_FORMAT(MIN(LAST_SAVED), '%Y-%m-%d'), ' - ', DATE_FORMAT(MAX(LAST_SAVED), '%Y-%m-%d')) AS interval_range,
                    AVG(TEMPERATURE) AS temperature
                FROM (
                    SELECT
                        LAST_SAVED,
                        TEMPERATURE,
                        FLOOR(DATEDIFF(NOW(), LAST_SAVED) / 4) AS interval_group
                    FROM sensor_data
                    WHERE LAST_SAVED >= NOW() - INTERVAL 30 DAY
                ) AS grouped_data
                GROUP BY interval_group
                ORDER BY MIN(LAST_SAVED) ASC
            ");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Prepare data for chart
            $categories = [];
            $temperatures = [];

            foreach ($data as $row) {
                $categories[] = $row['interval_range']; // e.g., "2024-11-08 - 2024-11-11"
                $temperatures[] = round($row['temperature'], 2); // Round temperature to 2 decimal points
            }

            // Return data as JSON
            echo json_encode([
                'categories' => $categories,
                'temperatures' => $temperatures
            ]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    } 

    // Check if the time frame is 3M
    elseif ($timeFrame === '3M') {
        // Fetch data for the last 3 months, grouped into weekly intervals
        try {
            $stmt = $connpdo->prepare("
                SELECT
                    CONCAT(DATE_FORMAT(MIN(LAST_SAVED), '%Y-%m-%d'), ' - ', DATE_FORMAT(MAX(LAST_SAVED), '%Y-%m-%d')) AS interval_range,
                    AVG(TEMPERATURE) AS temperature
                FROM (
                    SELECT
                        LAST_SAVED,
                        TEMPERATURE,
                        FLOOR(DATEDIFF(NOW(), LAST_SAVED) / 7) AS interval_group
                    FROM sensor_data
                    WHERE LAST_SAVED >= NOW() - INTERVAL 3 MONTH
                ) AS grouped_data
                GROUP BY interval_group
                ORDER BY MIN(LAST_SAVED) ASC
            ");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Prepare data for chart
            $categories = [];
            $temperatures = [];

            foreach ($data as $row) {
                $categories[] = $row['interval_range']; // e.g., "2024-11-03 - 2024-11-09"
                $temperatures[] = round($row['temperature'], 2); // Round temperature to 2 decimal points
            }

            // Return data as JSON
            echo json_encode([
                'categories' => $categories,
                'temperatures' => $temperatures
            ]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    }

    // Check if the time frame is 1Y
    elseif ($timeFrame === '1Y') {
        // Fetch data for the last year grouped by month
        try {
            // Query to get the monthly average for the last year
            $stmt = $connpdo->prepare("
                SELECT
                    DATE_FORMAT(LAST_SAVED, '%Y-%m') AS month,
                    AVG(TEMPERATURE) AS temperature
                FROM sensor_data
                WHERE LAST_SAVED >= NOW() - INTERVAL 1 YEAR
                GROUP BY month
                ORDER BY month ASC
            ");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Prepare data for chart
            $categories = [];
            $temperatures = [];

            foreach ($data as $row) {
                $categories[] = $row['month']; // Format: "2024-12"
                $temperatures[] = round($row['temperature'], 2); // Round temperature to 2 decimal points
            }

            // Return data as JSON
            echo json_encode([
                'categories' => $categories,
                'temperatures' => $temperatures
            ]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    }

    else {
        echo json_encode(['error' => 'Invalid time frame']);
    }
} else {
    echo json_encode(['error' => 'No time frame specified']);
}

?>
