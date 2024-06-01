<?php
session_start();
include('dbcon.php');
include('dashboard_nav.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Insert product into database
    $query = "INSERT INTO products (name, description, price) VALUES ('$name', '$description', '$price')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['status'] = "Product added successfully!";
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['status'] = "Failed to add product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body><br>
<div class="container">
    <h3 class="mb-4">Add Product</h3>
    <?php if (isset($_SESSION['status'])): ?>
        <p class="alert alert-info"><?php echo $_SESSION['status']; unset($_SESSION['status']); ?></p>
    <?php endif; ?>
    <form method="POST" action="add_product.php">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" required step="0.01">
        </div>
        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save</button>
        <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>


