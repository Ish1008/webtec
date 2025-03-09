<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$bio = trim($_POST['bio']);
$password = trim($_POST['password']);

if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE users SET bio = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $bio, $hashed_password, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET bio = ? WHERE id = ?");
    $stmt->bind_param("si", $bio, $user_id);
}

if ($stmt->execute()) {
    echo "Profile updated!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
