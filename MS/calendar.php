<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include('db_connection.php');

// Fetch meetings for the calendar
$sql = "SELECT * FROM meetings ORDER BY meeting_date";
$result = mysqli_query($conn, $sql);

// Prepare the meetings data for the calendar
$meetings = [];
while ($row = mysqli_fetch_assoc($result)) {
    $meetings[] = $row;
}

// Helper function to format date
function formatDate($date) {
    return date('Y-m-d', strtotime($date));
}

// Get the current month or the month from the URL (if navigating)
$currentMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
$nextMonth = date('Y-m', strtotime($currentMonth . ' +1 month'));
$prevMonth = date('Y-m', strtotime($currentMonth . ' -1 month'));

// Get the first and last day of the current month
$firstDay = date('Y-m-01', strtotime($currentMonth));
$lastDay = date('Y-m-t', strtotime($currentMonth));
$daysInMonth = date('t', strtotime($currentMonth));

// Get the first day of the week for the current month
$firstDayOfWeek = date('w', strtotime($firstDay));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Calendar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        nav {
            width: 100%;
            background-color: #6c5ce7;
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin-left: 15px;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 900px;
            margin-top: 70px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-top: 20px;
        }
        .calendar .day {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80px;
            border: 1px solid #ddd;
            font-size: 16px;
            position: relative;
            cursor: pointer;
        }
        .calendar .day.selected {
            background-color: #6c5ce7;
            color: white;
        }
        .calendar .day .events {
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 5px;
            font-size: 12px;
            color: #fff;
            background-color: #6c5ce7;
        }
        .calendar .day:hover {
            background-color: #ddd;
        }
        .event-list {
            margin-top: 30px;
        }
        .event-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .event-list th, .event-list td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .event-list th {
            background-color: #6c5ce7;
            color: white;
        }
        .calendar-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .calendar-nav button {
            background-color: #6c5ce7;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
        .calendar-nav button:hover {
            background-color: #4e3bb2;
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <a href="admin_dashboard.php">Organiser</a>
</nav>

<div class="container">
    <h2>Calendar of Meetings</h2>

    <!-- Calendar Navigation -->
    <div class="calendar-nav">
        <a href="?month=<?= $prevMonth ?>"><button>Previous</button></a>
        <h3><?= date('F Y', strtotime($currentMonth)) ?></h3>
        <a href="?month=<?= $nextMonth ?>"><button>Next</button></a>
    </div>

    <!-- Calendar -->
    <div class="calendar" id="calendar">
        <?php
        // Display blank days for the first week if the month does not start on Sunday
        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            echo '<div class="day"></div>';
        }

        // Display each day of the month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDay = sprintf('%02d', $day);
            $formattedDate = "$currentMonth-$currentDay";

            // Check if there are meetings on this date
            $eventsForDay = array_filter($meetings, function($meeting) use ($formattedDate) {
                return formatDate($meeting['meeting_date']) == $formattedDate;
            });

            echo '<div class="day" id="day-' . $formattedDate . '" onclick="highlightDay(\'' . $formattedDate . '\')">';
            echo "<span>$day</span>";
            if (!empty($eventsForDay)) {
                echo '<div class="events">';
                foreach ($eventsForDay as $event) {
                    echo '<div>' . htmlspecialchars($event['meeting_name']) . '</div>';
                }
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
    </div>

    <!-- Event List -->
    <div class="event-list" id="event-list">
        <h3>Upcoming Meetings</h3>
        <table>
            <tr>
                <th>Meeting Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Description</th>
                <th>Location</th>
                <th>Link</th>
            </tr>
            <?php foreach ($meetings as $meeting) { ?>
                <tr class="meeting-item" id="meeting-<?= formatDate($meeting['meeting_date']) ?>" style="display:none;">
                    <td><?= htmlspecialchars($meeting['meeting_name']) ?></td>
                    <td><?= htmlspecialchars($meeting['meeting_date']) ?></td>
                    <td><?= htmlspecialchars($meeting['meeting_time']) ?></td>
                    <td><?= htmlspecialchars($meeting['des']) ?></td>
                    <td><?= htmlspecialchars($meeting['location']) ?></td>
                    <td><?= htmlspecialchars($meeting['link']) ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

</div>

<script>
    function highlightDay(date) {
        // Reset previously selected days
        document.querySelectorAll('.day').forEach(day => {
            day.classList.remove('selected');
        });
        // Highlight clicked day
        document.getElementById('day-' + date).classList.add('selected');

        // Display corresponding meeting details
        document.querySelectorAll('.meeting-item').forEach(item => {
            item.style.display = 'none';
        });

        document.querySelectorAll('.meeting-item').forEach(item => {
            if (item.id === 'meeting-' + date) {
                item.style.display = 'table-row';
            }
        });
    }
</script>

</body>
</html>
