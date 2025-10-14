<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    
    // Validation
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required";
        header("Location: index.php?login=error");
        exit();
    }
    
    // Check if user exists
    $sql = "SELECT id, fullname, email, password FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, create session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            
            // Set remember me cookie if checked (30 days)
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_token', $token, time() + (86400 * 30), "/");
                
                // Store token in database (optional)
                $expires = date('Y-m-d H:i:s', time() + (86400 * 30));
                $insert_token = "INSERT INTO user_sessions (user_id, session_token, expires_at) 
                                VALUES ('{$user['id']}', '$token', '$expires')";
                mysqli_query($conn, $insert_token);
            }
            
            // Redirect to dashboard
            header("Location: customer_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password";
            header("Location: index.php?login=error");
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid email or password";
        header("Location: index.php?login=error");
        exit();
    }
}

mysqli_close($conn);
?>