from flask import Flask, request, jsonify
from flask_cors import CORS  # Import CORS
import joblib
import pandas as pd

# Create a Flask application instance
app = Flask(__name__)

# Enable CORS for the app
CORS(app)  # Now this should work after the app is created

# Load the pre-trained machine learning model
model = joblib.load('water_quality_model.pkl')  # Make sure 'water_quality_model.pkl' is in the same directory as app.py

# Recommendation function (same as your original function)
def get_recommendation(sensor_data):
    recommendations = []

    # Check individual parameters and add relevant insights/recommendations
    if sensor_data['Ammonia Level'] > 3.0:
        recommendations.append({
            "issue": "High ammonia level detected.",
            "recommendation": "Consider adding biological filters or reducing organic waste input."
        })
    if sensor_data['Dissolved Oxygen'] < 5.0:
        recommendations.append({
            "issue": "Low dissolved oxygen detected.",
            "recommendation": "Install aerators to improve oxygen levels."
        })
    if not (6.5 <= sensor_data['pH Level'] <= 8.5):
        recommendations.append({
            "issue": "pH level is outside the optimal range.",
            "recommendation": "Adjust pH using buffers like sodium carbonate or acidic solutions."
        })
    if sensor_data['Temperature'] < 10 or sensor_data['Temperature'] > 35:
        recommendations.append({
            "issue": "Temperature is outside the optimal range.",
            "recommendation": "Control temperature using cooling or heating systems."
        })

    # If all parameters are within acceptable ranges
    if not recommendations:
        recommendations.append({
            "issue": "All parameters are within acceptable ranges.",
            "recommendation": "Continue monitoring to maintain optimal conditions."
        })

    return recommendations


# Define a route to handle water quality prediction requests
@app.route('/predict', methods=['POST'])
def predict():
    try:
        # Get the data from the POST request (expected to be in JSON format)
        data = request.json
        
        # Convert the incoming data into a pandas DataFrame
        input_data = pd.DataFrame([data], columns=['Temperature', 'pH Level', 'Ammonia Level', 'Dissolved Oxygen'])
        
        # Use the model to make a prediction
        prediction = model.predict(input_data)
        
        # Map the prediction to a human-readable value
        classes = {0: "Poor", 1: "Average", 2: "Good"}
        result = classes[int(prediction[0])]  # Get the water quality class (Poor, Average, or Good)
        
        # Get recommendations based on the sensor readings
        recommendations = get_recommendation(data)

        # Return the prediction and recommendations as JSON
        return jsonify({
            "water_quality": result,
            "recommendations": recommendations
        })
    
    except Exception as e:
        # If there's an error (e.g., invalid input data), return an error message
        return jsonify({"error": str(e)}), 400

# Health check route (optional, just to confirm the backend is working)
@app.route('/', methods=['GET'])
def home():
    return "Fish Pond Simulator Backend is Running!"

# Run the Flask app (the app will listen on localhost:5001 by default)
if __name__ == '__main__':
    app.run(debug=True, port=5001)
