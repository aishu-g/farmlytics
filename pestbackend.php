<?php

if(isset($_FILES["pestImage"])) {

    $target = "uploads/" . basename($_FILES["pestImage"]["name"]);
    move_uploaded_file($_FILES["pestImage"]["tmp_name"], $target);

    $command = "python predict.py " . escapeshellarg($target);
    $output = shell_exec($command);

    echo "Detected: " . trim($output);
}
?>
