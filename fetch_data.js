const axios = require('axios');
const cron = require('node-cron');
const mysql = require('mysql2'); // MySQL client

// Set up the MySQL/MariaDB client
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'aquasensedb',
});

connection.connect((err) => {
    if (err) {
        console.error('Error connecting to the database:', err.stack);
        return;
    }
    console.log('Connected to the MySQL database');
});

// Set the ESP32 URL
const esp32Url = 'http://192.168.5.143/sensor_data';

// Function to fetch sensor data from ESP32
async function fetchSensorData() {
    try {
        const response = await axios.get(esp32Url);

        if (response.status === 200) {
            const data = response.data;

            // Extract sensor values
            const ph = data.ph_level || '--';
            const temperature = data.temperature || '--';
            const ammonia = data.ammonia_level || '--';
            const doLevel = data.do_level || '--';
            const timestamp = new Date().toISOString();

            // Insert data into the database
            const query = `
                INSERT INTO sensor_data (ph_level, temperature, ammonia_level, do_level, last_saved)
                VALUES (?, ?, ?, ?, ?)
            `;
            connection.execute(query, [ph, temperature, ammonia, doLevel, timestamp], (err, results) => {
                if (err) {
                    console.error('Error inserting data into the database:', err.message);
                    return;
                }
                console.log('Data inserted successfully:', { ph, temperature, ammonia, doLevel, timestamp });
            });
        } else {
            console.log(`Failed to fetch data: HTTP ${response.status}`);
        }
    } catch (error) {
        console.error('Error fetching data:', error.message);
    }
}

// Schedule the task to run every 5 minutes
cron.schedule('*/5 * * * * ', fetchSensorData);
