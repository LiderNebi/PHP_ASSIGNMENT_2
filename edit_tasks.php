<?php
include 'database_connect.php';


if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    $statement = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
    $statement->bind_param("i", $id);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows == 1) {
        $task = $result->fetch_assoc();
    } else {
        die('No task not found.');
    }
} else {
    die('ID not specified.');
}


$statement->close();
$conn->close();
include 'header.php';
?>

<h1>Edit Task</h1>

<?php if (isset($task)) : ?>
    <form action="update_tasks.php" method="post">
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>" />

        <label for="title">Title:</label><br />
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required /><br />

        <label for="Name">Name:</label><br />
        <input type="text" id="Name" name="Name" value="<?php echo htmlspecialchars($task['Name']); ?>" required /><br />

        <label for="description">Description:</label><br />
        <textarea id="description" name="description" required><?php echo htmlspecialchars($task['description']); ?></textarea><br />

        <label for="task_due">Due Date:</label><br />
        <input type="date" id="task_due" name="task_due" value="<?php echo htmlspecialchars($task['task_due']); ?>" required /><br />

        <label for="priority">Priority:</label><br />
        <select id="priority" name="priority">
            <option value="Low" <?php echo $task['priority'] == 'Low' ? 'selected' : ''; ?>>Low</option>
            <option value="High" <?php echo $task['priority'] == 'High' ? 'selected' : ''; ?>>High</option>
        </select><br />

        <label for="status">Status:</label><br />
        <select id="status" name="status">
            <option value="Not Completed" <?php echo $task['Status'] == 'Not Completed' ? 'selected' : ''; ?>>Not Completed</option>
            <option value="Completed" <?php echo $task['Status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
        </select><br />

        <input type="submit" value="Update Task" />
    </form>
<?php else : ?>
    <p>Task not found.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>