<?php
// ============================================
// FILE 2: product_details.php - Product Detail Page
// ============================================
session_start();
require_once 'config.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product details
$sql = "SELECT p.*, c.category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.id 
        WHERE p.id = $product_id AND p.status = 'active'";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: shop.php");
    exit();
}

// Fetch related products (same category)
$related_sql = "SELECT * FROM products 
                WHERE category_id = {$product['category_id']} 
                AND id != $product_id 
                AND status = 'active' 
                LIMIT 4";
$related_products = mysqli_query($conn, $related_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?> - 3Star & Sun Petshop</title>
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
            background: linear-gradient(135deg, var(--light-green) 0%, #fff 100%);
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(90deg, var(--primary-green) 0%, var(--dark-green) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .product-detail-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin: 40px 0;
        }

        .product-main-image {
            width: 100%;
            max-height: 500px;
            object-fit: contain;
            border-radius: 15px;
            background: #f8f9fa;
            padding: 20px;
        }

        .product-title {
            color: var(--dark-green);
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .product-price {
            color: var(--brown);
            font-size: 2.5rem;
            font-weight: bold;
            margin: 20px 0;
        }

        .product-category-badge {
            background: var(--primary-green);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 15px;
        }

        .product-description {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.8;
            margin: 25px 0;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }

        .quantity-btn {
            background: var(--primary-green);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .quantity-input {
            width: 80px;
            text-align: center;
            border: 2px solid var(--primary-green);
            border-radius: 8px;
            margin: 0 10px;
            padding: 8px;
        }

        .btn-add-to-cart {
            background: var(--primary-green);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-add-to-cart:hover {
            background: var(--dark-green);
            transform: scale(1.05);
        }

        .related-product-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .related-product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(127, 176, 105, 0.3);
        }

        .related-product-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Navigation (Same as shop.php) -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">3STAR & SUN PETSHOP</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="product-detail-card">
            <div class="row">
                <!-- Product Image -->
                <div class="col-md-6">
                    <?php if ($product['product_image']): ?>
                        <img src="uploads/<?php echo $product['product_image']; ?>" 
                             class="product-main-image" 
                             alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                    <?php else: ?>
                        <div class="product-main-image d-flex align-items-center justify-content-center">
                            <i class="fas fa-image fa-5x text-secondary"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Product Details -->
                <div class="col-md-6">
                    <div class="product-category-badge">
                        <?php echo htmlspecialchars($product['category_name']); ?>
                    </div>
                    
                    <h1 class="product-title">
                        <?php echo htmlspecialchars($product['product_name']); ?>
                    </h1>
                    
                    <div class="product-price">
                        ₱<?php echo number_format($product['price'], 2); ?>
                    </div>
                    
                    <div class="product-stock mb-4">
                        <?php if ($product['stock_quantity'] > 20): ?>
                            <span class="text-success">
                                <i class="fas fa-check-circle"></i> In Stock (<?php echo $product['stock_quantity']; ?> available)
                            </span>
                        <?php elseif ($product['stock_quantity'] > 0): ?>
                            <span class="text-warning">
                                <i class="fas fa-exclamation-triangle"></i> Only <?php echo $product['stock_quantity']; ?> left!
                            </span>
                        <?php else: ?>
                            <span class="text-danger">
                                <i class="fas fa-times-circle"></i> Out of Stock
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-description">
                        <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                    </div>
                    
                    <?php if ($product['stock_quantity'] > 0): ?>
                        <div class="quantity-control">
                            <button class="quantity-btn" onclick="decreaseQty()">-</button>
                            <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>">
                            <button class="quantity-btn" onclick="increaseQty()">+</button>
                        </div>
                        
                        <button class="btn-add-to-cart" onclick="addToCart(<?php echo $product['id']; ?>)">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    <?php else: ?>
                        <button class="btn-add-to-cart" disabled style="opacity: 0.5;">
                            Out of Stock
                        </button>
                    <?php endif; ?>
                    
                    <div class="mt-4">
                        <a href="shop.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Shop
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <?php if (mysqli_num_rows($related_products) > 0): ?>
            <div class="mt-5">
                <h3 class="mb-4" style="color: var(--dark-green);">Related Products</h3>
                <div class="row">
                    <?php while ($related = mysqli_fetch_assoc($related_products)): ?>
                        <div class="col-md-3">
                            <div class="related-product-card">
                                <?php if ($related['product_image']): ?>
                                    <img src="uploads/<?php echo $related['product_image']; ?>" class="related-product-img" alt="<?php echo htmlspecialchars($related['product_name']); ?>">
                                <?php else: ?>
                                    <div class="related-product-img bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image fa-2x text-secondary"></i>
                                    </div>
                                <?php endif; ?>
                                <h6><?php echo htmlspecialchars($related['product_name']); ?></h6>
                                <p class="text-muted mb-2">₱<?php echo number_format($related['price'], 2); ?></p>
                                <a href="product_details.php?id=<?php echo $related['id']; ?>" class="btn btn-sm btn-outline-success w-100">
                                    View Details
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function increaseQty() {
            var qty = document.getElementById('quantity');
            var max = parseInt(qty.getAttribute('max'));
            if (parseInt(qty.value) < max) {
                qty.value = parseInt(qty.value) + 1;
            }
        }

        function decreaseQty() {
            var qty = document.getElementById('quantity');
            if (parseInt(qty.value) > 1) {
                qty.value = parseInt(qty.value) - 1;
            }
        }

        function addToCart(productId) {
            var quantity = document.getElementById('quantity').value;
            alert('Adding ' + quantity + ' item(s) to cart\nProduct ID: ' + productId + '\n\nCart feature coming soon!');
        }
    </script>
</body>
</html>
<?php mysqli_close($conn); ?>