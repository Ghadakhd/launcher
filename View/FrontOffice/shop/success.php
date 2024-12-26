<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/stripe_sdk/init.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

// Set your Stripe Secret Key
$STRIPE_SECRET_KEY = 'sk_test_51QVdQKGk9bETGuu9hhj0ICOgnCBbq9iDTOc1bJ0Z7pgp563MiBPIpVuhcAfl4xJigYsGHhvEvy9qdRsYBu7Vevkw00Dmij1pEC';
Stripe::setApiKey($STRIPE_SECRET_KEY);

// Get `order_ids` and `session_id` from the URL
$orderIDs = isset($_GET['order_ids']) ? explode(',', $_GET['order_ids']) : [];
$sessionID = isset($_GET['session_id']) ? $_GET['session_id'] : '';

if (empty($orderIDs) || empty($sessionID)) {
    echo "<script>alert('Invalid payment session.'); window.close();</script>";
    exit;
}

try {
    // Retrieve the Stripe Checkout Session
    $checkoutSession = Session::retrieve($sessionID);

    // Verify the payment status
    if ($checkoutSession && $checkoutSession->payment_status === 'paid') {
        // Payment successful - Update the order status
        $db = Database::getConnection();
        foreach ($orderIDs as $orderID) {
            $query = $db->prepare("UPDATE `Order` SET `Status` = 'Not Approved' WHERE `OrderID` = ?");
            $query->execute([$orderID]);
        }

        // Clear the cart
        $_SESSION['cart'] = [];

        // Notify the user and close the popup
        echo "
        <script>
            alert('Payment successful! Your orders have been updated.');
            window.opener.location.reload(); // Refresh the parent window
            window.close(); // Close the popup
        </script>";
    } else {
        // Payment not successful
        echo "
        <script>
            alert('Payment verification failed. Please try again.');
            window.close();
        </script>";
    }
} catch (Exception $e) {
    error_log("Payment verification failed: " . $e->getMessage());
    echo "
    <script>
        alert('There was an issue finalizing your order. Please contact support.');
        window.close();
    </script>";
}
?>
