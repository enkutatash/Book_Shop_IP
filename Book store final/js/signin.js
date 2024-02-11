document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    var storedPassword = localStorage.getItem(email);

    if (storedPassword && storedPassword === password) {
        alert('Login successful!');

        // Redirect based on email
        if (email === 'admin@admin.com') {
            // Redirect to admin page
            window.location.href = './admin.html';
        } else {
            // Redirect to index page
            window.location.href = '../index.html';
        }
    } else {
        alert('Invalid email or password. Please try again.');
    }
});