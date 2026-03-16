import os
from PIL import Image
import tensorflow as tf
from tensorflow.keras import layers

DATA_DIR = "dataset" # adjust to your dataset path
IMG_SIZE = (224,224)
BATCH = 32
EPOCHS = 10

DATA_DIR = "dataset"

# Remove corrupted images
for root, dirs, files in os.walk(DATA_DIR):
    for file in files:
        path = os.path.join(root, file)
        try:
            img = Image.open(path)
            img.verify()
        except:
            print("Removing corrupted image:", path)
            os.remove(path)


train_ds = tf.keras.preprocessing.image_dataset_from_directory(
    DATA_DIR, validation_split=0.2, subset="training", seed=123,
    image_size=IMG_SIZE, batch_size=BATCH
)
val_ds = tf.keras.preprocessing.image_dataset_from_directory(
    DATA_DIR, validation_split=0.2, subset="validation", seed=123,
    image_size=IMG_SIZE, batch_size=BATCH
)

AUTOTUNE = tf.data.AUTOTUNE
class_names = train_ds.class_names
train_ds = train_ds.prefetch(AUTOTUNE)
val_ds = val_ds.prefetch(AUTOTUNE)

base = tf.keras.applications.MobileNetV2(input_shape=IMG_SIZE+(3,), include_top=False, weights='imagenet')
base.trainable = False

inputs = tf.keras.Input(shape=IMG_SIZE+(3,))
x = tf.keras.applications.mobilenet_v2.preprocess_input(inputs)
x = base(x, training=False)
x = layers.GlobalAveragePooling2D()(x)
outputs = layers.Dense(len(class_names), activation="softmax")(x)
model = tf.keras.Model(inputs, outputs)

model.compile(optimizer="adam", loss="sparse_categorical_crossentropy", metrics=["accuracy"])
model.fit(train_ds, validation_data=val_ds, epochs=EPOCHS)

model.save("plant_model.keras")

print(class_names)
  # keep this order for LABELS later
