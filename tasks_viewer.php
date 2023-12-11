<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'header.php';

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

include 'database_connect.php';

// Fetch tasks from the database
$query = "SELECT * FROM tasks ORDER BY task_due ASC";
$result = $conn->query($query);

$tasks = [];

if ($result->num_rows > 0) {
    $tasks = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<body>
    <h1>Task List</h1>
    <?php if (!empty($tasks)) : ?>
        <table>
            <!-- Table headers -->
            <tr>
                <th>Title</th>
                <th>Name</th>
                <th>Task Description</th>
                <th>Due Date</th>
                <th>Priority</th>
                <th>Status</th>
            </tr>
            <!-- Table body -->
            <?php foreach ($tasks as $task) : ?>
                <tr class="task-row">
                    <td class="task-title"><?php echo htmlspecialchars($task['title']); ?></td>
                    <td class="task-name"><?php echo htmlspecialchars($task['Name']); ?></td>
                    <td class="task-description"><?php echo htmlspecialchars($task['description']); ?></td>
                    <td class="task-due"><?php echo htmlspecialchars($task['task_due']); ?></td>
                    <td class="task-priority"><?php echo htmlspecialchars($task['priority']); ?></td>
                    <td class="task-status">><?php echo htmlspecialchars($task['Status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No tasks to display.</p>
    <?php endif; ?>

    <?php include 'footer.php'; ?>