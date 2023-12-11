<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirecting users who are not logged in or who do not have the appropriate role
if (!isset($_SESSION['logged_in']) || ($_SESSION['title'] != 'Manager' && $_SESSION['title'] != 'Supervisor')) {
    header('Location: login.php');
    exit();
}

include 'header.php';

// Check if the task was added successfully
if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
    <p>Task added successfully!</p>
<?php endif; ?>

<body class="login-body">
    <div class="login-container">
        <h2>Add Task</h2>

        <form action="tasks.php" method="post" enctype="multipart/form-data">
            <label for="title">Title:</label><br />
            <input type="text" id="title" name="title" required /><br />

            <label for="Name">Name:</label><br />
            <input type="text" id="Name" name="Name" required /><br />

            <label for="description">Task description:</label><br />
            <textarea id="description" name="description" required></textarea><br />

            <label for="imageUpload">Upload Image:</label>
            <input type="file" name="image" id="imageUpload"><br />

            <label for="task_due">Due Date:</label><br />
            <input type="date" id="task_due" name="task_due" required /><br />

            <label for="priority">Priority:</label><br />
            <select id="priority" name="priority">
                <option value="Low">Low</option>
                <option value="High">High</option>
            </select><br />

            <input type="submit" value="Add Task" />
        </form>
    </div>
    <?php include 'footer.php'; ?>