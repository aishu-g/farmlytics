<?php
// Simple rule-based chatbot (no external API needed)

header("Content-Type: application/json");

// Get user message
$data = json_decode(file_get_contents("php://input"), true);
$msg = strtolower(trim($data["message"] ?? ""));

// Default reply
$reply = "Sorry, I don’t know about that. Please ask about crop, soil, fertilizer, or weather.";

// Greetings
if (strpos($msg, "hello") !== false || strpos($msg, "hi") !== false) {
    $reply = "Hello! I’m AgriBot. How can I help you with farming today?";
}

// --- Cereals ---
elseif (strpos($msg, "rice") !== false) {
    $reply = "For rice 🌾, typical recommendation is 80:40:40 NPK per acre. Adjust based on soil test.";
}
elseif (strpos($msg, "wheat") !== false) {
    $reply = "For wheat 🌾, apply around 90:40:40 NPK per acre. Split nitrogen for better uptake.";
}
elseif (strpos($msg, "maize") !== false || strpos($msg, "corn") !== false) {
    $reply = "For maize 🌽, about 100:50:40 NPK per acre is common. Avoid excess nitrogen before rain.";
}
elseif (strpos($msg, "millet") !== false || strpos($msg, "sorghum") !== false || strpos($msg, "jowar") !== false || strpos($msg, "bajra") !== false) {
    $reply = "For millets (sorghum/bajra) 🌱, apply around 40:20:20 NPK per acre. They are hardy and need less nitrogen than cereals.";
}

// --- Pulses & Legumes ---
elseif (strpos($msg, "pigeon pea") !== false || strpos($msg, "tur") !== false || strpos($msg, "arhar") !== false) {
    $reply = "For pigeon pea (tur/arhar) 🌿, apply 12:32:16 NPK per acre. Being a legume, it fixes nitrogen itself.";
}
elseif (strpos($msg, "chickpea") !== false || strpos($msg, "gram") !== false) {
    $reply = "For chickpea (gram) 🌱, apply 20:40:20 NPK per acre. Inoculate seeds with Rhizobium for best results.";
}
elseif (strpos($msg, "soybean") !== false) {
    $reply = "For soybean 🌱, about 20:60:40 NPK per acre is good. Avoid excess nitrogen – soybean fixes its own.";
}
elseif (strpos($msg, "groundnut") !== false || strpos($msg, "peanut") !== false) {
    $reply = "For groundnut 🥜, apply 15:35:35 NPK per acre + gypsum at flowering for better pod filling.";
}

// --- Cash Crops ---
elseif (strpos($msg, "cotton") !== false) {
    $reply = "For cotton 👕🌱, about 60:30:30 NPK per acre is common. Apply nitrogen in 3 split doses.";
}
elseif (strpos($msg, "sugarcane") !== false) {
    $reply = "For sugarcane 🍬, apply 100:50:50 NPK per acre in 3 splits. Add organic manure for best results.";
}
elseif (strpos($msg, "potato") !== false) {
    $reply = "For potato 🥔, about 100:80:80 NPK per acre is recommended. Ensure good irrigation.";
}
elseif (strpos($msg, "tomato") !== false) {
    $reply = "For tomato 🍅, apply 60:40:40 NPK per acre. Add organic manure and micronutrients.";
}
elseif (strpos($msg, "onion") !== false) {
    $reply = "For onion 🧅, apply 40:20:20 NPK per acre + adequate sulphur for bulb development.";
}

// --- Weather / General ---
elseif (strpos($msg, "weather") !== false) {
    $reply = "Please check your local forecast 🌦️. Apply nitrogen just before light rain, not heavy downpours.";
}
elseif (strpos($msg, "fertilizer") !== false) {
    $reply = "Fertilizer guide: Rice 80-40-40, Wheat 90-40-40, Maize 100-50-40, Cotton 60-30-30, Soybean 20-60-40, Groundnut 15-35-35, Sugarcane 100-50-50 (kg/acre). Always confirm with soil test.";
}

echo json_encode(["reply" => $reply]);
?>


