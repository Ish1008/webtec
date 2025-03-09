<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Center</title>
    <link rel="stylesheet" href="style6.css">
</head>
<body>
    <div class="account-container">
        <p class="welcome-text">Welcome, <?php echo htmlspecialchars($username); ?></p>

        <h1><?php echo htmlspecialchars($username); ?></h1>
        <p class="email"><?php echo htmlspecialchars($email); ?></p>

        <form action="update_account.php" method="POST">
            <label for="password">New Password:</label>
            <input type="password" name="password" placeholder="Enter new password">

            <button type="submit">Update Password</button>
        </form>

        <a href="logout.php" class="logout-link">Logout</a>
    </div>
</body>
</html>
