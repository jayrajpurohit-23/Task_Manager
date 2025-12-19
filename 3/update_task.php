<?php
// Include database connection
include 'db.php';

// Check if the form is submitted
if (isset($_POST['update'])) {
    // Get data from form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Update query
    $sql = "UPDATE tasks SET title='$title', description='$description' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch the record to display in form (using id from URL)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM tasks WHERE id=$id");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Record not found!";
        exit;
    }
} else {
    echo "No ID provided!";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Task</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .container { width: 400px; margin: 60px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        input, textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; }
        button { padding: 10px 20px; background: #007bff; border: none; color: white; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="container">
    <h2>Update Task</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label>Title:</label>
        <input type="text" name="title" value="<?php echo $row['title']; ?>" required>

        <label>Description:</label>
        <textarea name="description" rows="4" required><?php echo $row['description']; ?></textarea>

        <button type="submit" name="update">Update</button>
    </form>
</div>

</body>
</html>
