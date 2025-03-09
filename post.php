<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $username = $_POST["username"];
    $content = $_POST["content"];

    $stmt = $conn->prepare("INSERT INTO posts (title, username, content) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $username, $content);
    $stmt->execute();
    $stmt->close();
}

// Fetch and return updated posts
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<div class='post'>";
    echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
    echo "<p>Posted by " . htmlspecialchars($row['username']) . " on " . $row['created_at'] . "</p>";
    echo "<p>" . htmlspecialchars($row['content']) . "</p>";
    echo "</div>";
}

$conn->close();
?>
