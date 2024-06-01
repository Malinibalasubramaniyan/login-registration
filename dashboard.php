<?php
session_start();
include('dbcon.php');
include('dashboard_nav.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-description {
            max-height: 400px; /* Set maximum height */
            overflow: hidden; /* Hide overflow content */
        }
    </style>
</head>
<body>

<div class="container">
    <h3 class="mb-4">Product Listing</h3>
    <a href="add_product.php" class="btn btn-primary mb-2"><i class="fas fa-plus"></i> Add Product</a>
    <?php
    if (isset($_SESSION['status'])) {
        echo '<div class="alert alert-info">' . $_SESSION['status'] . '</div>';
        unset($_SESSION['status']);
    }
    ?>
    <div class="row" id="product-list">
        <?php
        $query = "SELECT * FROM products";
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $description = strlen($row['description']) > 70 ? substr($row['description'], 0, 70) . '...' : $row['description'];
                echo '<div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                                <p class="card-text card-description">' . htmlspecialchars($description) . '</p>
                                <p class="card-text">₹' . htmlspecialchars($row['price']) . '</p>
                                <a href="edit_product.php?id=' . $row['id'] . '" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="delete_product.php" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                    <input type="hidden" name="id" value="' . $row['id'] . '">
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                      </div>';
            }
        } else {
            echo '<p>Error fetching products from the database.</p>';
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this product?');
}
</script>
</body>
</html>
