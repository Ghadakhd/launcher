<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Model/order.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/stripe_sdk/init.php'; 

use Stripe\Stripe;
use Stripe\Checkout\Session;

// Set Stripe API Key
$STRIPE_SECRET_KEY = 'sk_test_51QVdQKGk9bETGuu9hhj0ICOgnCBbq9iDTOc1bJ0Z7pgp563MiBPIpVuhcAfl4xJigYsGHhvEvy9qdRsYBu7Vevkw00Dmij1pEC';
Stripe::setApiKey($STRIPE_SECRET_KEY);

// Placeholder UserID
$placeholderUserID = 1;

// Check cart
if (empty($_SESSION['cart'])) {
    error_log("Cart is empty at checkout.");
    echo "<script>alert('Your cart is empty. Please add items to proceed.');</script>";
    exit;
}

try {
    $db = Database::getConnection();
    if (!$db) {
        throw new Exception("Failed to connect to the database.");
    }

    // Prepare Stripe Checkout
    $lineItems = [];
    $orderIDs = [];
    foreach ($_SESSION['cart'] as $productID => $item) {
        $quantity = $item['quantity'];
        $price = $item['price'];

        // Insert into database
        $query = $db->prepare("
            INSERT INTO `Order` 
            (`UserID`, `TotalAmount`, `Status`, `ordered_P_ID`) 
            VALUES (?, ?, ?, ?)
        ");
        $result = $query->execute([
            $placeholderUserID,
            $price * $quantity,
            'Pending Payment',
            $productID,
        ]);

        if (!$result) {
            throw new Exception("Failed to insert order: " . implode(", ", $query->errorInfo()));
        }

        $orderIDs[] = $db->lastInsertId();

        // Add to Stripe
        $lineItems[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => ['name' => $item['name']],
                'unit_amount' => $price * 100,
            ],
            'quantity' => $quantity,
        ];
    }

    $checkoutSession = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $lineItems,
        'mode' => 'payment',
        'success_url' => 'http://localhost/launcher/View/FrontOffice/shop/success.php?session_id={CHECKOUT_SESSION_ID}&order_ids=' . implode(',', $orderIDs),
        'cancel_url' => 'http://localhost/launcher/View/FrontOffice/shop/cart.php',
    ]);

    header('Location: ' . $checkoutSession->url);
    exit;
} catch (Exception $e) {
    error_log("Checkout error: " . $e->getMessage());
    echo "<script>alert('There was an issue processing your payment: {$e->getMessage()}');</script>";
    exit;
}
?>
