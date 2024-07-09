// document.getElementById('registrationForm').addEventListener('submit', function(event) {
//     event.preventDefault(); // Prevent the form from submitting normally

//     var email = document.getElementById('email').value;
//     var password = document.getElementById('password').value;
//     var cpassword=document.getElementById('cpassword').value;

//     if (!validateEmail(email)) {
//         alert('Please enter a valid email address');
//         return;
//     }
//     if(password!==cpassword){
//         alert("Password is not same");
//         return;
//     }

//     // Check if email already exists in local storage
//     if (localStorage.getItem(email)) {
//         alert('Email already exists. Please use a different one.');
//         return;
//     }

//     // Store email and password in local storage
//     localStorage.setItem(email, password);

//     // Redirect to index.html
//     // window.location.href = '../index.html';
// });

// function validateEmail(email) {
//     const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//     return re.test(email);
// }

