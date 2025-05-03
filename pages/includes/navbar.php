<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    @font-face {
        font-family: 'Inter';
        src: url('assets/fonts/Inter.ttf') format('truetype');
    }

    body {
        margin: 0;
    }

    /* Navbar styles */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #FFF;
        color: #313638;
        padding: 5px 20px;
        border-bottom: 1px solid #AEAEAE;
    }

    .navbar>.brand img {
        width: 150px;
    }



    .navbar>.menu a {
        color: #313638;
        text-decoration: none;
        margin: 0 40px;
        padding: 0 15px;
        font-size: 22px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        position: relative;
        /* Required for the ::after pseudo-element */
        padding-bottom: 10px;
        transition: color 0.3s ease;
    }

    .navbar>.menu a::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        width: 0;
        /* Initially, the line is hidden */
        height: 3px;
        /* Border thickness */
        background-color: #FF8FE3;
        /* Default hover color */
        transition: width 0.3s ease, left 0.3s ease;
        /* Animate width and position */
    }

    .navbar>.menu a:hover::after {
        width: 100%;
        /* Expand to full width */
        left: 0;
        /* Align to the left */
    }

    .navbar>.menu a.active::after {
        width: 100%;
        /* Keep the line full width for active links */
        left: 0;
        background-color: #FF8FE3;

    }

    .bottom-nav {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #FFF;
        border-top: 1px solid #AEAEAE;
        padding: 0;
        text-align: center;
    }

    .bottom-nav-item {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;

    }

    .bottom-nav-item a {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #313638;
        font-size: 12px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        transition: color 0.3s ease;
        flex: 1;
        padding: 10px 0;
        /* Occupying the padding */
        box-sizing: border-box;
        /* Ensures padding is included in the element's total size */
    }


    .bottom-nav-item a.active {
        background-color: rgba(0, 0, 0, 0.08);
    }

    .bottom-nav-item img {
        margin-top: 5px;
    }

    @media screen and (max-width: 1600px) {
        .navbar>.menu a {
            font-size: 20px;
            margin: 0 20px;
        }

        .navbar>.brand img {
            width: 120px;
        }
    }

    @media screen and (max-width: 1200px) {
        .navbar>.menu a {
            font-size: 18px;
            margin: 0 15px;
        }

        .navbar>.brand img {
            width: 100px;
        }
    }




    @media (max-width: 768px) {
        .navbar {
            display: none;
        }

        .bottom-nav {
            display: flex;
            justify-content: space-around;
            /* Add styles for bottom navigation */
            overflow-x: hidden;
            z-index: 1000;
        }


    }
    </style>
    <div class="navbar">
        <div class="brand">
            <img src="assets/images/navbar-logo.svg" alt="">
        </div>
        <div class="menu-toggle"> </div>
        <div class="menu" id="menu">
            <a href="home.php">Home</a>
            <a href="jobs.php">Jobs</a>
            <a href="about-us.php">About</a>
            <a href="contact-us.php">Contact</a>
        </div>
    </div>

    <div class="bottom-nav">
        <div class="bottom-nav-item" style="text-align: center;">
            <a href="home.php" style="display: inline-block;">
                <img src="assets/images/home.svg" alt="Home Icon" style="width: 20px; height: 20px;">
                <div>Home</div>
            </a>
        </div>
        <div class="bottom-nav-item" style="text-align: center;">
            <a href="jobs.php" style="display: inline-block;">
                <img src="assets/images/briefcase.svg" alt="Jobs Icon" style="width: 20px; height: 20px;">
                <div>Jobs</div>
            </a>
        </div>
        <div class="bottom-nav-item" style="text-align: center;">
            <a href="about-us.php" style="display: inline-block;">
                <img src="assets/images/help-circle.svg" alt="About Icon" style="width: 20px; height: 20px;">
                <div>About</div>
            </a>
        </div>
        <div class="bottom-nav-item" style="text-align: center;">
            <a href="contact-us.php" style="display: inline-block;">
                <img src="assets/images/phone-call.svg" alt="Contact Icon" style="width: 20px; height: 20px;">
                <div>Contact</div>
            </a>
        </div>
    </div>

    <script>
    document.querySelectorAll('.menu a').forEach(link => {
        // Get the current page filename
        const currentPage = window.location.pathname.split('/').pop();

        // Check if the current page is job-details.php
        if (currentPage === 'job-details.php' || currentPage === 'job-application.php') {
            // If so, find the Jobs link and add active class
            if (link.getAttribute('href') === 'jobs.php') {
                link.classList.add('active');
            }
        }
        // Normal case - match href with current page
        else if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }

        link.addEventListener('click', function() {
            document.querySelectorAll('.menu a').forEach(item => item.classList.remove('active'));
            this.classList.add('active');
        });
    });

    //active link for bottom nav
    document.querySelectorAll('.bottom-nav a').forEach(link => {
        const currentPage = window.location.pathname.split('/').pop();

        // Check if the current page is job-details.php
        if (currentPage === 'job-details.php' || currentPage === 'job-application.php') {
            // If so, find the Jobs link and add active class
            if (link.getAttribute('href') === 'jobs.php') {
                link.classList.add('active');
            }
        }
        // Normal case - match href with current page
        else if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }

        link.addEventListener('click', function() {
            document.querySelectorAll('.bottom-nav a').forEach(item => item.classList.remove('active'));
            this.classList.add('active');
        });
    });
    </script>