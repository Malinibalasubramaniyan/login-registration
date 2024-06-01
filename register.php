
<?php
session_start();
include('dbcon.php'); // Include the database connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Function to send confirmation email
function sendConfirmationEmail($email, $token) {
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
        $mail->addAddress($email); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification from Web Tech Project';
        $mail->Body    = '<h2>You have registered with Web Tech Project</h2>
                          <h5>Verify your email address and set password to login with the link below</h5>
                          <br/><br/>
                          <a href="http://localhost/login-registration/set_password.php?token=' . $token . '">Set Password</a>';
        $mail->AltBody = 'You have registered with Web Tech Project. Verify your email address to login using the link: http://localhost/login-registration/set_password.php?token=' . $token;

        // Send the email
        $mail->send();
        echo 'Confirmation email has been sent successfully!';
    } catch (Exception $e) {
        echo "Failed to send confirmation email. Mailer Error: {$mail->ErrorInfo}";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and escape it to prevent SQL injection
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $languages = mysqli_real_escape_string($conn, implode(',', $_POST['languages'])); // Assuming 'languages' is an array
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $checkEmailQuery);

    if (!$result) {
        echo "Error checking email: " . mysqli_error($conn);
    } else {
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Email id Already Exists'); window.location.href = 'index.php';</script>";
        } else {
            // Generate a unique token for email verification
            $token = bin2hex(random_bytes(16));

            // Insert user data into the database
            $query = "INSERT INTO users (firstName, lastName, email, dob, languages, country, state, city, token) 
                      VALUES ('$firstName', '$lastName', '$email', '$dob', '$languages', '$country', '$state', '$city', '$token')";

            if (mysqli_query($conn, $query)) {
                // Send confirmation email
                sendConfirmationEmail($email, $token);
                $_SESSION['status'] = "";
                header("Location: index.php");
            } else {
                $_SESSION['status'] = "Registration failed.";
                header("Location: index.php");
            }
        }
    }
}
?>
