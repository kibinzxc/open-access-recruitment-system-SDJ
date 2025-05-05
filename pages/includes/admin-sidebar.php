<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
    @font-face {
        font-family: 'Inter';
        src: url('assets/fonts/Inter.ttf') format('truetype');
    }

    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
    }

    .sidebar {
        width: 220px;
        height: 100vh;
        background-color: #FAFAFA;
        border-right: 1px solid #AEAEAE;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
    }

    .brand {
        text-align: center;
        padding-top: 10px;
        padding-right: 10px;

    }

    .brand img {
        width: 150px;
        margin: -20px 0;
    }

    .menu {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        padding: 0 10px;
        gap: 20px;
    }

    .menu a {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        color: #313638;
        text-decoration: none;
        font-size: 18px;
        font-weight: 500;
        border-radius: 5px;
    }

    .menu a img,
    .logout a img {
        width: 20px;
        margin-right: 12px;
    }

    .menu a:hover,
    .menu a.active,
    .logout a:hover,
    .logout a.active {
        background-color: #412BAD;
        color: #fff;
    }

    .logout {
        padding: 10px 10px;
    }

    .logout a {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        color: #313638;
        text-decoration: none;
        font-size: 18px;
        font-weight: 500;
        border-radius: 5px;
    }



    /* Mobile view (hide sidebar, show bottom nav) */
    .bottom-nav {
        display: none;
    }

    @media (max-width: 768px) {
        .sidebar {
            display: none;
        }

        .content {
            margin-left: 0;
        }

        .bottom-nav {
            display: flex;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #FFF;
            border-top: 1px solid #AEAEAE;
            z-index: 1000;
        }

        .bottom-nav-item {
            flex: 1;
            text-align: center;
            padding: 10px 0;
        }

        .bottom-nav-item a {
            text-decoration: none;
            color: #313638;
            font-size: 12px;
            font-weight: 500;
        }

        .bottom-nav-item img {
            width: 20px;
            height: 20px;
            margin-bottom: 5px;
        }

        .bottom-nav-item a.active {
            background-color: rgba(0, 0, 0, 0.08);
        }
    }
    </style>
</head>

<div class="sidebar">
    <div class="brand">
        <img src="../assets/images/sdj-icon2.svg" alt="Logo" />
    </div>

    <div class="menu" id="menu">
        <a href="dashboard.php"
            class="<?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>"
            onmouseover="this.querySelector('img').src='../assets/images/active-admin-dashboard.svg';"
            onmouseout="if (!this.classList.contains('active')) this.querySelector('img').src='../assets/images/admin-home.svg';">
            <img src="<?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? '../assets/images/active-admin-dashboard.svg' : '../assets/images/admin-home.svg'; ?>"
                alt="Dashboard Icon" />
            Dashboard
        </a>
        <a href="jobs.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'jobs.php' ? 'active' : ''; ?>"
            onmouseover="this.querySelector('img').src='../assets/images/active-admin-jobs.svg';"
            onmouseout="if (!this.classList.contains('active')) this.querySelector('img').src='../assets/images/admin-jobs.svg';">
            <img src="<?php echo basename($_SERVER['PHP_SELF']) === 'jobs.php' ? '../assets/images/active-admin-jobs.svg' : '../assets/images/admin-jobs.svg'; ?>"
                alt="Jobs Icon" />
            Jobs
        </a>
        <a href="inbox.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'inbox.php' ? 'active' : ''; ?>"
            onmouseover="this.querySelector('img').src='../assets/images/active-admin-inbox.svg';"
            onmouseout="if (!this.classList.contains('active')) this.querySelector('img').src='../assets/images/admin-inbox.svg';">
            <img src="<?php echo basename($_SERVER['PHP_SELF']) === 'inbox.php' ? '../assets/images/active-admin-inbox.svg' : '../assets/images/admin-inbox.svg'; ?>"
                alt="Inbox Icon" />
            Inbox
        </a>
        <a href="settings.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'active' : ''; ?>"
            onmouseover="this.querySelector('img').src='../assets/images/active-admin-settings.svg';"
            onmouseout="if (!this.classList.contains('active')) this.querySelector('img').src='../assets/images/admin-settings.svg';">
            <img src="<?php echo basename($_SERVER['PHP_SELF']) === 'settings.php' ? '../assets/images/active-admin-settings.svg' : '../assets/images/admin-settings.svg'; ?>"
                alt="Settings Icon" />
            Settings
        </a>
    </div>

    <div class="logout">
        <a href="logout.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'logout.php' ? 'active' : ''; ?>"
            onmouseover="this.querySelector('img').src='../assets/images/active-admin-logout.svg';"
            onmouseout="if (!this.classList.contains('active')) this.querySelector('img').src='../assets/images/admin-logout.svg';">
            <img src="<?php echo basename($_SERVER['PHP_SELF']) === 'logout.php' ? '../assets/images/active-admin-logout.svg' : '../assets/images/admin-logout.svg'; ?>"
                alt="Logout Icon" />
            Logout
        </a>
    </div>
</div>


<script>
document.querySelectorAll('.menu a, .logout a').forEach(link => {
    const currentPage = window.location.pathname.split('/').pop();

    if (link.getAttribute('href') === currentPage) {
        link.classList.add('active');
    }
    link.addEventListener('click', function() {
        document.querySelectorAll('.menu a, .logout a').forEach(item => item.classList.remove(
            'active'));
        this.classList.add('active');
    });
});
</script>