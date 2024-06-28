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

</head>

<body>
<header>
    <nav>
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
        <ul class="nav-links">
            <li>
                <a href="/dashboard">Home Page</a>
            </li>
            <li>
                <a href="">Recommendations</a>
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
        <form action="/logout" method="post">
            <button class="logout-btn">Logout</button>
        </form>
    </nav>
</header>
<main>
    {{content}}
</main>
</body>
</html>