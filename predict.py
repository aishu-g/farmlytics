import tensorflow as tf
import numpy as np
from PIL import Image
import sys

IMG_SIZE = (224, 224)

model = tf.keras.models.load_model("plant_model.keras")

class_names = ["Corn_healthy", "Corn_rust", "Potato_early_blight", "Potato_late_blight"]

img_path = sys.argv[1]
img = Image.open(img_path).resize(IMG_SIZE)
img_array = np.array(img) / 255.0
img_array = np.expand_dims(img_array, axis=0)

pred = model.predict(img_array)
index = np.argmax(pred)

print(class_names[index])
