document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();  
    
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    if (username === '' || password === '') {
        document.getElementById('error-message').textContent = 'Both fields are required.';
        return;
    }
    const correctUsername = 'user';
    const correctPassword = 'password123';
    if (username === correctUsername && password === correctPassword) {
        alert('Login successful!');
        window.location.href = 'dashboard.html';  
    } else {
        document.getElementById('error-message').textContent = 'Invalid username or password.';
    }
});
