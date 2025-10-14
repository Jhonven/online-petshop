<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3Star & Sun Petshop - Home</title>
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
            scroll-behavior: smooth;
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .navbar-brand span {
            color: var(--accent-yellow);
            font-weight: bold;
            font-size: 1.5rem;
            margin-left: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--accent-yellow) !important;
            transform: translateY(-2px);
        }

        .btn-login, .btn-signup {
            border-radius: 25px;
            padding: 8px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login {
            background-color: white;
            color: var(--primary-green);
            border: 2px solid white;
        }

        .btn-login:hover {
            background-color: transparent;
            color: white;
            border-color: white;
        }

        .btn-signup {
            background-color: var(--accent-yellow);
            color: var(--brown);
            border: 2px solid var(--accent-yellow);
            margin-left: 10px;
        }

        .btn-signup:hover {
            background-color: transparent;
            color: white;
            border-color: white;
        }

        .search-box {
            width: 250px;
        }

        .search-input {
            border: 2px solid white;
            border-radius: 25px 0 0 25px;
            padding: 8px 15px;
            background: rgba(255, 255, 255, 0.9);
            color: var(--dark-green);
        }

        .search-input:focus {
            background: white;
            border-color: var(--accent-yellow);
            box-shadow: none;
        }

        .search-input::placeholder {
            color: #999;
        }

        .btn-search {
            background-color: var(--accent-yellow);
            color: var(--brown);
            border: 2px solid var(--accent-yellow);
            border-radius: 0 25px 25px 0;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .btn-search:hover {
            background-color: white;
            color: var(--primary-green);
            border-color: white;
        }

        @media (max-width: 991px) {
            .search-box {
                width: 100%;
                margin: 15px 0;
            }
        }

        .hero-section {
           width: 100%;
  min-height: 100vh; /* full screen height */
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  color: white;
            background-image: url('/petshop/3star/img/bg2.png');
            padding: 100px 0;
            text-align: center;
        }

        .hero-section h1 {
            color: var(--dark-green);
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .hero-section p {
            color: #555;
            font-size: 1.3rem;
            margin-bottom: 40px;
        }

        .section-title {
            color: var(--dark-green);
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 50px;
            text-align: center;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        section {
            padding: 80px 0;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(127, 176, 105, 0.3);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary-green);
            margin-bottom: 20px;
        }

        .feature-card h3 {
            color: var(--dark-green);
            font-weight: bold;
            margin-bottom: 15px;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin: 15px 0;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-icon {
            font-size: 4rem;
            color: var(--primary-green);
            margin-bottom: 15px;
        }

        .service-item {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin: 15px 0;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .service-item:hover {
            transform: translateX(10px);
            box-shadow: 0 5px 20px rgba(127, 176, 105, 0.3);
        }

        .service-item i {
            font-size: 2.5rem;
            color: var(--primary-green);
            margin-bottom: 15px;
        }

        .contact-info {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .contact-info i {
            font-size: 2rem;
            color: var(--primary-green);
            margin-right: 15px;
        }

        .contact-item {
            margin: 25px 0;
            display: flex;
            align-items: center;
        }

        .modal-header {
            background: linear-gradient(90deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
            overflow: hidden;
        }

        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(127, 176, 105, 0.25);
        }

        .btn-primary-custom {
            background: linear-gradient(90deg, var(--primary-green) 0%, var(--dark-green) 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(127, 176, 105, 0.4);
        }

        .admin-link {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }

        .admin-link a {
            color: var(--brown);
            text-decoration: none;
            font-weight: 600;
        }

        .admin-link a:hover {
            color: var(--dark-green);
        }

        footer {
            background: linear-gradient(90deg, var(--dark-green) 0%, var(--primary-green) 100%);
            color: white;
            padding: 30px 0;
            margin-top: 0;
        }

        .paw-print {
            display: inline-block;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        #petfoods {
            background: linear-gradient(135deg, #fff 0%, var(--light-green) 100%);
        }

        #services {
            background: white;
        }

        #about {
            background: linear-gradient(135deg, var(--light-green) 0%, #fff 100%);
        }

        #contact {
            background: white;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#home">
                <img src="img/logo.jpg" alt="3Star & Sun Petshop Logo">
                <span>3STAR & SUN PETSHOP</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#petfoods">Pet Foods</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <form class="d-flex me-3" role="search">
                    <div class="input-group search-box">
                        <input type="text" class="form-control search-input" placeholder="Search products..." aria-label="Search">
                        <button class="btn btn-search" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <div class="d-flex">
                    <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                    <button class="btn btn-signup" data-bs-toggle="modal" data-bs-target="#signupModal">
                        <i class="fas fa-user-plus"></i> Sign Up
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <h1><span class="paw-print"></span> Welcome to 3Star & Sun Petshop</h1>
            <p>Your One-Stop Shop for All Your Pet's Needs</p>
            <a href="shop.php" class="btn btn-primary-custom btn-lg">
                <i class="fas fa-shopping-bag"></i> Shop Now
            </a>
            <button class="btn btn-primary-custom btn-lg ms-2" data-bs-toggle="modal" data-bs-target="#signupModal">
                Get Started Today <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </section>

    <!-- Pet Foods Section -->
    <section id="petfoods">
        <div class="container">
            <h2 class="section-title"> Premium Pet Foods</h2>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="product-card text-center">
                        <div class="product-icon"><i class="fas fa-dog"></i></div>
                        <h4>Dog Food</h4>
                        <p>Premium nutrition for your canine companion</p>
                        <a href="shop.php?search=dog%20food" class="btn btn-sm btn-primary-custom">Browse Now</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="product-card text-center">
                        <div class="product-icon"><i class="fas fa-cat"></i></div>
                        <h4>Cat Food</h4>
                        <p>Delicious meals for your feline friend</p>
                        <a href="shop.php?search=cat%20food" class="btn btn-sm btn-primary-custom">Browse Now</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="product-card text-center">
                        <div class="product-icon"><i class="fas fa-bone"></i></div>
                        <h4>Dog Accessories</h4>
                        <p>Collars, leashes, and toys for dogs</p>
                        <a href="shop.php?search=dog" class="btn btn-sm btn-primary-custom">Browse Now</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="product-card text-center">
                        <div class="product-icon"><i class="fas fa-paw"></i></div>
                        <h4>Cat Accessories</h4>
                        <p>Toys, beds, and supplies for cats</p>
                        <a href="shop.php?search=cat" class="btn btn-sm btn-primary-custom">Browse Now</a>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="shop.php" class="btn btn-primary-custom btn-lg">
                        <i class="fas fa-shopping-cart"></i> View All Products
                    </a>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon"><i class="fas fa-certificate"></i></div>
                        <h3>Certified Quality</h3>
                        <p>All our products meet international quality standards</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon"><i class="fas fa-leaf"></i></div>
                        <h3>Natural Ingredients</h3>
                        <p>Made with wholesome, natural ingredients</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon"><i class="fas fa-heart"></i></div>
                        <h3>Pet Approved</h3>
                        <p>Loved by pets, trusted by owners</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services">
        <div class="container">
            <h2 class="section-title"> Our Services</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="service-item">
                        <i class="fas fa-cut"></i>
                        <h4>Pet Grooming</h4>
                        <p>Professional grooming services including bathing, haircuts, nail trimming, and more to keep your pet looking and feeling their best.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item">
                        <i class="fas fa-stethoscope"></i>
                        <h4>Veterinary Care</h4>
                        <p>Comprehensive veterinary services with experienced professionals to ensure your pet's health and wellness.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item">
                        <i class="fas fa-syringe"></i>
                        <h4>Vaccination</h4>
                        <p>Keep your pets protected with our complete vaccination programs and health check-ups.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item">
                        <i class="fas fa-home"></i>
                        <h4>Pet Boarding</h4>
                        <p>Safe and comfortable boarding facilities for your pets when you're away. 24/7 care and supervision.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about">
        <div class="container">
            <h2 class="section-title"> About Us</h2>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="feature-card">
                        <h3><i class="fas fa-store"></i> Our Story</h3>
                        <p>3Star & Sun Petshop has been serving the community for years, providing quality pet products and services. We are passionate about animal welfare and committed to offering the best care for your beloved pets.</p>
                        <p>Our team of dedicated professionals is here to help you with all your pet care needs, from nutrition advice to grooming services.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card">
                        <h3><i class="fas fa-bullseye"></i> Our Mission</h3>
                        <p>To provide exceptional pet care products and services that enhance the lives of pets and their owners. We believe every pet deserves the best care, nutrition, and love.</p>
                        <h3 class="mt-4"><i class="fas fa-eye"></i> Our Vision</h3>
                        <p>To be the most trusted and preferred pet care destination, known for quality, expertise, and genuine care for animals.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <h2 class="section-title"> Contact Us</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-info">
                        <h3 class="mb-4" style="color: var(--dark-green);">Get In Touch</h3>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h5>Address</h5>
                                <p>123 Pet Street, Animal City, PC 12345</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <h5>Phone</h5>
                                <p>+63 123 456 7890</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h5>Email</h5>
                                <p>info@3starandsun.com</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h5>Business Hours</h5>
                                <p>Mon - Sat: 8:00 AM - 7:00 PM<br>Sunday: 9:00 AM - 5:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-info">
                        <h3 class="mb-4" style="color: var(--dark-green);">Send Us a Message</h3>
                        <form>
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Your Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Subject" required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" rows="4" placeholder="Your Message" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-100">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-sign-in-alt"></i> Customer Login</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="loginEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100">Login</button>
                        <div class="admin-link">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#adminModal" data-bs-dismiss="modal">
                                <i class="fas fa-user-shield"></i> Admin Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sign Up Modal -->
    <div class="modal fade" id="signupModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus"></i> Create Account</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="signup.php" method="POST">
                        <div class="mb-3">
                            <label for="signupName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="signupName" name="fullname" required>
                        </div>
                        <div class="mb-3">
                            <label for="signupEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="signupEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="signupPhone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="signupPhone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="signupPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="signupPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="signupConfirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="signupConfirmPassword" name="confirm_password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                            <label class="form-check-label" for="agreeTerms">I agree to the terms and conditions</label>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Login Modal -->
    <div class="modal fade" id="adminModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-shield"></i> Admin Login</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="admin_login.php" method="POST">
                        <div class="mb-3">
                            <label for="adminUsername" class="form-label">Admin Username</label>
                            <input type="text" class="form-control" id="adminUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="adminPassword" class="form-label">Admin Password</label>
                            <input type="password" class="form-control" id="adminPassword" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100">Admin Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; 2025 3Star & Sun Petshop. All rights reserved.</p>
            <p class="mb-0"><i class="fas fa-paw"></i> Caring for your pets with love <i class="fas fa-paw"></i></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>