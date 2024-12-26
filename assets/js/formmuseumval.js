document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('museumForm');
    const imageInput = document.getElementById('image');

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
        } else if (id === 'description') {
            if (!value) {
                showError(input, 'Description is required.');
                isValid = false;
            } else {
                showSuccess(input);
            }
        } else if (id === 'location') {
            if (!value) {
                showError(input, 'Location is required.');
                isValid = false;
            } else {
                showSuccess(input);
            }
        } else if (id === 'image') {
            if (!imageInput.files[0]) {
                showError(imageInput, 'An image must be uploaded.');
                isValid = false;
            } else {
                showSuccess(imageInput);
            }
        }

        return isValid;
    }

    const inputs = document.querySelectorAll('#museumForm input, #museumForm textarea');
    inputs.forEach(input => {
        input.addEventListener('input', () => validateInput(input));
        input.addEventListener('change', () => validateInput(input));
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