import serial
from flask import Flask, jsonify
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

ser = serial.Serial('COM14', 9600)

temperature = 0
humidity = 0

@app.route("/sensor")
def get_sensor():
    global temperature, humidity

    line = ser.readline().decode().strip()
    data = line.split(",")

    if len(data) == 2:
        temperature = data[0]
        humidity = data[1]

    return jsonify({
        "temperature": temperature,
        "humidity": humidity
    })

app.run(port=5000)