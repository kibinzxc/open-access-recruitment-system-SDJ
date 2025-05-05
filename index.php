<?php
session_start();
include 'pages/includes/db-connection.php';
include('pages/includes/dreamy-stars-admin.php');
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
    <?php

    ?>

    <div class="login-container">
        <img src="pages/assets/images/sdj-icon.png" alt="">

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            $query = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);

                if (md5($password) === $user['password']) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    header('Location: pages/admin/dashboard.php');
                    exit;
                } else {
                    echo "<p class='error-message'>Invalid account credentials: {$email} {$password}</p>";
                }
            } else {
                echo "<p class='error-message'>Invalid account credentials</p>";
            }
        }
        ?>
        <form action="" method="POST" class="login-form">
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
//timer for error-message #
setTimeout(function() {
    var errorMessage = document.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.style.display = 'none';
        errorMessage.classList.add('hidden');
    }
}, 5000);
</script>

</html>