<?php
include('db.php');
date_default_timezone_set("Asia/Kolkata");

// --- Add Task ---
if (isset($_POST['add_task'])) {
    $task_name = trim($_POST['task_name']);
    $task_name = trim($_POST['description']);
    if ($task_name !== "") {
        $sql = "INSERT INTO tasks (task_name,description) VALUES ('$task_name','$description')";
        $conn->query($sql);
    }
}

// --- Delete Task ---
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM tasks WHERE id=$id");
}

// --- Change Status ---
if (isset($_GET['change'])) {
    $id = (int)$_GET['change'];
    $conn->query("UPDATE tasks 
                  SET status = IF(status='Pending','Completed','Pending') 
                  WHERE id=$id");
}

// --- Filter ---
$filter = $_GET['filter'] ?? 'all';
if ($filter == 'pending') {
    $sql = "SELECT * FROM tasks WHERE status='Pending'";
} elseif ($filter == 'completed') {
    $sql = "SELECT * FROM tasks WHERE status='Completed'";
} else {
    $sql = "SELECT * FROM tasks";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Task Manager Dashboard</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f4f7fb;
      color: #333;
      margin: 0;
      padding: 0;
    }

    header {
      background: #0078D7;
      color: white;
      padding: 20px;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    nav {
      text-align: center;
      background: white;
      padding: 10px;
      box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    }

    nav a {
      text-decoration: none;
      color: #0078D7;
      font-weight: bold;
      margin: 0 15px;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #005fa3;
    }

    main {
      max-width: 900px;
      margin: 30px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #0078D7;
    }

    form {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
      gap: 10px;
    }

    input[type="text"] {
      flex: 1;
      padding: 10px;
      border: 2px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      outline: none;
      transition: border 0.3s;
    }

    input[type="text"]:focus {
      border-color: #0078D7;
    }

    button {
      padding: 10px 20px;
      background: #0078D7;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s;
    }

    button:hover {
      background: #005fa3;
    }

    .filters {
      text-align: center;
      margin-bottom: 20px;
    }

    .filters a {
      margin: 0 10px;
      text-decoration: none;
      color: #0078D7;
      font-weight: bold;
      transition: color 0.3s;
    }

    .filters a:hover {
      color: #005fa3;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 12px;
      text-align: center;
    }

    th {
      background: #0078D7;
      color: white;
    }

    tr:nth-child(even) {
      background: #f2f6fc;
    }

    tr:hover {
      background: #e9f0ff;
    }

    a.action {
      text-decoration: none;
      color: #0078D7;
      font-weight: bold;
      margin: 0 5px;
      transition: color 0.3s;
    }

    a.action:hover {
      color: #005fa3;
    }

    footer {
      text-align: center;
      padding: 15px;
      background: #0078D7;
      color: white;
      margin-top: 40px;
    }

    @media (max-width: 600px) {
      main {
        width: 95%;
        padding: 15px;
      }

      form {
        flex-direction: column;
      }

      input[type="text"], button {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<header>
  <h1>Task Manager Dashboard</h1>
  <p><?php echo "Current Date & Time: " . date("Y-m-d H:i:s"); ?></p>
</header>

<nav>
  <a href="index.php">Dashboard</a>
  <a href="register.php">Register</a>
  <a href="login.php">Login</a>
</nav>

<nav>
  <a href="add_task.php">Add Task</a>
  <a href="delete_task.php">Delete Task</a>
  <a href="update_task.php">Update Task</a>
</nav>

<main>
  <h2>Manage Your Tasks</h2>

  <form method="POST">
    <input type="text" name="task_title" placeholder="Enter a new task..." required>
    <input type="text" name="description" placeholder="Enter description..." required>
    
    <button type="submit" name="add_task">Add Task</button>
  </form>

  <div class="filters">
    <a href="index.php?filter=all">All</a> |
    <a href="index.php?filter=pending">Pending</a> |
    <a href="index.php?filter=completed">Completed</a>
  </div>

  <table>
    <tr>
      <th>ID</th>
      <th>Task Name</th>
      <th>Description</th>
      <th>Status</th>
      <th>Created At</th>
      <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['task_name']}</td>
                <td>{$row['description']}</td>
                <td><b style='color:" . ($row['status'] == 'Completed' ? 'green' : 'orange') . ";'>{$row['status']}</b></td>
                <td>{$row['created_at']}</td>
                <td>
                    <a class='action' href='?change={$row['id']}'>Change</a> |
                    <a class='action' href='?delete={$row['id']}' onclick=\"return confirm('Delete this task?')\">Delete</a>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No tasks found</td></tr>";
    }
    ?>
  </table>
</main>

<footer>
  <p>&copy; <?php echo date("Y"); ?> Task Manager by Jay</p>
</footer>

</body>
</html>
