

document.addEventListener('DOMContentLoaded', function() {

    function showRegisterForm() {
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');

        if (loginForm && registerForm) {
            loginForm.classList.remove('active');
            registerForm.classList.add('active');
            history.pushState(null, null, 'register');
        }
    }

    function showLoginForm() {
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');

        if (loginForm && registerForm) {
            registerForm.classList.remove('active');
            loginForm.classList.add('active');
            history.pushState(null, null, 'login');
        }
    }

    // Dodanie event listenerów tylko jeśli elementy istnieją
    const showRegister = document.getElementById('show-register');
    const showLogin = document.getElementById('show-login');

    if (showRegister) {
        showRegister.addEventListener('click', function (event) {
            event.preventDefault();
            showRegisterForm();
        });
    }

    if (showLogin) {
        showLogin.addEventListener('click', function (event) {
            event.preventDefault();
            showLoginForm();
        });
    }

    // Sprawdzanie ścieżki URL tylko jeśli formularze istnieją
    const path = window.location.pathname;
    if (document.getElementById('register-form') && path.endsWith('/register')) {
        showRegisterForm();
    } else if (document.getElementById('login-form') && path.endsWith('/login')) {
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
                            clearErrors(this);
                            if (data.redirectUrl) {
                                window.location.href = data.redirectUrl;
                            } else {
                                window.location.reload()
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

function clearErrors(form) {
    // Usuń wszystkie komunikaty o błędach
    form.querySelectorAll('.error-message').forEach(el => el.remove());
    // Usuń klasę błędu z pól formularza
    form.querySelectorAll('.error-border').forEach(el => el.classList.remove('error-border'));
}
