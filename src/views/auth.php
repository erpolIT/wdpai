<div id="login-form" class="form-section active">
    <h1>Easy Travel</h1>
    <p>Welcome back! Please enter your details.</p>
    <form id="loginForm" action="/login" method="post">
        <div>
            <label for="email">Email</label>
            <input type="text" id="email-login" name="email" placeholder="Enter your email">
        </div>
        <div>
            <label for="password-login">Password</label>
            <input type="password" id="password-login" name="password" placeholder="Enter your password"
                   autocomplete="off">
        </div>
        <div class="options">
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
            <a href="#">Forgot password</a>
        </div>
        <button type="submit">Sign in</button>
    </form>
    <p class="signup">Don't have an account? <a href="#" id="show-register"><br>Sign up for free!</a></p>
</div>

<div id="register-form" class="form-section">
    <h1>Easy Travel</h1>
    <p>Create an account</p>
    <form id="registerForm" action="/register" method="post">
        <div>
            <label for="username-register">Username</label>
            <input type="text" id="username-register" name="username" placeholder="Enter your username">
        </div>
        <div>
            <label for="email-register">Email</label>
            <input type="text" id="email-register" name="email" placeholder="Enter your email">
        </div>
        <div>
            <label for="password-register">Password</label>
            <input type="password" id="password-register" name="password" placeholder="Enter your password"
                   autocomplete="off">
        </div>
        <div>
            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password"
                   autocomplete="off">
        </div>
        <div class="options">
            <label>
                <input type="checkbox" name="terms"> By creating an account, you agree to the Terms of use and Privacy
                Policy.
            </label>
        </div>
        <button type="submit">Create an account</button>
    </form>
    <p class="signup">Already have an account? <a href="#" id="show-login">Sign in here!</a></p>
</div>

