<?php
session_start();
include('dbcon.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $query = "DELETE FROM products WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        $_SESSION['status'] = "Product deleted successfully!";
    } else {
        $_SESSION['status'] = "Failed to delete product.";
    }

    header("Location: dashboard.php");
    exit();
} else {
    header("Location: dashboard.php");
    exit();
}
?>
