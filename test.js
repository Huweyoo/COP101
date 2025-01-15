const axios = require('axios');
const cron = require('node-cron');
const mysql = require('mysql2'); // MySQL client
const nodemailer = require('nodemailer'); // For sending emails
const moment = require('moment-timezone'); // Import moment-timezone
const fs = require('fs'); // File system module to read JSON

// Global variable to store session data
let sessionData = {};
// Variable to keep track of the last inserted timestamp
let lastInsertedTimestamp = null;

// Fetch session data from user_data.json and store it in sessionData
async function fetchSessionData() {
    try {
        // Read the JSON file
        const data = fs.readFileSync('user_data.json', 'utf8');
        // Parse the JSON data
        sessionData = JSON.parse(data);
        console.log('Session Data:', sessionData);
    } catch (error) {
        console.error('Error reading or parsing user_data.json:', error.message);
    }
}
fetchSessionData();

// Set up the MySQL/MariaDB client
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'aqualensedb',
});

connection.connect((err) => {
    if (err) {
        console.error('Error connecting to the database:', err.stack);
        return;
    }
    console.log('Connected to the MySQL database');
});

// Set the ESP32 URL
const esp32Url = 'http://192.168.190.100/sensor_data';

// Set up nodemailer transport
const transporter = nodemailer.createTransport({
    service: 'gmail', // Use your email service provider
    auth: {
        user: '4qu4l3nse@gmail.com', // Replace with your email
        pass: 'uwyvvcqhhvvgpdde', // Replace with your email password or app password
    },
});

// Function to send email
async function sendEmail(subject, message) {
    try {
        await transporter.sendMail({
            from: '"AquaLense Alert" <4qu4l3nse@gmail.com>',
            to: sessionData.email, // Replace with the recipient email
            subject: subject,
            text: message,
        });
        console.log('Notification email sent.');
    } catch (error) {
        console.error('Error sending email:', error.message);
    }
}

// Function to fetch sensor data from ESP32
async function fetchSensorData() {
    try {
        const response = await axios.get(esp32Url);

        // Ensure response data exists
        const data = response.data; // Fix: Assign response data to 'data'

        // Extract sensor values
        const ph = parseFloat(data.ph_level) || '--';
        const temperature = parseFloat(data.temperature) || '--';
        const ammonia = parseFloat(data.ammonia_level) || '--';
        const doLevel = parseFloat(data.do_level) || '--';

        // Get the current timestamp in Manila time (UTC+8)
        const timestamp = moment().tz("Asia/Manila").format("YYYY-MM-DD HH:mm:ss");

        // Check temperature range and send email if out of range
        const minTEMP = parseFloat(sessionData.minTEMP);
        const maxTEMP = parseFloat(sessionData.maxTEMP);
        if (temperature !== '--' && (temperature < minTEMP || temperature > maxTEMP)) {
            const subject = 'AquaSense Temperature Alert';
            const message = `Warning: Water temperature is out of range!\n\nCurrent Temperature: ${temperature}°C\nTimestamp: ${timestamp}`;
            await sendEmail(subject, message);
            // Insert notification into the database
                const notificationQuery = `
                INSERT INTO NOTIFICATION (USER_ID, PARAMETERS, READINGS, DATECREATED)
                VALUES (?, ?, ?, ?)
            `;
            connection.execute(
                notificationQuery, 
                [sessionData.session_id, 'temp', temperature, timestamp], 
                (err, results) => {
                    if (err) {
                        console.error('Error inserting notification into the database:', err.message);
                        return;
                    }
                    console.log('Notification recorded successfully:', results);
                }
            );
        }

        const minPH = parseFloat(sessionData.minPH);
        const maxPH = parseFloat(sessionData.maxPH);
        if (ph !== '--' && (ph < minPH || ph > maxPH)) {
            const subject = 'AquaSense PH Alert';
            const message = `Warning: Water PH is out of range!\n\nCurrent PH: ${ph}\nTimestamp: ${timestamp}`;
            await sendEmail(subject, message);
            // Insert notification into the database
                const notificationQuery = `
                INSERT INTO NOTIFICATION (USER_ID, PARAMETERS, READINGS, DATECREATED)
                VALUES (?, ?, ?, ?)
            `;
            connection.execute(
                notificationQuery, 
                [sessionData.session_id, 'ph', ph, timestamp], 
                (err, results) => {
                    if (err) {
                        console.error('Error inserting notification into the database:', err.message);
                        return;
                    }
                    console.log('Notification recorded successfully:', results);
                }
            );
        }

        const minNH3 = parseFloat(sessionData.minNH3);
        const maxNH3 = parseFloat(sessionData.maxNH3);
        if (ammonia !== '--' && (ammonia < minNH3 || ammonia > maxNH3)) {
            const subject = 'AquaSense Ammonia Alert';
            const message = `Warning: Water Ammonia is out of range!\n\nCurrent Ammonia Level: ${ammonia}\nTimestamp: ${timestamp}`;
            await sendEmail(subject, message);
            // Insert notification into the database
            const notificationQuery = `
            INSERT INTO NOTIFICATION (USER_ID, PARAMETERS, READINGS, DATECREATED)
            VALUES (?, ?, ?, ?)
            `;
            connection.execute(
                notificationQuery, 
                [sessionData.session_id, 'nh3', ammonia, timestamp], 
                (err, results) => {
                    if (err) {
                        console.error('Error inserting notification into the database:', err.message);
                        return;
                    }
                    console.log('Notification recorded successfully:', results);
                }
            );
        }

        const minDO = parseFloat(sessionData.minDO);
        if (doLevel !== '--' && (doLevel < minDO)) {
            const subject = 'AquaSense DO Level Alert';
            const message = `Warning: Water Dissolved Oxygen is out of range!\n\nCurrent DO Level: ${doLevel}\nTimestamp: ${timestamp}`;
            await sendEmail(subject, message);
            // Insert notification into the database
            const notificationQuery = `
            INSERT INTO NOTIFICATION (USER_ID, PARAMETERS, READINGS, DATECREATED)
            VALUES (?, ?, ?, ?)
            `;
            connection.execute(
                notificationQuery, 
                [sessionData.session_id, 'o2', doLevel, timestamp],
                (err, results) => {
                    if (err) {
                        console.error('Error inserting notification into the database:', err.message);
                        return;
                    }
                    console.log('Notification recorded successfully:', results);
                }
            );
        }

        if (response.status === 200) {
            const currentTimestamp = new Date().getTime(); // Current time in milliseconds

            // Check if 5 minutes (300,000 milliseconds) have passed since the last insertion
            if (!lastInsertedTimestamp || currentTimestamp - lastInsertedTimestamp >= 300000) {
                // Get the current time in the Philippine timezone
                const philippineTime = moment().tz('Asia/Manila').format('YYYY-MM-DD HH:mm:ss');

                // Insert data into the database
                const query = `
                    INSERT INTO sensor_data (user_id, ph_level, temperature, ammonia_level, do_level, last_saved)
                    VALUES (?, ?, ?, ?, ?, ?)
                `;
                connection.execute(query, [sessionData.session_id, ph, temperature, ammonia, doLevel, philippineTime], (err, results) => {
                    if (err) {
                        console.error('Error inserting data into the database:', err.message);
                        return;
                    }
                    console.log('Data inserted successfully:', { ph, temperature, ammonia, doLevel, philippineTime });
                    lastInsertedTimestamp = currentTimestamp; // Update the last inserted timestamp
                });
            } 
        } else {
            console.log(`Failed to fetch data: HTTP ${response.status}`);
        }
    } catch (error) {
        console.error('Error fetching data:', error.message);
    }
}

// Schedule the task to run every 30 seconds
cron.schedule('*/30 * * * * *', fetchSensorData);
;

