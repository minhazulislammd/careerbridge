document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form');
    const email = document.getElementById('email');
    const password = document.getElementById('password');

    function showError(input, message) {
        const inputBox = input.parentElement;
        inputBox.classList.add('error');
        inputBox.classList.remove('success');
        const small = inputBox.querySelector('small');
        small.innerText = message;
    }

    function showSuccess(input) {
        const inputBox = input.parentElement;
        inputBox.classList.add('success');
        inputBox.classList.remove('error');
        const small = inputBox.querySelector('small');
        small.innerText = '';
    }

    const isValidEmail = (email) => {
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailRegex.test(email);
      };

    function validateForm() {
        let valid = true;

        if (email.value.trim() === '') {
            showError(email, 'Email cannot be blank');
            valid = false;
        } else if (!isValidEmail(email.value.trim())) {
            showError(email, 'Email is invalid');
            valid = false;
        } else {
            showSuccess(email);
        }

        if (password.value.trim() === '') {
            showError(password, 'Password cannot be blank');
            valid = false;
        } else if (password.value.length < 8) {
            showError(password, 'Password must be at least 8 characters');
            valid = false;
        } else {
            showSuccess(password);
        }

        return valid;
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        if (validateForm()) {
            form.submit(); // Submit the form programmatically
        }
    });

    // Clear error messages on input change
    email.addEventListener('input', function() {
        if (email.value.trim() === '') {
            showError(email, 'Email cannot be blank');
        } else if (!isValidEmail(email.value.trim())) {
            showError(email, 'Email is invalid');
        } else {
            showSuccess(email);
        }
    });

    password.addEventListener('input', function() {
        if (password.value.trim() === '') {
            showError(password, 'Password cannot be blank');
        } else if (password.value.length < 8) {
            showError(password, 'Password must be at least 8 characters');
        } else {
            showSuccess(password);
        }
    });
});