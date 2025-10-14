<?php
// ============================================
// STEP 3: add_product.php - Add Product Handler
// ============================================
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category_id = (int)$_POST['category_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = (float)$_POST['price'];
    $stock_quantity = (int)$_POST['stock_quantity'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Handle file upload
    $product_image = '';
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['product_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            $upload_path = 'uploads/' . $new_filename;
            
            // Create uploads directory if not exists
            if (!file_exists('uploads')) {
                mkdir('uploads', 0777, true);
            }
            
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_path)) {
                $product_image = $new_filename;
            }
        }
    }
    
    // Insert product
    $sql = "INSERT INTO products (product_name, category_id, description, price, stock_quantity, product_image, status) 
            VALUES ('$product_name', $category_id, '$description', $price, $stock_quantity, '$product_image', '$status')";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Product added successfully!";
    } else {
        $_SESSION['error'] = "Error adding product: " . mysqli_error($conn);
    }
    
    header("Location: products.php");
    exit();
}
?>
