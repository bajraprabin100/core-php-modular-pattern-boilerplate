<?php
include 'layouts/header.php';
?>

<body>

    <div class="container mt-5">
        <h1>Upcoming Events</h1>
        <ul>
            <li><a href="/event/create">Create Event</a></li>
            <li><a href="/disconnect">Disconnect</a></li>

        </ul>
        <div id="calendar"></div>
    </div>
    <?php
    include 'layouts/scripts.php';
    ?>
    <script>
        $(document).ready(function () {
            $('#calendar').fullCalendar({
                events: '/events/calender',
                eventClick: function (calEvent, jsEvent, view) {
                    if (confirm('Are you sure you want to delete this event?')) {
                        deleteEvent(calEvent.id);   
                    }
                },
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                }
            });
            function deleteEvent(eventId) {
                $.ajax({
                    url: '/events/' + eventId,
                    type: 'DELETE',
                    success: function (response) {
                          $('#calendar').fullCalendar('removeEvents', eventId);
                    },
                    error: function (xhr, status, error) {
                        alert('Error deleting event: ' + error);
                    }
                });
            }
        });
    </script>

</body>

</html>