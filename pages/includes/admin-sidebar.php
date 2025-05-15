<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<style>
    @font-face {
        font-family: 'Inter';
        src: url('../assets/fonts/Inter.ttf') format('truetype');
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
        position: relative;
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
        padding: 10px 20px !important;
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

    .unread-bar {
        position: absolute;
        top: 50;
        right: 20px;
        background-color: #3A7CA5;
        color: #FFFFFF;
        border-radius: 20%;
        padding: 2px 6px;
        font-size: 12px;
        font-weight: bold;
        z-index: 1;
    }

    @media (max-width: 768px) {
        .sidebar {
            display: none !important;
        }

        .content {
            margin-left: 0 !important;
        }

        .bottom-nav {
            display: flex !important;
            position: fixed !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            background-color: #FFF !important;
            height: 60px !important;
            z-index: 1000 !important;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1) !important;
            align-items: stretch !important;
        }

        .bottom-nav-item {
            flex: 1 !important;
            text-align: center !important;
            height: 100% !important;
            display: flex;
        }

        .bottom-nav-item a {
            text-decoration: none !important;
            color: #313638 !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
            height: 100% !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            box-sizing: border-box !important;
            line-height: 1 !important;
        }

        .bottom-nav-item img {
            display: block !important;
            /* fixes baseline alignment issues */
            width: 20px !important;
            height: auto !important;
            margin: 4px 0 !important;
        }

        .bottom-nav-item a.active {
            background-color: rgba(65, 43, 173, 0.1) !important;
            color: #412BAD !important;
        }

        .unread-bar {
            display: none;
        }

        .unread-bar2 {
            position: absolute;
            top: 10px;
            left: 32%;
            transform: translateX(-50%);
            background-color: #3A7CA5;
            color: #FFFFFF;
            border-radius: 20%;
            padding: 2px 4px;
            font-size: 10px;
            font-weight: bold;
            z-index: 1;
        }
    }
</style>
</head>

<div class="sidebar">
    <div class="brand">
        <img src="../assets/images/sdj-icon2.svg" alt="Logo" />
    </div>

    <div class="menu" id="menu">
        <a href="dashboard.php" class="<?php echo $currentPage === 'dashboard.php' ? 'active' : ''; ?>">
            <img src="../assets/images/admin-home.svg" data-active-src="../assets/images/active-admin-home.svg"
                data-inactive-src="../assets/images/admin-home.svg" alt="Dashboard Icon" />
            Dashboard
        </a>


        <a href="jobs.php" id="JobsLink"
            class="<?php echo ($currentPage === 'jobs.php' || $currentPage === 'edit-job.php' || $currentPage === 'applications.php') ? 'active' : ''; ?>">
            <img src="../assets/images/admin-jobs.svg" data-active-src="../assets/images/active-admin-jobs.svg"
                data-inactive-src="../assets/images/admin-jobs.svg" alt="Jobs Icon" />
            Jobs
        </a>

        <a href="inbox.php" class="<?php echo $currentPage === 'inbox.php' ? 'active' : ''; ?>">
            <?php
            // Fetch unread count from the database
            include_once 'config.php'; // Include your database connection file

            $query = "SELECT COUNT(*) AS unread_count FROM messages WHERE status = 'unread'";
            $result = $conn->query($query);

            $unreadCount = 0;
            if ($result && $row = $result->fetch_assoc()) {
                $unreadCount = $row['unread_count'];
            }
            ?>
            <?php if ($unreadCount > 0): ?>
                <div class="unread-bar"><?php echo $unreadCount; ?></div>
            <?php endif; ?>
            <img src="../assets/images/admin-inbox.svg" data-active-src="../assets/images/active-admin-inbox.svg"
                data-inactive-src="../assets/images/admin-inbox.svg" alt="Inbox Icon" />
            Inbox
        </a>

        <a href="settings.php"
            class="<?php echo ($currentPage === 'settings.php' || $currentPage === 'update-company-details.php') ? 'active' : ''; ?>">
            <img src="../assets/images/admin-settings.svg" data-active-src="../assets/images/active-admin-settings.svg"
                data-inactive-src="../assets/images/admin-settings.svg" alt="Settings Icon" />
            Settings
        </a>

    </div>

    <div class="logout">
        <a href="logout.php" onmouseover="this.querySelector('img').src='../assets/images/active-admin-logout.svg';"
            onmouseout="this.querySelector('img').src='../assets/images/admin-logout.svg';">
            <img src="../assets/images/admin-logout.svg" alt="Logout Icon" />
            Logout
        </a>
    </div>
</div>
<div class="bottom-nav">

    <div class="bottom-nav-item">
        <a href="jobs.php" id="jobsLink"
            class="<?php echo ($currentPage === 'jobs.php' || $currentPage === 'edit-job.php' || $currentPage === 'applications.php') ? 'active' : ''; ?>">
            <img src="../assets/images/admin-jobs.svg" alt="Jobs Icon" />
            <span>Jobs</span>
        </a>
    </div>
    <div class="bottom-nav-item">
        <a href="inbox.php" class="<?php echo $currentPage === 'inbox.php' ? 'active' : ''; ?>">
            <?php
            // Fetch unread count from the database
            include_once 'config.php'; // Include your database connection file

            $query = "SELECT COUNT(*) AS unread_count FROM messages WHERE status = 'unread'";
            $result = $conn->query($query);

            $unreadCount = 0;
            if ($result && $row = $result->fetch_assoc()) {
                $unreadCount = $row['unread_count'];
            }
            ?>
            <?php if ($unreadCount > 0): ?>
                <div class="unread-bar2"><?php echo $unreadCount; ?></div>
            <?php endif; ?>
            <img src="../assets/images/admin-inbox.svg" alt="Inbox Icon" />
            <span>Inbox</span>
        </a>
    </div>

    <div class="bottom-nav-item">
        <a href="dashboard.php" class="<?php echo $currentPage === 'dashboard.php' ? 'active' : ''; ?>">
            <img src="../assets/images/admin-home.svg" alt="Dashboard Icon" />
            <span>Dashboard</span>
        </a>
    </div>

    <div class="bottom-nav-item">
        <a href="settings.php"
            class="<?php echo ($currentPage === 'settings.php' || $currentPage === 'update-company-details.php') ? 'active' : ''; ?>">
            <img src="../assets/images/admin-settings.svg" alt="Settings Icon" />
            <span>Settings</span>
        </a>
    </div>
    <div class="bottom-nav-item">
        <a href="logout.php">
            <img src="../assets/images/admin-logout.svg" alt="Logout Icon" />
            <span>Logout</span>
        </a>
    </div>
</div>

<script>
    document.querySelectorAll('.menu a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove 'active' class from all links and reset images
            document.querySelectorAll('.menu a').forEach(a => {
                a.classList.remove('active');
                const img = a.querySelector('img');
                img.src = img.dataset.inactiveSrc; // Revert to the inactive image
            });

            // Add 'active' class to the clicked link and update the image
            this.classList.add('active');
            const img = this.querySelector('img');
            img.src = img.dataset.activeSrc; // Set to the active image

            const url = this.getAttribute('href');

            fetch(url)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('#main-content');
                    const newTitle = doc.querySelector('title').innerText;

                    // Replace main content
                    document.querySelector('#main-content').innerHTML = newContent.innerHTML;

                    // Update title
                    document.title = newTitle;
                    // ✅ Reinitialize scripts here
                    reinitializeScripts();
                    updateDashboardFooters();

                    // Update footers every 60 seconds
                    setInterval(updateDashboardFooters, 60000);
                    // Push new state to browser history
                    history.pushState({
                        html: newContent.innerHTML,
                        pageTitle: newTitle
                    }, "", url);


                });
        });
    });

    // Handle back/forward button navigation
    window.addEventListener('popstate', function(e) {
        if (e.state) {
            document.querySelector('#main-content').innerHTML = e.state.html;
            document.title = e.state.pageTitle;

            reinitializeScripts();
            updateDashboardFooters();
        }
    });

    document.querySelectorAll('.menu a').forEach(link => {
        const img = link.querySelector('img');

        // Store the inactive and active image URLs in data attributes
        img.dataset.activeSrc = img.dataset.activeSrc || img.src.replace('admin-',
            'active-admin-'); // Replace 'admin-' with 'active-admin-'
        img.dataset.inactiveSrc = img.dataset.inactiveSrc || img.src; // Keep the original src as the inactive image

        // Update images on hover
        link.addEventListener('mouseover', function() {
            if (!this.classList.contains('active')) {
                img.src = img.dataset.activeSrc;
            }
        });

        link.addEventListener('mouseout', function() {
            if (!this.classList.contains('active')) {
                img.src = img.dataset.inactiveSrc;
            }
        });
    });

    // On page load, set the active image correctly
    document.querySelectorAll('.menu a').forEach(link => {
        const img = link.querySelector('img');

        // If already has the active class (e.g., on page refresh), set image to active
        if (link.classList.contains('active')) {
            img.src = img.dataset.activeSrc;
        } else {
            img.src = img.dataset.inactiveSrc;
        }
    });

    function reinitializeScripts() {
        console.log('Reinitializing scripts...');

        if (typeof $ === 'undefined' || typeof $.fn.DataTable === 'undefined') {
            console.warn('jQuery or DataTables not loaded.');
            return;
        }

        const tablesToInitialize = ['#jobTable', '#msgTable', '#accTable', '#appTable'];

        tablesToInitialize.forEach((selector) => {
            const tableElement = document.querySelector(selector);
            if (tableElement) {
                console.log(`Initializing ${selector}...`);

                const $table = $(selector);

                if ($.fn.DataTable.isDataTable(selector)) {
                    $table.DataTable().destroy();
                }

                $table.DataTable({
                    ordering: true,
                    searching: true,
                    paging: true,
                    responsive: true
                });

                if (typeof initJobsModalLogic === 'function') {
                    initJobsModalLogic();
                }
            }
        });

        // ✅ Reattach Bootstrap modal functionality
        const modalElements = document.querySelectorAll('.modal');
        modalElements.forEach(modalEl => {
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (!modalInstance) {
                new bootstrap.Modal(modalEl); // reinitialize modal
            }
        });

        // ✅ Rebind SweetAlert delete handler
        $(document).off('click', '.delete-job-btn').on('click', '.delete-job-btn', function() {
            const jobId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "The \"" + $(this).data('title') + "\" will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete-job.php?id=' + jobId;
                }
            });
        });
    }


    function getTimeElapsed(timestamp) {
        const now = Math.floor(Date.now() / 1000); // Current time in seconds
        const elapsed = now - timestamp;

        if (elapsed < 60) {
            return "updated just now";
        } else if (elapsed < 3600) {
            const minutes = Math.floor(elapsed / 60);
            return `updated ${minutes} minute${minutes === 1 ? '' : 's'} ago`;
        } else if (elapsed < 86400) {
            const hours = Math.floor(elapsed / 3600);
            return `updated ${hours} hour${hours === 1 ? '' : 's'} ago`;
        } else {
            const days = Math.floor(elapsed / 86400);
            return `updated ${days} day${days === 1 ? '' : 's'} ago`;
        }
    }

    function updateDashboardFooters() {
        const footers = document.querySelectorAll('.dashboard-card-footer');

        footers.forEach(footer => {
            const timestamp = parseInt(footer.getAttribute('data-timestamp'), 10);
            footer.textContent = getTimeElapsed(timestamp);
        });
    }

    // Update footers on page load
    updateDashboardFooters();

    // Update footers every 60 seconds
    setInterval(updateDashboardFooters, 60000);
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="../admin/scripts/jobs.js"></script>