<?php
require_once '../../../Model/cartmodel.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-hexashop.css">
</head>
<body>
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
                            <li><a href="cart.php" class="active"><i class="fa fa-shopping-cart"></i> View Cart</a></li>
                        </ul>
                        <a class="menu-trigger"><span>Menu</span></a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Cart Section -->
    <section class="section" id="cart">
        <div class="container">
            <h3 class="text-center mb-4">Your Shopping Cart</h3>

            <?php if (!empty($cartItems)): ?>
                <form method="POST" action="cart.php">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $productID => $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td>
                                        <img src="assets/images/<?php echo htmlspecialchars($item['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                             style="width: 80px;">
                                    </td>
                                    <td><?php echo htmlspecialchars($item['price']); ?> Dt</td>
                                    <td>
                                        <input type="number" name="quantities[<?php echo $productID; ?>]" 
                                               value="<?php echo htmlspecialchars($item['quantity']); ?>" 
                                               min="1" class="form-control">
                                    </td>
                                    <td><?php echo $item['price'] * $item['quantity']; ?> Dt</td>
                                    <td>
                                        <button type="submit" name="removeItem" value="<?php echo $productID; ?>" class="btn btn-danger btn-sm">Remove</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="text-end">
                        <h4>Total: <?php echo $totalCost; ?> Dt</h4>
                        <button type="submit" name="updateCart" class="btn btn-primary">Update Cart</button>
                        <button type="submit" name="clearCart" class="btn btn-warning">Clear Cart</button>
                        <!-- Stripe Checkout button -->
                        <a href="checkout.php" id="checkoutButton" data-url="checkout.php" class="btn btn-success">Proceed to Checkout</a>
                    </div>
                </form>
            <?php else: ?>
                <p class="text-center">Your cart is empty. <a href="index.php">Continue shopping</a></p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="text-center">Copyright © 2024 Tuniverse Co., Ltd.</p>
        </div>
    </footer>
    <script src="../../../assets/js/popupCheckout.js"></script>
</body>
</html>
