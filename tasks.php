<?php
include 'database_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $name = $conn->real_escape_string($_POST['Name']);
    $description = $conn->real_escape_string($_POST['description']);
    $task_due = $conn->real_escape_string($_POST['task_due']);
    $priority = $conn->real_escape_string($_POST['priority']);
    $status = "Not Completed"; // Default status for new tasks

    $target_file = ""; // Default is empty
    $uploadOk = 1; // Assuming the upload is successful

    // Checking if a file was actually uploaded without errors
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // File is an image - allow upload
            $uploadOk = 1;
        } else {
            echo "The file you uploaded is not an image.";
            $uploadOk = 0;
        }

        // Checking if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        // 2MB max image size
        if ($_FILES["image"]["size"] > 2000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allowing only picture format
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG, PNG files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Trying to move the picture to my target directory
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "Sorry, there was an error uploading your file.";
                $uploadOk = 0;
            }
        }
    }

    // Preparing to insert the task into the database
    $statement = $conn->prepare("INSERT INTO tasks (title, name, description, task_due, priority, Status, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $statement->bind_param("sssssss", $title, $name, $description, $task_due, $priority, $status, $target_file);

    // Execute the statement
    if ($statement->execute()) {
        header('Location: add_tasks.php?status=success');
        exit;
    } else {
        echo "Error: " . $statement->error;
    }

    $statement->close();
    $conn->close();
} else {
    echo "No data submitted.";
}
