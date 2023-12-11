<?php
include "header.php";
#Checking if the session is already started or not.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'database_connect.php';

    // Retrieve and sanitize form data
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $title = $conn->real_escape_string($_POST['title']);

    $checkUser = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {

        // Hashing the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement to insert the new user into the database
        $statement = $conn->prepare("INSERT INTO users (username, password, title) VALUES (?, ?, ?)");
        $statement->bind_param("sss", $username, $hashed_password, $title);

        // Executing the statement
        if ($statement->execute()) {
            echo "Registration successful!";
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $statement->error;
        }

        // Closing the statement and connection
        $statement->close();
        $conn->close();
    }
}

?>
<?php include 'footer.php' ?>

<body class="login-body">
    <img src="images/tomato.jpg" alt="Background image" class="background-image3">
    <div class="login-container">
        <h2 class="login-title">User Registration</h2>

        <form action="register.php" method="post" enctype="multipart/form-data" class="login-form">
            <div class="form-group">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required><br>
            </div>
            <div class="form-group">
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br>
            </div>

            <div class="form-group">
                <label for="title">Title:</label><br>
                <select id="title" name="title">
                    <option value="Manager">Manager</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Cook">Cook</option>
                    <option value="Garnisher">Garnisher</option>
                    <option value="Barista">Barista</option>
                </select><br>
            </div>

            <input type="submit" value="Register">
        </form>
        <?php include 'footer.php'; ?>