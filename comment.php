<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    $username = !empty($_POST['username']) ? $_POST['username'] : "Anonymous";
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO comments (post_id, username, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $post_id, $username, $content);
    $stmt->execute();
    $stmt->close();

    $comment_sql = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at ASC";
    $comment_result = $conn->query($comment_sql);

    if ($comment_result->num_rows > 0) {
        while ($comment = $comment_result->fetch_assoc()) {
            echo "<div class='comment'>";
            echo "<p><strong>" . htmlspecialchars($comment['username']) . ":</strong> " . htmlspecialchars($comment['content']) . "</p>";
            echo "<p class='comment-date'>" . $comment['created_at'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No comments yet. Be the first to comment!</p>";
    }
}
?>
