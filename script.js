document.addEventListener("DOMContentLoaded", function () {
    console.log("TechHubStore initialized");

    const cartCountElement = document.getElementById('cart-count');
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            // Form submission is handled by the wrapping form element for cart, 
            // but if this was an AJAX button:
            // e.preventDefault();

            // Since the current implementation uses a form to POST to cart.php,
            // we should actually NOT prevent default if we want the PHP redirect to work.
            // However, the previous script had e.preventDefault(). 
            // Let's check Index.php. It has a form.
            // If we prevent default, the form won't submit.
            // But the user might want an AJAX experience? 
            // The PHP code redirects back.
            // Let's assume standard form submission is improved by the PHP.
            // But wait, the original script had e.preventDefault(). 
            // If I keep it, the form won't submit. 
            // I will comment out e.preventDefault() for the form to work, 
            // OR I implement AJAX. 
            // Given the complexity, I'll let the form submit naturally.
            // But the script adds 'Added' text.

            // Actually, looking at Index.php:
            // <form method='post' action='cart.php'> ... <button type='submit' ...>
            // So clicking submits the form.
            // If JS prevents default, it stops submission.
            // It seems the previous JS was half-baked demo code.
            // I will remove the preventDefault so the form actually works.
            // OR, if I want to keep the "Added" animation, I should handle it.
            // But the page reloads anyway.
            // Let's just fix the Password Toggle which is the requested implementation.
        });
    });

    // Password Toggle Functionality
    const toggleIcons = document.querySelectorAll('.password-toggle-icon');

    toggleIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            const formGroup = this.closest('.form-group');
            const passwordInput = formGroup.querySelector('input');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });
});

