<?php
// ============================================
// FILE 1: shop.php - Customer Product Catalog
// ============================================
session_start();
require_once 'config.php';

// Get filter parameters
$category_filter = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Build SQL query
$sql = "SELECT p.*, c.category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.id 
        WHERE p.status = 'active'";

if ($category_filter > 0) {
    $sql .= " AND p.category_id = $category_filter";
}

if (!empty($search_query)) {
    $sql .= " AND (p.product_name LIKE '%$search_query%' OR p.description LIKE '%$search_query%')";
}

// Add sorting
switch ($sort_by) {
    case 'price_low':
        $sql .= " ORDER BY p.price ASC";
        break;
    case 'price_high':
        $sql .= " ORDER BY p.price DESC";
        break;
    case 'name':
        $sql .= " ORDER BY p.product_name ASC";
        break;
    default:
        $sql .= " ORDER BY p.created_at DESC";
}

$products = mysqli_query($conn, $sql);

// Get all categories for filter
$categories_query = "SELECT * FROM categories ORDER BY category_name";
$categories = mysqli_query($conn, $categories_query);

// Count products per category
$cat_counts = [];
$count_query = "SELECT category_id, COUNT(*) as count FROM products WHERE status = 'active' GROUP BY category_id";
$count_result = mysqli_query($conn, $count_query);
while ($row = mysqli_fetch_assoc($count_result)) {
    $cat_counts[$row['category_id']] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - 3Star & Sun Petshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #7fb069;
            --dark-green: #5a8c4f;
            --light-green: #d4edda;
            --accent-yellow: #f4d35e;
            --brown: #8b4513;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--light-green) 0%, #fff 100%);
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(90deg, var(--primary-green) 0%, var(--dark-green) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand img {
            height: 60px;
            width: 60px;
            border-radius: 50%;
            border: 3px solid white;
        }

        .navbar-brand span {
            color: var(--accent-yellow);
            font-weight: bold;
            font-size: 1.5rem;
            margin-left: 10px;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
        }

        .sidebar {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .sidebar h5 {
            color: var(--dark-green);
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-green);
        }

        .category-item {
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .category-item:hover {
            background: var(--light-green);
            transform: translateX(5px);
        }

        .category-item.active {
            background: var(--primary-green);
            color: white;
        }

        .category-item a {
            text-decoration: none;
            color: inherit;
            flex: 1;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(127, 176, 105, 0.3);
        }

        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background: #f8f9fa;
        }

        .product-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-category {
            color: var(--primary-green);
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .product-title {
            color: var(--dark-green);
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .product-description {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 15px;
            flex: 1;
        }

        .product-price {
            color: var(--brown);
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .product-stock {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 15px;
        }

        .stock-available {
            color: green;
        }

        .stock-low {
            color: orange;
        }

        .stock-out {
            color: red;
        }

        .btn-add-cart {
            background: var(--primary-green);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-add-cart:hover {
            background: var(--dark-green);
            transform: scale(1.05);
        }

        .btn-view-details {
            background: white;
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
            padding: 8px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }

        .btn-view-details:hover {
            background: var(--primary-green);
            color: white;
        }

        .search-filter-bar {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .no-products {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .no-products i {
            font-size: 5rem;
            color: var(--primary-green);
            margin-bottom: 20px;
        }

        .badge-new {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--accent-yellow);
            color: var(--brown);
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="img/logo.jpg" alt="3Star & Sun Petshop Logo">
                <span>3STAR & SUN PETSHOP</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="shop.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <i class="fas fa-shopping-cart"></i> Cart
                            <span class="badge bg-danger">0</span>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['logged_in'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="customer_dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#loginModal">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1><i class="fas fa-shopping-bag"></i> Shop Our Products</h1>
            <p>Premium products for your beloved dogs and cats</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-md-3">
                <div class="sidebar">
                    <h5><i class="fas fa-filter"></i> Categories</h5>
                    <div class="category-item <?php echo $category_filter == 0 ? 'active' : ''; ?>">
                        <a href="shop.php">All Products</a>
                        <span class="badge bg-secondary"><?php echo mysqli_num_rows($products); ?></span>
                    </div>
                    <?php mysqli_data_seek($categories, 0); ?>
                    <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                        <div class="category-item <?php echo $category_filter == $cat['id'] ? 'active' : ''; ?>">
                            <a href="shop.php?category=<?php echo $cat['id']; ?>">
                                <?php echo htmlspecialchars($cat['category_name']); ?>
                            </a>
                            <span class="badge bg-secondary">
                                <?php echo isset($cat_counts[$cat['id']]) ? $cat_counts[$cat['id']] : 0; ?>
                            </span>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Pet Type Filter -->
                <div class="sidebar mt-3">
                    <h5><i class="fas fa-paw"></i> Pet Type</h5>
                    <div class="category-item">
                        <a href="shop.php?search=dog">
                            <i class="fas fa-dog"></i> Dog Products
                        </a>
                    </div>
                    <div class="category-item">
                        <a href="shop.php?search=cat">
                            <i class="fas fa-cat"></i> Cat Products
                        </a>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-md-9">
                <!-- Search and Sort Bar -->
                <div class="search-filter-bar">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <form action="shop.php" method="GET" class="d-flex">
                                <input type="text" class="form-control me-2" name="search" 
                                       placeholder="Search products..." 
                                       value="<?php echo htmlspecialchars($search_query); ?>">
                                <button type="submit" class="btn btn-add-cart">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="shop.php" method="GET" class="d-flex align-items-center justify-content-end">
                                <?php if ($category_filter > 0): ?>
                                    <input type="hidden" name="category" value="<?php echo $category_filter; ?>">
                                <?php endif; ?>
                                <label class="me-2 mb-0">Sort by:</label>
                                <select name="sort" class="form-select" onchange="this.form.submit()" style="width: auto;">
                                    <option value="newest" <?php echo $sort_by == 'newest' ? 'selected' : ''; ?>>Newest First</option>
                                    <option value="price_low" <?php echo $sort_by == 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                                    <option value="price_high" <?php echo $sort_by == 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
                                    <option value="name" <?php echo $sort_by == 'name' ? 'selected' : ''; ?>>Name: A-Z</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Products List -->
                <?php if (mysqli_num_rows($products) > 0): ?>
                    <div class="row">
                        <?php while ($product = mysqli_fetch_assoc($products)): ?>
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="product-card">
                                    <?php
                                    // Check if product is new (created within 7 days)
                                    $created = strtotime($product['created_at']);
                                    $now = time();
                                    $diff = $now - $created;
                                    $days = floor($diff / (60 * 60 * 24));
                                    if ($days <= 7):
                                    ?>
                                        <div class="badge-new">NEW</div>
                                    <?php endif; ?>
                                    
                                    <?php if ($product['product_image']): ?>
                                        <img src="uploads/<?php echo $product['product_image']; ?>" 
                                             class="product-image" 
                                             alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                    <?php else: ?>
                                        <div class="product-image d-flex align-items-center justify-content-center bg-light">
                                            <i class="fas fa-image fa-3x text-secondary"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="product-body">
                                        <div class="product-category">
                                            <?php echo htmlspecialchars($product['category_name']); ?>
                                        </div>
                                        <div class="product-title">
                                            <?php echo htmlspecialchars($product['product_name']); ?>
                                        </div>
                                        <div class="product-description">
                                            <?php echo substr(htmlspecialchars($product['description']), 0, 80) . '...'; ?>
                                        </div>
                                        <div class="product-price">
                                            ₱<?php echo number_format($product['price'], 2); ?>
                                        </div>
                                        <div class="product-stock">
                                            <?php if ($product['stock_quantity'] > 20): ?>
                                                <span class="stock-available">
                                                    <i class="fas fa-check-circle"></i> In Stock
                                                </span>
                                            <?php elseif ($product['stock_quantity'] > 0): ?>
                                                <span class="stock-low">
                                                    <i class="fas fa-exclamation-triangle"></i> Only <?php echo $product['stock_quantity']; ?> left
                                                </span>
                                            <?php else: ?>
                                                <span class="stock-out">
                                                    <i class="fas fa-times-circle"></i> Out of Stock
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if ($product['stock_quantity'] > 0): ?>
                                            <button class="btn-add-cart" onclick="addToCart(<?php echo $product['id']; ?>)">
                                                <i class="fas fa-shopping-cart"></i> Add to Cart
                                            </button>
                                        <?php else: ?>
                                            <button class="btn-add-cart" disabled style="opacity: 0.5;">
                                                Out of Stock
                                            </button>
                                        <?php endif; ?>
                                        
                                        <a href="product_details.php?id=<?php echo $product['id']; ?>" class="btn-view-details">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="no-products">
                        <i class="fas fa-box-open"></i>
                        <h3>No Products Found</h3>
                        <p>Try adjusting your search or filter criteria</p>
                        <a href="shop.php" class="btn btn-add-cart mt-3">View All Products</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addToCart(productId) {
            // Add to cart functionality (will implement in next phase)
            alert('Add to cart feature coming soon!\nProduct ID: ' + productId);
        }
    </script>
</body>
</html>
<?php mysqli_close($conn); ?>
