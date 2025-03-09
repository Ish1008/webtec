document.getElementById('signupForm').addEventListener('submit', function(event) {
    event.preventDefault();  
    
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (username === '' || email === '' || password === '' || confirmPassword === '') {
        document.getElementById('error-message').textContent = 'All fields are required.';
        return;
    }
    if (password !== confirmPassword) {
        document.getElementById('error-message').textContent = 'Passwords do not match.';
        return;
    }
    if (password.length < 6) {
        document.getElementById('error-message').textContent = 'Password must be at least 6 characters long.';
        return;
    }
    alert('Sign Up Successful!');
});
