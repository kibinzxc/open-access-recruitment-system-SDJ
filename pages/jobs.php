<!DOCTYPE html>
<?php
include 'includes/db-connection.php';

// Get search parameter from GET request
$searchKeyword = isset($_GET['what']) ? trim($_GET['what']) : '';

// Base query
$query = "SELECT * FROM jobs";
$conditions = [];

// Add search keyword condition
if (!empty($searchKeyword)) {
    $conditions[] = "title LIKE '%" . mysqli_real_escape_string($conn, $searchKeyword) . "%'";
}

// Add country condition
$selectedCountry = isset($_GET['where']) ? trim($_GET['where']) : '';
if (!empty($selectedCountry)) {
    $conditions[] = "country = '" . mysqli_real_escape_string($conn, $selectedCountry) . "'";
}

// Combine conditions into the query
if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$result = mysqli_query($conn, $query);

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sweet Dream Job - Your dream job awaits!">
    <meta name="keywords" content="job, career, dream job, employment, opportunities">
    <link rel="icon" href="assets/images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/jobs.css">
    <title> Jobs | Sweet Dream Job</title>

    <!-- <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script> -->
</head>
<?php include 'includes/navbar.php'; ?>

<body class="body">
    <div class="note">Rotate your device for the best experience!</div>
    <div class="header" style="position: relative;">
        <img class="header-photo" src="assets/images/cover-photo.png" alt="Cover Photo">
        <div class="header-container">
            <form method="GET" action="jobs.php">
                <div class="search-container">

                    <!-- First Column -->
                    <div class="search-column">

                        <label for="what" class="mobile-hidden-text">What:</label>
                        <input type="text" id="what" name="what" placeholder="Job title, keywords..."
                            value="<?php echo htmlspecialchars($searchKeyword); ?>">
                    </div>

                    <!-- Second Column -->
                    <div class="search-column mobile-hidden">
                        <label for="where">Where:</label>
                        <select id="where" name="where" class="placeholder-shown">
                            <option value="" disabled selected>Select location</option>
                            <?php
                            $locationQuery = "SELECT DISTINCT country FROM jobs ORDER BY country ASC";
                            $locationResult = mysqli_query($conn, $locationQuery);
                            if (mysqli_num_rows($locationResult) > 0) {
                                while ($locationRow = mysqli_fetch_assoc($locationResult)) {
                                    $location = htmlspecialchars($locationRow['country']);
                                    echo '<option value="' . $location . '">' . $location . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="search-column">
                        <label class="hidden-class" for="search">search</label>
                        <button type="submit" id="search">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="wrapper">
            <?php
            $query .= " ORDER BY title ASC";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                echo '<div class="content">';
                while ($row = mysqli_fetch_assoc($result)) {
                    // Highlight matches in title only
                    $title = htmlspecialchars($row['title']);

                    if (!empty($searchKeyword)) {
                        $title = preg_replace(
                            "/(" . preg_quote($searchKeyword, '/') . ")/i",
                            '<span class="highlight">$1</span>',
                            $title
                        );
                    }

                    echo '<a href="job-details.php?id=' . $row['job_code'] . '" class="job-card" style="text-decoration: none; color: inherit;">';
                    echo '<div class="job-image"><img src="assets/images/jobs_bin/' . htmlspecialchars($row['img']) . '" alt=""></div>';
                    echo '<div class="job-title"><h2>' . $title . '</h2></div>';
                    echo '<div class="job-location"><img src="assets/images/map-pin.svg" alt="">' . htmlspecialchars($row['country']) . '</div>';
                    echo '<div class="job-tags">';

                    $qualifications = json_decode($row['qualification'], true);

                    if (is_array($qualifications) && isset($qualifications['qualification'])) {
                        $list = $qualifications['qualification'];

                        // Sort by number of letters (string length)
                        usort($list, function ($a, $b) {
                            return strlen($a) - strlen($b);
                        });

                        foreach ($list as $qualification) {
                            echo '<div class="job-tag">' . htmlspecialchars($qualification) . '</div>';
                        }
                    } else {
                        // echo '<div class="job-tag">No qualifications listed</div>';
                    }

                    echo '</div>';
                    echo '</a>';
                }
                echo '</div>';
            } else {
                echo '<div class="no-results">';
                echo '<p style="text-align:center">No jobs found';
                if (!empty($searchKeyword)) {
                    echo ' for "' . htmlspecialchars($searchKeyword) . '"';
                }
                echo '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>

<script>
document.querySelectorAll('.search-column select').forEach(select => {
    select.addEventListener('change', function() {
        if (this.value === "") {
            this.classList.add('placeholder-shown');
        } else {
            this.classList.remove('placeholder-shown');
        }
    });
});
</script>