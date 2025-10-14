<?php
// ============================================
// STEP 4: delete_product.php - Delete Product Handler
// ============================================
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.html");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Get product image to delete file
    $result = mysqli_query($conn, "SELECT product_image FROM products WHERE id = $id");
    $product = mysqli_fetch_assoc($result);
    
    // Delete product from database
    $sql = "DELETE FROM products WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        // Delete image file if exists
        if ($product['product_image'] && file_exists('uploads/' . $product['product_image'])) {
            unlink('uploads/' . $product['product_image']);
        }
        $_SESSION['success'] = "Product deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting product: " . mysqli_error($conn);
    }
}

header("Location: products.php");
exit();
?><?php
// ============================================
// STEP 4: delete_product.php - Delete Product Handler
// ============================================
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Get product image to delete file
    $result = mysqli_query($conn, "SELECT product_image FROM products WHERE id = $id");
    $product = mysqli_fetch_assoc($result);
    
    // Delete product from database
    $sql = "DELETE FROM products WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        // Delete image file if exists
        if ($product['product_image'] && file_exists('uploads/' . $product['product_image'])) {
            unlink('uploads/' . $product['product_image']);
        }
        $_SESSION['success'] = "Product deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting product: " . mysqli_error($conn);
    }
}

header("Location: products.php");
exit();
?>