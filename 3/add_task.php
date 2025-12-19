<?php include 'db.php';
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "INSERT INTO tasks (title, description) VALUES ('$title', '$description')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Task</title>
    <link rel="stylesheet" href="style.css">
    <style>/*
        form { width: 400px; margin: 50px auto; font-family: Arial; }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px 20px; background: green; color: white; border: none; }*/
    </style>
</head>
<body>

<h2>Add Task</h2>
<form method="POST">
    <label>Title:</label>
    <input type="text" name="title" required>
    <label>Description:</label>
    <textarea name="description" rows="4" required></textarea>
    <label for="">Due Date</label>
    <input type="date" name="due_date" id="">
    <button type="submit" name="submit">Add</button>
</form>

</body>
</html>
