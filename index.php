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
<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 30px;
    border-radius: 8px;
    width: 90%;
    max-width: 400px;
    position: relative;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.form-group {
    margin-bottom: 20px;
}

.form-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

.message {
    position: absolute;
    top: 20px;
    right: 20px;
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px 15px;
    border-radius: 4px;
    z-index: 9999;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    max-width: 250px;
    font-size: 14px;
    animation: fadeIn 0.3s ease-in-out;

}

.message:empty {
    display: none;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}


.success {
    background-color: #d4edda;
    color: #155724;
}

.error {
    background-color: #f8d7da;
    color: #721c24;
}

/* Updated Button Styles */
.button-group {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.button-group button {
    flex: 1 1 0;
    /* Equal flex basis */
    min-width: 0;
    /* Allow buttons to shrink equally */
    padding: 12px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
    text-align: center;
    white-space: nowrap;
}

.submit-btn {
    background-color: #4a6fa5;
    color: white;
}

.cancel-btn {
    background-color: #f1f1f1;
    color: #333;
}

.submit-btn:hover {
    background-color: #3a5a8a;
}

.cancel-btn:hover {
    background-color: #e1e1e1;
}


@media screen and (max-width: 768px) {

    .modal {
        padding: 20px;
        box-sizing: border-box;
    }

    .modal-content {
        width: 90%;
        margin: 5% auto;
        padding: 20px;
        margin: 20% auto;
    }

    .form-group input {
        font-size: 14px;
    }

    .message {
        font-size: 14px;
        padding: 8px 12px;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    .button-group button {
        font-size: 14px;
        padding: 10px;
    }
}
</style>

<body>

    <?php include 'pages/includes/dreamy-stars-admin.php'; ?>
    <?php
    if (isset($_GET['success'])) {
        echo '<div class="alert alert-success" id="alert-message">' . htmlspecialchars($_GET['success']) . '</div>';
    }

    if (isset($_GET['error'])) {
        echo '<div class="alert alert-danger" id="alert-message">' . htmlspecialchars($_GET['error']) . '</div>';
    }
    ?>
    <div id="resetMessage" class="message"></div>
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

    <!-- Forgot Password Modal -->
    <div id="forgotPasswordModal" class="modal">
        <div class="modal-content">
            <h2>Reset Password</h2>
            <p>Enter your email address to receive a temporary password</p>
            <form id="forgotPasswordForm">
                <div class="form-group">
                    <input type="email" id="resetEmail" name="email" placeholder="Your email address" required>
                </div>
                <div class="button-group">
                    <button type="button" class="cancel-btn">Cancel</button>
                    <button type="submit" class="submit-btn">Reset Password</button>
                </div>
            </form>

        </div>
    </div>
    <script>
    // Forgot Password Functionality
    document.querySelector('.forgot-password').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('forgotPasswordModal').style.display = 'block';
        document.getElementById('resetEmail').focus();
    });

    // Close modal handlers
    document.querySelector('.cancel-btn').addEventListener('click', closeModal);

    function closeModal() {
        document.getElementById('forgotPasswordModal').style.display = 'none';
        document.getElementById('resetMessage').innerHTML = '';
        document.getElementById('resetEmail').value = '';
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('forgotPasswordModal')) {
            closeModal();
        }
    });

    document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('resetEmail').value;
        const messageContainer = document.getElementById('resetMessage');

        // Simple email validation
        if (!email.includes('@') || !email.includes('.')) {
            messageContainer.innerHTML = 'Please enter a valid email address';
            messageContainer.className = 'message error';
            return;
        }

        // Disable button during request
        const submitBtn = document.querySelector('.submit-btn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';

        // Send request to server
        fetch('pages/forgot-password.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `email=${encodeURIComponent(email)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal(); // Hide modal immediately

                    // Show success message outside
                    const globalMessage = document.getElementById('resetMessage');
                    globalMessage.innerHTML = 'Password reset successfully. Kindly check your email.';
                    globalMessage.className = 'message success';

                    // setTimeout(() => {
                    //     globalMessage.innerHTML = '';
                    //     globalMessage.className = 'message';
                    // }, 5000);
                } else {
                    messageContainer.innerHTML = data.message ||
                        'Error sending password reset. Please try again.';
                    messageContainer.className = 'message error';

                    // setTimeout(() => {
                    //     messageContainer.innerHTML = '';
                    //     messageContainer.className = 'message';
                    // }, 5000);
                }
            })
            .catch(error => {
                messageContainer.innerHTML = 'Network error. Please try again.';
                messageContainer.className = 'message error';
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Reset Password';
            });
    });
    </script>
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