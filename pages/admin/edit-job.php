<?php
include("../includes/authenticate.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = "SELECT * FROM jobs WHERE id = $id";
$result = mysqli_query($conn, $query);
$job = mysqli_fetch_assoc($result);

$responsibilities = json_decode($job['responsibilities'] ?? '[]', true);
$qualifications = json_decode($job['qualification'] ?? '[]', true);

$responsibilities = $responsibilities['responsibilities'] ?? [];
$qualifications = $qualifications['qualification'] ?? [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Job | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles/jobs.css">
</head>

<?php include '../includes/admin-sidebar.php'; ?>

<body>
    <div class="content" id="main-content">
        <div class="table-jobs">
            <h1>Edit Job</h1>
            <form action="update-job.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($job['id']) ?>">

                <div class="mb-3">
                    <label class="form-label">Job Title</label>
                    <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($job['title']) ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" name="country"
                        value="<?= htmlspecialchars($job['country']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Availability</label>
                    <select class="form-select" name="availability" required>
                        <option value="Open" <?= $job['availability'] == 'Open' ? 'selected' : '' ?>>Open</option>
                        <option value="Closed" <?= $job['availability'] == 'Closed' ? 'selected' : '' ?>>Closed
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4"
                        required><?= htmlspecialchars($job['description']) ?></textarea>
                </div>

                <!-- Responsibilities -->
                <div class="mb-3">
                    <label class="form-label">Responsibilities</label>
                    <div class="input-group mb-2">
                        <input type="text" id="responsibilityInput" class="form-control">
                        <button type="button" class="btn btn-outline-primary" id="addResponsibilityBtn">Add</button>
                    </div>
                    <ul id="responsibilityList" class="list-group mb-2">
                        <?php foreach ($responsibilities as $r): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($r) ?>
                            <button type="button" class="btn btn-sm btn-danger remove-responsibility">Remove</button>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <input type="hidden" name="responsibilities" id="responsibilityJson">
                </div>

                <!-- Qualifications -->
                <div class="mb-3">
                    <label class="form-label">Qualifications</label>
                    <div class="input-group mb-2">
                        <input type="text" id="qualificationInput" class="form-control">
                        <button type="button" class="btn btn-outline-primary" id="addQualificationBtn">Add</button>
                    </div>
                    <ul id="qualificationList" class="list-group mb-2">
                        <?php foreach ($qualifications as $q): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($q) ?>
                            <button type="button" class="btn btn-sm btn-danger remove-qualification">Remove</button>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <input type="hidden" name="qualifications" id="qualificationJson">
                </div>

                <button type="submit" class="btn btn-success">Save Changes</button>
            </form>

        </div>
    </div>
    <script>
    let responsibilities = <?= json_encode($responsibilities) ?>;
    let qualifications = <?= json_encode($qualifications) ?>;

    function updateHiddenInputs() {
        $('#responsibilityJson').val(JSON.stringify(responsibilities));
        $('#qualificationJson').val(JSON.stringify(qualifications));
    }


    function renderList(listId, data, type) {
        const $list = $(`#${listId}`);
        $list.empty();
        data.forEach((item, index) => {
            $list.append(`
            <li class="list-group-item d-flex justify-content-between align-items-center">
                ${item}
                <button type="button" class="btn btn-sm btn-danger remove-${type}" data-index="${index}">Remove</button>
            </li>
        `);
        });
    }

    $('#addResponsibilityBtn').on('click', function() {
        const value = $('#responsibilityInput').val().trim();
        if (value) {
            responsibilities.push(value);
            renderList('responsibilityList', responsibilities, 'responsibility');
            $('#responsibilityInput').val('');
            updateHiddenInputs();
        }
    });

    $('#addQualificationBtn').on('click', function() {
        const value = $('#qualificationInput').val().trim();
        if (value) {
            qualifications.push(value);
            renderList('qualificationList', qualifications, 'qualification');
            $('#qualificationInput').val('');
            updateHiddenInputs();
        }
    });

    // Delegate remove buttons
    $(document).on('click', '.remove-responsibility', function() {
        const index = $(this).data('index');
        responsibilities.splice(index, 1);
        renderList('responsibilityList', responsibilities, 'responsibility');
        updateHiddenInputs();
    });

    $(document).on('click', '.remove-qualification', function() {
        const index = $(this).data('index');
        qualifications.splice(index, 1);
        renderList('qualificationList', qualifications, 'qualification');
        updateHiddenInputs();
    });

    $(document).ready(function() {
        renderList('responsibilityList', responsibilities, 'responsibility');
        renderList('qualificationList', qualifications, 'qualification');
        updateHiddenInputs();
    });
    </script>

</body>

</html>