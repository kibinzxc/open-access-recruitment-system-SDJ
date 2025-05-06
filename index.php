<?php
session_start();
include 'pages/includes/db-connection.php';
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sweet Dream Job - Your dream job awaits!">
    <meta name="keywords" content="job, career, dream job, employment, opportunities">
    <link rel="icon" href="pages/assets/images/icon.svg" type="image/x-icon">
    <title>Admin | Sweet Dream Job</title>
    <link rel="stylesheet" href="pages/admin/styles/login.css">
</head>

<body>
    <?php include 'pages/includes/dreamy-stars-admin.php'; ?>
    <div class="note">Rotate your device for the best experience!</div>
    <div class="login-container">
        <img src="pages/assets/images/sdj-icon.png" alt="">
        <div id="loginMessageContainer"></div>
        <form action="pages/admin/login-handler.php" id="loginForm" method="POST" class="login-form">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <a class="forgot-password" href="#">Forgot Password?</a>
            <button type="submit">Sign In</button>
        </form>
    </div>

</body>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault(); // prevent page reload

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    fetch('pages/admin/login-handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                const container = document.getElementById('loginMessageContainer');
                container.innerHTML = `<p class="error-message">${data.message}</p>`;

                setTimeout(() => {
                    container.innerHTML = '';
                }, 5000);
            }
        })
        .catch(err => {
            console.error('Login request failed', err);
        });
});
</script>


</html>