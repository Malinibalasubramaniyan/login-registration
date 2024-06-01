<?php
session_start();
include('dbcon.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $otp = mysqli_real_escape_string($conn, $_POST['otp']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    $query = "SELECT * FROM users WHERE email='$email' AND otp='$otp'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        if ($password == $confirmPassword) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Update password in the database
            $updateQuery = "UPDATE users SET password='$hashedPassword', otp=NULL WHERE email='$email'";
            if (mysqli_query($conn, $updateQuery)) {
                $_SESSION['status'] = "Password reset successfully. You can now log in.";
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['status'] = "Failed to reset password. Please try again.";
                echo "Error: " . mysqli_error($conn); // Debugging output
            }
        } else {
            $_SESSION['status'] = "Passwords do not match.";
        }
    } else {
        $_SESSION['status'] = "Invalid OTP.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['status'])): ?>
            <p><?php echo $_SESSION['status']; unset($_SESSION['status']); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <br>
            <label for="otp">OTP:</label>
            <input type="text" name="otp" required>
            <br>
            <label for="password">New Password:</label>
            <input type="password" name="password" required>
            <br>
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" name="confirmPassword" required>
            <br>
            <button type="submit">Reset Password</button>
            <a href="test.php">Resend OTP</a>
        </form>
    </div>
</body>
</html>