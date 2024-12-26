$(document).ready(function() {
    // Price passed from PHP (dynamically inserted into the page)
    var price = window.price;  // Get price passed from PHP
    var $quantityInput = $('input[name="quantity"]');
    var $totalPrice = $('#totalPrice');

    // Function to update total price
    function updateTotalPrice() {
        var quantity = parseInt($quantityInput.val()); // Get the current quantity
        var total = price * quantity; // Calculate total price
        $totalPrice.text(total + ' Dt'); // Update the total price display
    }

    // Increase quantity when the "+" button is clicked
    $(".plus").click(function() {
        var currentQuantity = parseInt($quantityInput.val());
        $quantityInput.val(currentQuantity + 1); // Increase the value by 1
        updateTotalPrice(); // Update the total price
    });

    // Decrease quantity when the "-" button is clicked
    $(".minus").click(function() {
        var currentQuantity = parseInt($quantityInput.val());
        if (currentQuantity > 1) { // Prevent quantity from going below 1
            $quantityInput.val(currentQuantity - 1); // Decrease the value by 1
            updateTotalPrice(); // Update the total price
        }
    });

    // Update total price when quantity is manually changed
    $quantityInput.on('input', function() {
        updateTotalPrice(); // Update total price based on the input value
    });

    // Initial price update when the page loads
    updateTotalPrice();
});
