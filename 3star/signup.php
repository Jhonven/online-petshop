<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize
    $fullname = mysqli_real_escape_string($conn, trim($_POST['fullname']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    $errors = array();
    
    // Check if fields are empty
    if (empty($fullname) || empty($email) || empty($phone) || empty($password)) {
        $errors[] = "All fields are required";
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Check password length
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // Check if email already exists
    $check_email = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Email already registered";
    }
    
    // If no errors, proceed with registration
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user into database
        $sql = "INSERT INTO users (fullname, email, phone, password) 
                VALUES ('$fullname', '$email', '$phone', '$hashed_password')";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['success_message'] = "Registration successful! Please login.";
            header("Location: index.php?signup=success");
            exit();
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
    
    // If there are errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: index.php?signup=error");
        exit();
    }
}

mysqli_close($conn);
?>