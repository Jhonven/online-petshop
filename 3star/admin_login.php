<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];
    
    // Validation
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username and password are required";
        header("Location: index.php?admin=error");
        exit();
    }
    
    // Check if admin exists
    $sql = "SELECT id, username, password, email FROM admins WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $admin['password'])) {
            // Password is correct, create session
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_logged_in'] = true;
            
            // Redirect to admin dashboard
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid username or password";
            header("Location: index.php?admin=error");
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid username or password";
        header("Location: index.php?admin=error");
        exit();
    }
}

mysqli_close($conn);
?>