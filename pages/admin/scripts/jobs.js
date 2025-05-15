function initJobsModalLogic() {
    let responsibilities = [];
    let qualifications = [];

    function updateHiddenInputs() {
        $('#responsibilityJson').val(JSON.stringify(responsibilities));
        $('#qualificationJson').val(JSON.stringify(qualifications));
    }

    $('#addResponsibilityBtn').on('click', function () {
        const value = $('#responsibilityInput').val().trim();
        if (value) {
            responsibilities.push(value);
            $('#responsibilityList').append(`<li class="list-group-item">${value}</li>`);
            $('#responsibilityInput').val('');
            updateHiddenInputs();
        }
    });

    $('#addQualificationBtn').on('click', function () {
        const value = $('#qualificationInput').val().trim();
        if (value) {
            qualifications.push(value);
            $('#qualificationList').append(`<li class="list-group-item">${value}</li>`);
            $('#qualificationInput').val('');
            updateHiddenInputs();
        }
    });
}

$(document).ready(function () {
    // DataTable
    // Destroy existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable('#jobTable')) {
        $('#jobTable').DataTable().clear().destroy();
    }



    // Modal logic
    initJobsModalLogic();

    // Delete with SweetAlert (delegated for dynamic compatibility)
    $(document).on('click', '.delete-job-btn', function () {
        const jobId = $(this).data('id');
        // Get the job title from the closest table row (assuming it's in a cell with class 'job-title')
        const jobTitle = $(this).closest('tr').find('.job-title').text().trim();

        Swal.fire({
            title: 'Are you sure?',
            text: `The job "${jobTitle}" will be permanently deleted.`,
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


});
