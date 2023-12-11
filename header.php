<?php
// Session starting
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lider Restaurant Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header class="site-header">


        <nav>
            <ul class="navigation-menu">
                <li class="nav-item"><a href="view_tasks.php">View Tasks</a></li>
                <?php
                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                    // Displaying logout option if user is logged in
                    echo '<li class="nav-item"><a href="logout.php">Logout</a></li>';
                } else {
                    // Displaying login and register options if user is not logged in
                    echo '<li class="nav-item"><a href="login.php">Login</a></li>';
                    echo '<li class="nav-item"><a href="register.php">Register</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>