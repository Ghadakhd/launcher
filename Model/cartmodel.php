<?php
session_start();

// Include the controller directly


// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addToCart'])) {
        $productID = intval($_POST['productID']);
        $name = $_POST['name'];
        $price = floatval($_POST['price']);
        $image = $_POST['image'];
        $quantity = intval($_POST['quantity']);

        if (isset($_SESSION['cart'][$productID])) {
            $_SESSION['cart'][$productID]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productID] = [
                'name' => $name,
                'price' => $price,
                'image' => $image,
                'quantity' => $quantity,
            ];
        }
    }

    // Update cart quantities
    if (isset($_POST['updateCart'])) {
        foreach ($_POST['quantities'] as $productID => $quantity) {
            if ($quantity > 0) {
                $_SESSION['cart'][$productID]['quantity'] = intval($quantity);
            } else {
                unset($_SESSION['cart'][$productID]); // Remove item if quantity is 0
            }
        }
    }

    // Clear the cart
    if (isset($_POST['clearCart'])) {
        $_SESSION['cart'] = [];
    }

    // Remove a single item
    if (isset($_POST['removeItem'])) {
        $productID = intval($_POST['removeItem']);
        unset($_SESSION['cart'][$productID]);
    }
}

// Calculate total cost
$totalCost = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalCost += $item['price'] * $item['quantity'];
}

// Get cart items
$cartItems = $_SESSION['cart'];
?>