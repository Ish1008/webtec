<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    echo "Hello, " . $name . "! Your request was received.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CS1B Forum</title> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>    
<nav class="navbar">
    <div class="logo">
        <a href="forum.php">CS1B Forum</a>
    </div>
    <button class="menu-toggle" id="menu-toggle">
        <i class="bx bx-menu"></i>
    </button>
    <ul class="nav-links" id="nav-links">
        <li><a href="forum.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="write.php">Get Started</a></li>
        <li><a href="account.php">Account</a></li>
        <?php if (isset($_SESSION["user_id"])): ?>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li> 
        <?php endif; ?>
    </ul>   
</nav>

<main class="content">
    <h1>WELCOME TO CS1B FORUM</h1>
    <hr color="maroon">
    <p>WHERE CONVERSATIONS COME ALIVE!</p>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById("menu-toggle").addEventListener("click", function () {
        document.getElementById("nav-links").classList.toggle("active");
    });
</script>
</body>
</html>