<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.html");
    exit();
}

$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - 3Star & Sun Petshop</title>
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
            background: linear-gradient(90deg, var(--primary-green) 0%, var(--dark-green) 100%);
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
            <h1><i class="fas fa-user-circle"></i> Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
            <p>Email: <?php echo htmlspecialchars($user_email); ?></p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Customer Dashboard</h3>
                        <p>Welcome to your dashboard. You can manage your orders, profile, and more here.</p>
                        <a href="logout.php" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>