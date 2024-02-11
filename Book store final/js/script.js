var attempt = 3;

function validate() {
    var username = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    if (username === "admin@admin.com" && password === "admin@123") {
        alert("-----Success------Welcome Admin");
        // Redirecting to other page.
        localStorage.clear();
        window.location.assign('../pages/admin.html')
        return false;
    } else {
        attempt--;
        alert("Incorrect Credentials. You have " + attempt + " attempt(s) left.");

        if (attempt === 0) {
            disableForm();
        }
        return false;
    }
}

function disableForm() {
    document.getElementById("email").disabled = true;
    document.getElementById("password").disabled = true;
    document.getElementById("submit").disabled = true;
    alert("Account locked after 3 unsuccessful attempts.");
}

function toggleElementVisibility(elementId) {
    var x = document.getElementById(elementId);
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}

const hamburgerIcon = document.querySelector('.hamburger-icon');
const sideBar = document.querySelector('.side-bar');

hamburgerIcon.addEventListener('click', () => {
    sideBar.classList.toggle('active');
});
