<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan a Trip</title>
    <link rel="stylesheet" type="text/css" href="../../../public/css/layout.css">
    <link rel="stylesheet" type="text/css" href="../../../public/css/apartment.css">
    <link rel="stylesheet" type="text/css" href="../../../public/css/errors.css">
    <script src="../../../public/scripts/validation.js" defer></script>
    <script src="../../../public/scripts/reservations-script.js" defer></script>
    <script src="../../../public/scripts/apartment-script.js" defer></script>
    <script src="../../../public/scripts/mobile-nav.js" defer></script>
</head>

<body>
<header>
    <div class="top-nav">
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
        <form action="/logout" method="post">
            <button class="logout-btn">Logout</button>
        </form>
    </div>
    <nav>
        <div class="nav-toggle" id="nav-toggle">
            <!-- Hamburger Icon -->
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="/dashboard">Home Page</a>
            </li>
            <li>
                <a href="/reservations">Your trips</a>
            </li>
            <li>
                <a href="/profile">Profile</a>
            </li>
            <?php if (Application::isAdmin()): ?>
            <li>
                <a href='/apartments'>Admin Panel</a>
            </li>
            <?php endif ?>
        </ul>

    </nav>
</header>
<main>
    {{content}}
</main>
</body>
</html>