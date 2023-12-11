<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Only managers and supervisors can delete tasks
if (!isset($_SESSION['logged_in']) || ($_SESSION['title'] != 'Manager' && $_SESSION['title'] != 'Supervisor')) {
    // Redirect them to the login page or error page
    header('Location: login.php'); //  heading to  login page if not allowed
    exit();
}

include 'database_connect.php';

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    // Prepare and execute the delete statement
    $statement = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $statement->bind_param("i", $id);

    if ($statement->execute()) {
        // Redirect back to view_tasks.php with a success message
        header('Location: view_tasks.php?status=deleted');
        exit;
    } else {
        echo "Error deleting record: " . $statement->error;
    }

    $statement->close();
} else {
    echo "Task ID not specified.";
}

$conn->close();
