<?php
session_start();
include('Includes/navbar.php');
include('Includes/header.php');

// if (isset($_SESSION['user_id'])) {
//     header("Location: dashboard.php");
//     exit();
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script> 
</head>
<body >
    <div class="container" style="max-width: 450px;">
        <h2>Registration</h2>
        <form id="registrationForm" method="POST" action="register.php" > <!-- Point to the PHP script -->
            <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
            <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <!-- <input type="password" id="password" name="password" placeholder="Password" required> -->
            <input type="date" id="dob" name="dob" placeholder="Date of Birth" required>
            <div class="form-group">
                <select id="languages" name="languages[]"class="form-control selectpicker" multiple required title="Select Languages">
                    <option disabled>Select Languages: </option>
                    <option value="English">English</option>
                    <option value="Tamil">Tamil</option>
                    <option value="Spanish">Spanish</option>
                    <option value="French">French</option>
                    <option value="Malayalam">Malayalam</option>
                    <option value="Telugu">Telugu</option>
                    <option value="Kannada">Kannada</option>
                    <option value="Hindi">Hindi</option>
                </select>
            </div>
            
            <select id="country" name="country" required >
                <option value="">Select Country</option>

            </select>
            <select id="state" name="state" required>
                <option value="">Select State</option>
            </select>
            <select id="city" name="city" required>
                <option value="">Select City</option>
                <!-- Cities will be populated dynamically based on the selected state -->
            </select>

            <button type="submit" name="register_btn" onclick="this.disabled=true; this.form.submit();">Submit</button>
            <div class="account"style="margin-left: 80px">Already have account? <a href="login.php"class="btnn">Go to Login</a>
</div>
        </form>
     
    </div>
    <script src="scripts.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    
</body>
</html>
