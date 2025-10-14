<?php
session_start();
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$admin_username = $_SESSION['admin_username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - 3Star & Sun Petshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #7fb069;
            --dark-green: #5a8c4f;
            --light-green: #d4edda;
        }
        body {
            background: linear-gradient(135deg, var(--light-green) 0%, #fff 100%);
            min-height: 100vh;
        }
        .dashboard-header {
            background: linear-gradient(90deg, var(--dark-green) 0%, #000 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 30px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <div class="container">
            <h1><i class="fas fa-user-shield"></i> Admin Dashboard</h1>
            <p>Logged in as: <?php echo htmlspecialchars($admin_username); ?></p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card-body text-center">
    <h3>Admin Panel</h3>
    <p>Welcome to the admin dashboard. Choose a section below to manage:</p>

    <div class="d-flex justify-content-center gap-3 flex-wrap mt-3">
        <a href="products.php" class="btn btn-success btn-lg">
            <i class="fas fa-paw"></i> Manage Products
        </a>
        <a href="users.php" class="btn btn-primary btn-lg">
            <i class="fas fa-users"></i> Manage Users
        </a>
        <a href="orders.php" class="btn btn-warning btn-lg">
            <i class="fas fa-shopping-cart"></i> Manage Orders
        </a>
        <a href="logout.php" class="btn btn-danger btn-lg">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>

            </div>
        </div>
    </div>
</body>
</html>