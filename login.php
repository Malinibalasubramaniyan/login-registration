
<?php
session_start();
include('dbcon.php');
include('Includes/navbar.php');
include('Includes/header.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Fetch user data from the database
    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables and redirect to dashboard
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['status'] = "Login successful!";
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['status'] = "Invalid password.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "No user found with this email.";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .forget-pass{
            font-size: 12px;
        }
    </style>
</head>
<body> <div class="container">

    <?php if (isset($_SESSION['status'])): ?>
        <p><?php echo $_SESSION['status']; unset($_SESSION['status']); ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <div class="forget-pass"><a href="forgot_password.php">Forgot Password?</a> 
    </div>
        <button type="submit">Login</button>
    </form>
    </div>
</body>
</html>
