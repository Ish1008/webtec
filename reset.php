<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST["token"];
    $new_password = $_POST["password"];
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Verify token and get email
    $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($email);
        $stmt->fetch();

        // Update user password
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        if ($stmt->execute()) {
            echo "Password has been reset! <a href='login.php'>Login</a>";
        } else {
            echo "Error resetting password.";
        }

        // Delete token after use
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
    } else {
        echo "Invalid or expired token.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles3.css">
</head>
<body>
    <div class="login-box">
        <header>Reset Password</header>
        <form action="" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            <input type="password" name="password" class="input-field" placeholder="New Password" required>
            <button type="submit" class="submit-btn">Reset Password</button>
        </form>
    </div>
</body>
</html>
