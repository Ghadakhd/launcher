document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('productForm');
    const imageInput = document.getElementById('imageInput');


    function showError(input, message) {
        const errorSpan = input.closest('.form-group').querySelector('.error');
        errorSpan.textContent = message;
        input.style.borderColor = 'red';
    }

    function showSuccess(input) {
        const errorSpan = input.closest('.form-group').querySelector('.error');
        errorSpan.textContent = '';
        input.style.borderColor = 'green';
    }

    function validateInput(input) {
        const id = input.id;
        const value = input.value.trim();
        let isValid = true;

        if (id === 'name') {
            if (!value) {
                showError(input, 'Name is required.');
                isValid = false;
            } else {
                showSuccess(input);
            }
        } else if (id === 'price') {
            if (!value || isNaN(value) || parseFloat(value) <= 0) {
                showError(input, 'Enter a valid positive number for price.');
                isValid = false;
            } else {
                showSuccess(input);
            }
        } else if (id === 'stock') {
            if (!value || isNaN(value) || parseInt(value) < 0 || !Number.isInteger(parseFloat(value))) {
                showError(input, 'Stock must be a non-negative integer.');
                isValid = false;
            } else {
                showSuccess(input);
            }
        } else if (id === 'type') {
            if (!value) {
                showError(input, 'Please select a type.');
                isValid = false;
            } else {
                showSuccess(input);
            }
        } else if (id === 'imageInput') {
            if (!imageInput.files[0]) {
                showError(imageInput, 'An image must be uploaded.');
                isValid = false;
            } else {
                showSuccess(imageInput);
            }
        }

        return isValid;
    }

    const inputs = document.querySelectorAll('#productForm input, #productForm select');
    inputs.forEach(input => {
        input.addEventListener('input', () => validateInput(input));
        input.addEventListener('change', () => validateInput(input)); // For file and select elements
    });

    form.addEventListener('submit', event => {
        let formIsValid = true;

        inputs.forEach(input => {
            if (!validateInput(input)) {
                formIsValid = false;
            }
        });

        if (!formIsValid) {
            event.preventDefault();
        }
    });
});
