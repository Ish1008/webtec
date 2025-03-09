document.addEventListener("DOMContentLoaded", function () {
    loadPosts(); 
});

document.getElementById("postForm").addEventListener("submit", function (event) {
    event.preventDefault();

    let title = document.getElementById("title").value;
    let content = document.getElementById("content").value;

    if (title.trim() === "" || content.trim() === "") {
        alert("Please fill in all fields.");
        return;
    }

    let newPost = {
        title: title,
        content: content,
        date: new Date().toLocaleString()
    };

    savePost(newPost);
    addPostToPage(newPost);

    document.getElementById("postForm").reset();
});


function addPostToPage(post) {
    let postContainer = document.querySelector(".forum-container");

    let newPost = document.createElement("div");
    newPost.classList.add("post");

    newPost.innerHTML = `
        <h2>${post.title}</h2>
        <p>Posted on ${post.date}</p>
        <p>${post.content}</p>
    `;

    postContainer.appendChild(newPost);
}


function savePost(post) {
    let posts = JSON.parse(localStorage.getItem("forumPosts")) || [];
    posts.push(post);
    localStorage.setItem("forumPosts", JSON.stringify(posts));
}


function loadPosts() {
    let posts = JSON.parse(localStorage.getItem("forumPosts")) || [];
    posts.forEach(addPostToPage);
}
