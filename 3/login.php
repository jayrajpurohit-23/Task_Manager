<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Login Successful! Welcome " . $row['username'];
        header("Location: index.php");
    } else {
        echo "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Task Manager</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h1>Login to Task Manager</h1>
</header>

<nav>
  <a href="index.php">Dashboard</a>
  <a href="register.php">Register</a>
</nav>

<main>
  <form action="login.php" method="POST" class="form-container">
    <label>Username:</label>
    <input type="username" name="username" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
  </form>

  <?php
  if (!empty($message)) {
      echo "<p class='message'>$message</p>";
  }
  ?>
</main>

<footer>
  <p>&copy; <?php echo date("Y"); ?> Task Manager by Jay</p>
</footer>

</body>
</html>
