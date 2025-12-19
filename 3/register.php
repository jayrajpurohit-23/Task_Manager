<?php
include 'db.php';

// initialize variables
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
  {
    $username =($_POST['username']);
    $email =($_POST['email']);
    $password =($_POST['password']);

    $sql="insert into users(id,username,email,password)VALUES(NULL,'$username','$email','$password')";
    //execute query
    if($conn->query($sql)===TRUE){
      echo "Registration Successful";
    }else{
      echo "Error:".$conn->error;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | Task Manager</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h1>Register to Task Manager</h1>
</header>

<nav>
  <a href="index.php">Dashboard</a>
  <a href="login.php">Login</a>
</nav>

<main>
  <h2>User Registration</h2>
  <form action="" method="POST" class="form-container">
    <label>Full Name:</label>
    <input type="text" name="username" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Register</button>
  </form>

  <?php
  if (!empty($errors)) {
      echo "<div class='error-box'>";
      foreach ($errors as $err) echo " $err<br>";
      echo "</div>";
  }
  if ($success) echo "<div class='success-box'>$success</div>";
  ?>
</main>

<footer>
  <p> &copy; <?php echo date("Y"); ?> Task Manager by Jay</p>
</footer>

</body>
</html>
