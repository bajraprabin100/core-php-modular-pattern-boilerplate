<?php
include 'layouts/header.php';
?>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="/event/store" method="post" id="eventForm">
                    <div class="form-group">
                        <label for="summary">Summary:</label>
                        <input type="text" class="form-control" id="summary" name="summary"
                            placeholder="Enter event summary" required>
                    </div>
                    <div class="form-group">
                        <label for="startDateTimeDisplay">Start Date and Time:</label>
                        <input type="text" class="form-control datetimepicker-input" id="startDateTimeDisplay" required>
                        <input type="hidden" id="startDateTime" name="startDateTime">
                    </div>
                    <div class="form-group">
                        <label for="endDateTimeDisplay">End Date and Time:</label>
                        <input type="text" class="form-control datetimepicker-input" id="endDateTimeDisplay" name="endDateTimeDisplay"
                            placeholder="Enter Date and time" required>
                        <input type="hidden" id="endDateTime" name="endDateTime">

                    </div>
                   
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    include 'layouts/scripts.php';
    ?>
    <script>
        $(document).ready(function () {
    $('.datetimepicker-input').datetimepicker({
        format: 'Y-m-d H:i',
        step: 15
    });

    $('#eventForm').validate({
        rules: {
            summary: {
                required: true
            },
            startDateTimeDisplay: {
                required: true,
                datetime: true
            },
            endDateTimeDisplay: {
                required: true,
                datetime: true,
                greaterThan: "#startDateTimeDisplay"
            }
        },
        messages: {
            summary: "Please enter the event summary",
            startDateTimeDisplay: {
                required: "Please enter the start date and time",
                datetime: "Please enter a valid start date and time"
            },
            endDateTimeDisplay: {
                required: "Please enter the end date and time",
                datetime: "Please enter a valid end date and time",
                greaterThan: "End date and time must be greater than start date and time"
            }
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        }
    });

    $.validator.addMethod("datetime", function (value, element) {
        return this.optional(element) || moment(value, 'YYYY-MM-DD HH:mm', true).isValid();
    }, "Please enter a valid date and time format (YYYY-MM-DD HH:mm)");

    $.validator.addMethod("greaterThan", function (value, element, param) {
        var startDateTime = $(param).val();
        if (!value || !startDateTime) {
            return true;
        }
        return moment(value, 'YYYY-MM-DD HH:mm').isAfter(moment(startDateTime, 'YYYY-MM-DD HH:mm'));
    }, "End date and time must be greater than start date and time");

    // Handle form submission
    $('#eventForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        // Trigger validation for both fields
        $('#startDateTimeDisplay').valid();
        $('#endDateTimeDisplay').valid();

        // If form is valid, proceed with submitting the form
        if ($('#eventForm').valid()) {
            $('#startDateTime').val(moment($('#startDateTimeDisplay').val(), 'YYYY-MM-DD HH:mm').format());
            $('#endDateTime').val(moment($('#endDateTimeDisplay').val(), 'YYYY-MM-DD HH:mm').format());

            this.submit(); // Submit the form
        }
    });
});
    </script>

</body>

</html>