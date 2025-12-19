<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['username'];
$result = mysqli_query($conn, "SELECT * FROM tasks WHERE username='$username'");
?>

<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
<a href="add_task.php">+ Add New Task</a> | <a href="logout.php">Logout</a>
<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Task Name</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['task_name']; ?></td>
            <td><?= $row['status']; ?></td>
            <td><?= $row['created_at']; ?></td>
            <td>
                <a href="edit_task.php?id=<?= $row['id']; ?>">Edit</a> |
                <a href="delete_task.php?id=<?= $row['id']; ?>" onclick="return confirm('Delete this task?');">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>
