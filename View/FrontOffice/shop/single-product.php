<?php
session_start();

require_once '../../../controller/ProductController.php';

// Get the Product ID from the URL
$productID = isset($_GET['id']) ? intval($_GET['id']) : 0;

$productController = new ProductController();
$product = $productController->getProductById($productID);

// If product is not found, redirect to 404 page
if (!$product) {
    header('Location: 404.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo htmlspecialchars($product['Name']); ?> - Product Details</title>
    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-hexashop.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
</head>

<body>
    <!-- Preloader (Optional, you can remove if unnecessary) -->

    <!-- Header -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <a href="index.php" class="logo">
                            <img src="assets/images/logo.png" alt="HexaShop Logo">
                        </a>
                        <ul class="nav">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="cart.php"><i class="fa fa-shopping-cart"></i> View Cart</a></li>
                        </ul>
                        <a class="menu-trigger"><span>Menu</span></a>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    
    <!-- ***** Main Banner Area Start ***** -->
    <div class="page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2><?php echo htmlspecialchars($product['Name']); ?> - Product Details</h2>
                        <span>Finish Your Order</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- Product Details Section -->
    <section class="section" id="product">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="left-images">
                        <img src="assets/images/<?php echo htmlspecialchars($product['Image']); ?>" alt="<?php echo htmlspecialchars($product['Name']); ?>">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-content">
                    <br><br><br>
                        <h4><?php echo htmlspecialchars($product['Name']); ?></h4>
                        <span class="price"><?php echo htmlspecialchars($product['Price']); ?> Dt</span>
                        <ul class="stars">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                        </ul>

                        <!-- Quantity Selector -->
                        <div class="quantity-content">
                            <div class="left-content">
                                <h6>No. of Orders</h6>
                            </div>
                            <div class="right-content">
                                <div class="quantity buttons_added">
                                    <input type="button" value="-" class="minus">
                                    <input type="number" step="1" min="1" name="quantity" value="1" class="input-text qty text" size="4">
                                    <input type="button" value="+" class="plus">
                                </div>
                            </div>
                        </div>

                        <!-- Total Price -->
                        <div class="total">
                            <h4>Total: <span id="totalPrice"><?php echo htmlspecialchars($product['Price']); ?> Dt</span></h4>
                            <div class="main-border-button">
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="productID" value="<?php echo $product['ProductID']; ?>">
                                <input type="hidden" name="name" value="<?php echo htmlspecialchars($product['Name']); ?>">
                                <input type="hidden" name="price" value="<?php echo htmlspecialchars($product['Price']); ?>">
                                <input type="hidden" name="image" value="<?php echo htmlspecialchars($product['Image']); ?>">
                                <input type="number" name="quantity" value="1" min="1" max="100" class="form-control w-25" id="quantityInput">
                                <button type="submit" name="addToCart" class="btn btn-primary mt-3">Add to Cart</button>
                            </form>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="under-footer">
                        <p>Copyright © 2024 Tuniverse Co., Ltd. All Rights Reserved.</p>
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/custom.js"></script>

    <!-- Pass PHP variable to JS -->
    <script>
        window.price = <?php echo htmlspecialchars($product['Price']); ?>; // Passing PHP price to JS
    </script>

    <!-- Include the external JS file for quantity handling -->
    <script src="assets/js/Qprice.js"></script>

</body>

</html>
