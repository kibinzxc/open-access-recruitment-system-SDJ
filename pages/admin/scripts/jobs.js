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
    initJobsModalLogic();
});
