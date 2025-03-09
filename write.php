<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"]; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Page</title>
    <link rel="stylesheet" href="style5.css"> 
</head>
<body>
<header>
    <h1>CS1B Forum</h1>
    <nav>
        <button><a href="forum.php" class="home-button">Home</a></button>
        <button><a href="logout.php" class="logout-button">Logout</a></button>
    </nav>
</header>

<main>
    <section class="forum-container" id="forum-container">
        <?php
        $sql = "SELECT * FROM posts ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $post_id = $row['id'];
                echo "<div class='post'>";
                echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
                echo "<p>Posted by <strong>" . htmlspecialchars($row['username']) . "</strong> on " . $row['created_at'] . "</p>";
                echo "<p>" . htmlspecialchars($row['content']) . "</p>";

               
                $comment_sql = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at ASC";
                $comment_result = $conn->query($comment_sql);

                echo "<div class='comments-section' id='comments-$post_id'>";
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
                echo "</div>";

                
                echo "<form class='comment-form' data-post-id='$post_id'>";
                echo "<textarea class='comment-content' placeholder='Write a comment...' required></textarea>";
                echo "<button type='submit'>Comment</button>";
                echo "</form>";

                echo "</div>";
            }
        } else {
            echo "<p>No posts yet. Be the first to post!</p>";
        }
        ?>
    </section>

    <section class="new-post">
        <h2>Create a New Post</h2>
        <form id="post-form">
            <input type="text" id="title" name="title" placeholder="Title" required>
            <textarea id="content" name="content" placeholder="Write your post here..." required></textarea>
            <button type="submit">Post</button>
        </form>
    </section>
</main>

<script>
    document.getElementById("post-form").addEventListener("submit", function(event) {
        event.preventDefault(); 

        let title = document.getElementById("title").value;
        let content = document.getElementById("content").value;
        let username = "<?php echo htmlspecialchars($username); ?>"; 

        fetch("post.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "title=" + encodeURIComponent(title) + 
                  "&username=" + encodeURIComponent(username) + 
                  "&content=" + encodeURIComponent(content)
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("forum-container").innerHTML = data; 
            document.getElementById("post-form").reset(); 
        })
        .catch(error => console.error("Error:", error));
    });

    document.addEventListener("submit", function(event) {
        if (event.target.classList.contains("comment-form")) {
            event.preventDefault();

            let form = event.target;
            let postId = form.getAttribute("data-post-id");
            let content = form.querySelector(".comment-content").value;
            let username = "<?php echo htmlspecialchars($username); ?>"; 

            fetch("comment.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "post_id=" + encodeURIComponent(postId) +
                      "&username=" + encodeURIComponent(username) +
                      "&content=" + encodeURIComponent(content)
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById("comments-" + postId).innerHTML = data;
                form.reset();
            })
            .catch(error => console.error("Error:", error));
        }
    });
</script>
</body>
</html>
