<?php
// ============================================
// STEP 2: products.php - Admin Product Management Page
// ============================================
session_start();
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

// Fetch all products with category names
$sql = "SELECT p.*, c.category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.id 
        ORDER BY p.created_at DESC";
$products = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management - 3Star & Sun Petshop</title>
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
        .sidebar {
            background: linear-gradient(180deg, var(--dark-green) 0%, var(--primary-green) 100%);
            min-height: 100vh;
            color: white;
            padding: 20px 0;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            display: block;
            transition: all 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
            padding-left: 30px;
        }
        .sidebar a.active {
            background: rgba(255,255,255,0.3);
            border-left: 4px solid white;
        }
        .content {
            padding: 30px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .btn-primary-custom {
            background: var(--primary-green);
            border: none;
            color: white;
        }
        .btn-primary-custom:hover {
            background: var(--dark-green);
        }
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="text-center mb-4">
                    <img src="img/logo.jpg" 
                         alt="logo" style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid white;">
                    <h5 class="mt-3">Admin Panel</h5>
                    <small><?php echo $_SESSION['admin_username']; ?></small>
                </div>
                <a href="admin_dashboard.php"><i class="fas fa-dashboard"></i> Dashboard</a>
                <a href="products.php" class="active"><i class="fas fa-box"></i> Products</a>
                <a href="categories.php"><i class="fas fa-tags"></i> Categories</a>
                <a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
                <a href="customers.php"><i class="fas fa-users"></i> Customers</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-box"></i> Product Management</h2>
                    <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fas fa-plus"></i> Add New Product
                    </button>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Products Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($product = mysqli_fetch_assoc($products)): ?>
                                    <tr>
                                        <td>
                                            <?php if ($product['product_image']): ?>
                                                <img src="uploads/<?php echo $product['product_image']; ?>" 
                                                     class="product-image" alt="<?php echo $product['product_name']; ?>">
                                            <?php else: ?>
                                                <div class="product-image bg-secondary d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-image text-white"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><strong><?php echo htmlspecialchars($product['product_name']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                        <td>₱<?php echo number_format($product['price'], 2); ?></td>
                                        <td><?php echo $product['stock_quantity']; ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $product['status']; ?>">
                                                <?php echo ucfirst($product['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="editProduct(<?php echo $product['id']; ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteProduct(<?php echo $product['id']; ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--primary-green); color: white;">
                    <h5 class="modal-title"><i class="fas fa-plus"></i> Add New Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="add_product.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" name="product_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category *</label>
                                <select class="form-select" name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php
                                    $categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_name");
                                    while ($cat = mysqli_fetch_assoc($categories)):
                                    ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['category_name']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price (₱) *</label>
                                <input type="number" step="0.01" class="form-control" name="price" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock Quantity *</label>
                                <input type="number" class="form-control" name="stock_quantity" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Product Image</label>
                                <input type="file" class="form-control" name="product_image" accept="image/*">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select class="form-select" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary-custom">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                window.location.href = 'delete_product.php?id=' + id;
            }
        }

        function editProduct(id) {
            window.location.href = 'edit_product.php?id=' + id;
        }
    </script>
</body>
</html>
<?php mysqli_close($conn); ?>