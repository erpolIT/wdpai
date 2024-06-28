

document.addEventListener('DOMContentLoaded', function() {

    function showRegisterForm() {
        document.getElementById('login-form').classList.remove('active');
        document.getElementById('register-form').classList.add('active');
        history.pushState(null, null, 'register');
    }

    function showLoginForm() {
        document.getElementById('register-form').classList.remove('active');
        document.getElementById('login-form').classList.add('active');
        history.pushState(null, null, 'login');
    }

    document.getElementById('show-register').addEventListener('click', function (event) {
        event.preventDefault();
        showRegisterForm();
    });

    document.getElementById('show-login').addEventListener('click', function (event) {
        event.preventDefault();
        showLoginForm();
    });

    if (window.location.pathname.endsWith('/register')) {
        showRegisterForm();
    } else if (window.location.pathname.endsWith('/login')) {
        showLoginForm();
    }
});



document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(event) {
            if (this.getAttribute('method').toLowerCase() === 'post') {
                event.preventDefault();

                const formData = new FormData(this);
                const action = this.getAttribute('action');

                fetch(action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            if (data.redirectUrl) {
                                window.location.href = data.redirectUrl;
                            } else {
                                console.log('Form submitted successfully');
                            }
                        } else {
                            displayErrors(this, data.errors);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
    });
});




function displayErrors(form, errors) {
    // Clear previous errors
    form.querySelectorAll('.error-message').forEach(el => el.remove());
    form.querySelectorAll('.error-border').forEach(el => el.classList.remove('error-border'));

    // Display new errors
    for (const [field, messages] of Object.entries(errors)) {
        const inputElement = form.querySelector(`[name="${field}"]`);
        if (inputElement) {
            const errorElement = document.createElement('div');
            errorElement.classList.add('error-message');
            errorElement.innerText = messages[0];
            inputElement.classList.add('error-border');

            // Insert error message after the input element
            inputElement.insertAdjacentElement('afterend', errorElement);
        }
    }
}
