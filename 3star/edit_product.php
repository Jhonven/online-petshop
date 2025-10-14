<?php
// ============================================
// edit_product.php - Complete Edit Product Page
// ============================================
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.html");
    exit();
}

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product details
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    $_SESSION['error'] = "Product not found!";
    header("Location: products.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category_id = (int)$_POST['category_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = (float)$_POST['price'];
    $stock_quantity = (int)$_POST['stock_quantity'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $product_image = $product['product_image'];
    
    // Handle new image upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['product_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            // Delete old image
            if ($product_image && file_exists('uploads/' . $product_image)) {
                unlink('uploads/' . $product_image);
            }
            
            $new_filename = uniqid() . '.' . $ext;
            $upload_path = 'uploads/' . $new_filename;
            
            if (!file_exists('uploads')) {
                mkdir('uploads', 0777, true);
            }
            
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_path)) {
                $product_image = $new_filename;
            }
        }
    }
    
    // Update product
    $sql = "UPDATE products SET 
            product_name = '$product_name',
            category_id = $category_id,
            description = '$description',
            price = $price,
            stock_quantity = $stock_quantity,
            product_image = '$product_image',
            status = '$status'
            WHERE id = $product_id";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Product updated successfully!";
        header("Location: products.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - 3Star & Sun Petshop</title>
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
            padding: 30px 0;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .card-header {
            background: linear-gradient(90deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        .btn-primary-custom {
            background: var(--primary-green);
            border: none;
            color: white;
        }
        .btn-primary-custom:hover {
            background: var(--dark-green);
        }
        .current-image {
            max-width: 200px;
            border-radius: 10px;
            margin-top: 10px;
        }
        .form-label {
            font-weight: 600;
            color: var(--dark-green);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Product</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product Name *</label>
                                    <input type="text" class="form-control" name="product_name" 
                                           value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category *</label>
                                    <select class="form-select" name="category_id" required>
                                        <option value="">Select Category</option>
                                        <?php
                                        $categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_name");
                                        while ($cat = mysqli_fetch_assoc($categories)):
                                        ?>
                                            <option value="<?php echo $cat['id']; ?>" 
                                                <?php echo ($cat['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($cat['category_name']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price (₱) *</label>
                                    <input type="number" step="0.01" class="form-control" name="price" 
                                           value="<?php echo $product['price']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stock Quantity *</label>
                                    <input type="number" class="form-control" name="stock_quantity" 
                                           value="<?php echo $product['stock_quantity']; ?>" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product Image</label>
                                    <input type="file" class="form-control" name="product_image" accept="image/*">
                                    <?php if ($product['product_image']): ?>
                                        <div class="mt-2">
                                            <small class="text-muted">Current Image:</small><br>
                                            <img src="uploads/<?php echo $product['product_image']; ?>" 
                                                 class="current-image" alt="Current Product Image">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status *</label>
                                    <select class="form-select" name="status" required>
                                        <option value="active" <?php echo ($product['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo ($product['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="products.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Products
                                </a>
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-save"></i> Update Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>