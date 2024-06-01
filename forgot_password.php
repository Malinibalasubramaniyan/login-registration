<?php
session_start();
include('dbcon.php');
include('Includes/navbar.php');
include('Includes/header.php');

// Ensure PHPMailer is loaded correctly
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOtpEmail($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        // SMTP server configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'webtech3210@gmail.com';
        $mail->Password = 'ygyufbitniwyegua'; // App-specific password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('webtech3210@gmail.com', 'Malini');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Password Reset';
        $mail->Body = '<h2>Your OTP for Password Reset</h2>
                       <p>Your OTP is: ' . $otp . '</p>';
        $mail->AltBody = 'Your OTP for Password Reset is ' . $otp;

        $mail->send();
    } catch (Exception $e) {
        echo "Failed to send OTP email. Mailer Error: {$mail->ErrorInfo}";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists in the database
    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $otp = rand(100000, 999999); // Generate a random 6-digit OTP

        // Store OTP in the database
        $query = "UPDATE users SET otp='$otp' WHERE email='$email' LIMIT 1";
        if (mysqli_query($conn, $query)) {
            sendOtpEmail($email, $otp);
            $_SESSION['status'] = "OTP sent to your email. Please check your email.";
            header("Location: verify_otp.php");
            exit();
        } else {
            $_SESSION['status'] = "Failed to update OTP. Please try again.";
        }
    } else {
        $_SESSION['status'] = "No user found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
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
            <button type="submit">Send OTP</button>
        </form>
    </div>
</body>
</html>
