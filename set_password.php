
<?php
include('Includes/navbar.php');
include('Includes/header.php');

session_start();
include('dbcon.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify token
    $query = "SELECT * FROM users WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Token is valid
        $user = mysqli_fetch_assoc($result);
        $email = $user['email'];
    } else {
        // Invalid token
        $_SESSION['status'] = "Invalid token.";
        header("Location: index.php");
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token'])) {
    $token = $_POST['token'];
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    if ($password == $confirmPassword) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Update password in the database
        $query = "UPDATE users SET password='$hashedPassword', token=NULL WHERE token='$token' LIMIT 1";
        if (mysqli_query($conn, $query)) {
            $_SESSION['status'] = "You can login, Now";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['status'] = "Failed to set password. Please try again.";
        }
    } else {
        $_SESSION['status'] = "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body><div class="container">
    <?php if (isset($_SESSION['status'])): ?>
        <p><?php echo $_SESSION['status']; unset($_SESSION['status']); ?></p>
    <?php endif; ?>

    <?php if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($email)): ?>
    
        <form method="POST" action="set_password.php">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <label for="password">New Password:</label>
            <input type="password" name="password" required>
            <br>
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" name="confirmPassword" required>
            <br>
            <button type="submit">Set Password</button>
        </form>
        </div>
    <?php endif; ?>

</body>
</html>

