document.addEventListener("DOMContentLoaded", function () {
    const checkoutButton = document.querySelector("#checkoutButton");

    if (checkoutButton) {
        checkoutButton.addEventListener("click", function (e) {
            e.preventDefault();

            // Open the checkout page in a popup window
            const checkoutURL = checkoutButton.getAttribute("data-url");
            const popupWidth = 800;
            const popupHeight = 600;
            const popupX = (window.innerWidth - popupWidth) / 2;
            const popupY = (window.innerHeight - popupHeight) / 2;

            const popup = window.open(
                checkoutURL,
                "CheckoutWindow",
                `width=${popupWidth},height=${popupHeight},left=${popupX},top=${popupY},resizable=yes,scrollbars=yes`
            );

            // Focus the popup
            if (popup) {
                popup.focus();

                // When the popup closes, refresh the cart page
                const checkPopupClosed = setInterval(() => {
                    if (popup.closed) {
                        clearInterval(checkPopupClosed);
                        window.location.reload();
                    }
                }, 500);
            } else {
                alert("Please allow popups for this site to proceed with checkout.");
            }
        });
    }
});
