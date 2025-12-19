<?php
include 'db.php';
$id = $_GET['id'];

$delete = "DELETE FROM tasks WHERE id='$id'";
if (mysqli_query($conn, $delete)) {
    echo "<script>alert('Task Deleted'); window.location='dashboard.php';</script>";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>
