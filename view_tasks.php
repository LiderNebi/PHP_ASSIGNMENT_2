<?php
include 'header.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'database_connect.php';

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}



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
            <tr>
                <th>Title</th>
                <th>Name</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Image</th>
                <?php if ($_SESSION['title'] == 'Manager' || $_SESSION['title'] == 'Supervisor') : ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
            <?php foreach ($tasks as $task) : ?>
                <tr class="task-row">
                    <td class="task-title"><?php echo htmlspecialchars($task['title']); ?></td>
                    <td class="task-name"><?php echo htmlspecialchars($task['Name']); ?></td>
                    <td class="task-description"><?php echo htmlspecialchars($task['description']); ?></td>
                    <td class="task-due"><?php echo htmlspecialchars($task['task_due']); ?></td>
                    <td class="task-priority"><?php echo htmlspecialchars($task['priority']); ?></td>
                    <td class="task-status"><?php echo htmlspecialchars($task['Status']); ?></td>
                    <td class="task-image">
                        <?php if (!empty($task['image'])) : ?>
                            <img src="/PHP_FINAL_PROJECT/<?php echo htmlspecialchars($task['image']); ?>" alt="Task Image" style="max-width: 50px; height: auto;">

                        <?php else : ?>
                            <span>No image</span>
                        <?php endif; ?>
                    </td>
                    <!-- Only show edit/delete for view_tasks.php, becaues the system shouldn't allow regular employees to delete and add tasks -->
                    <?php if ($_SESSION['title'] == 'Manager' || $_SESSION['title'] == 'Supervisor') : ?>
                        <td class="task-actions">
                            <a href="edit_tasks.php?id=<?php echo $task['id']; ?>" class="task-edit">Edit</a>
                            <a href="delete_tasks.php?id=<?php echo $task['id']; ?>" class="task-delete" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                            <?php if ($_SESSION['title'] == 'Manager' || $_SESSION['title'] == 'Supervisor') : ?>
                                <a href="add_tasks.php" class="add-tasks">Add Task</a>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No tasks to display.</p>
    <?php endif; ?>
    <?php include 'footer.php' ?>