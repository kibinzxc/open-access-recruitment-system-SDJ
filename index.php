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
<?php
include('pages/includes/dreamy-stars2.php');
?>

<body>
    <div class="login-container">
        <img src="pages/assets/images/sdj-icon.png" alt="">
        <form action="pages/assets/php/admin/login.php" method="POST" class="login-form">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <a class="forgot-password" href="#">Forgot Password?</a>
            <button type="submit">Sign in</button>
        </form>

    </div>

</body>

</html>