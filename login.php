<?php
include 'header.php';
#Checking if the session is already started or not.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
#Here we are checking if the request method is post or not.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    #Calling the database connection
    include 'database_connect.php';
    #real_escape_string for security. We are escaping from the special characters to avoid attacks.
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check if the username exists in the database
    $statement = $conn->prepare("SELECT id, username, password, title FROM users WHERE username = ?");
    $statement->bind_param("s", $username);
    $statement->execute();
    $result = $statement->get_result();
    #Here we are checking if the username exist in my database(ps: my database name is: lider_restaurant_manager)
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        //We are here checking if the password mathches to the hashed password in my database
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a new session
            // if password and the username matches loggin will be set to true.
            $_SESSION['logged_in'] = true;
            // Here user id, name and title are stored in the session.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['title'] = $user['title'];

            //According to my project the tasks page that users will see will be different according to their title.
            if ($_SESSION['title'] == 'Manager' || $_SESSION['title'] == 'Supervisor') {
                header("Location: view_tasks.php");
            } else {
                header("Location: tasks_viewer.php");
            }
            exit();
        } else {
            echo "Invalid username or password.";
        }
    }

    $statement->close();
    $conn->close();
}
?>

<body class="login-body">
    <img src="images/egg.jpg" alt="Background image" class="background-image2">
    <div class="login-container">
        <h2 class="login-title">Login</h2>

        <form action="login.php" method="post" class="login-form">
            <div class="form-group">
                <label for="username" class="form-label">Username:</label><br>
                <input type="text" id="username" name="username" required><br>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password:</label><br>
                <input type="password" id="password" name="password" required><br>
            </div>
            <input type="submit" value="Login" class="form-submit">

            <p class="signup-prompt">Don't have an account? <a href="register.php" class="signup-link">Register here</a>.</p>
        </form>
    </div>
</body>
<?php include 'footer.php' ?>