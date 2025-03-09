<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        echo "A password reset link has been sent to your email.";
    } else {
        echo "Error: No account found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles3.css">
</head>
<body>
    <div class="login-box">
        <header>Forgot Password</header>
        <form action="" method="POST">
            <input type="email" name="email" class="input-field" placeholder="Enter your email" required>
            <button type="submit" class="submit-btn">Reset Password</button>
            <p><a href="login.php">Back to Login</a></p>
        </form>
    </div>
</body>
</html>
