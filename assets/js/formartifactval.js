document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('createArtifactForm');
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

        if (id === 'Name') {
            if (!value) {
                showError(input, 'Name is required.');
                isValid = false;
            } else {
                showSuccess(input);
            }
        } else if (id === 'Type') {
            if (!value) {
                showError(input, 'Type is required.');
                isValid = false;
            } else {
                showSuccess(input);
            }
        } else if (id === 'Era') {
            if (!value) {
                showError(input, 'Era is required.');
                isValid = false;
            } else {
                showSuccess(input);
            }
        } else if (id === 'MuseumID') {
            if (!value) {
                showError(input, 'Museum ID is required.');
                isValid = false;
            } else if (isNaN(value) || value <= 0) {
                showError(input, 'Museum ID must be a positive number.');
                isValid = false;
            } else {
                showSuccess(input);
            }
        } else if (id === 'Description') {
            if (!value) {
                showError(input, 'Description is required.');
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

    // Function to validate that all required fields are filled (none are empty)
    function validateAllFieldsNotEmpty() {
        const inputs = document.querySelectorAll('#createArtifactForm input, #createArtifactForm textarea');
        let allFieldsFilled = true;

        inputs.forEach(input => {
            const value = input.value.trim();
            // Skip the check for file input, it's handled separately
            if (input.type !== 'file' && !value) {
                allFieldsFilled = false;
            }
        });

        // Check if the image input has a file selected
        if (!imageInput.files[0]) {
            allFieldsFilled = false;
        }

        return allFieldsFilled;
    }

    const inputs = document.querySelectorAll('#createArtifactForm input, #createArtifactForm textarea');
    inputs.forEach(input => {
        input.addEventListener('input', () => validateInput(input));
        input.addEventListener('change', () => validateInput(input));
    });

    form.addEventListener('submit', event => {
        let formIsValid = true;

        // Run validation on all fields
        inputs.forEach(input => {
            if (!validateInput(input)) {
                formIsValid = false;
            }
        });

        // Ensure that all required fields are filled (none empty)
        if (!validateAllFieldsNotEmpty()) {
            formIsValid = false;
            alert('Please fill in all fields before submitting.');
        }

        // If form is not valid, prevent submission
        if (!formIsValid) {
            event.preventDefault();
        }
    });
});
