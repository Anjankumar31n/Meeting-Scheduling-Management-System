<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_meeting'])) {
    $meeting_name = $_POST['meeting_name'];
    $meeting_date = $_POST['meeting_date'];
    $meeting_time = $_POST['meeting_time'];
    $des = $_POST['des'];
    $location = $_POST['location'];
    $link = $_POST['link'];

    $sql = "INSERT INTO meetings (meeting_name, meeting_date, meeting_time, des, location, link) VALUES ('$meeting_name', '$meeting_date', '$meeting_time', '$des', '$location', '$link')";
    mysqli_query($conn, $sql);
}

// Fetch meetings to display
$sql = "SELECT * FROM meetings";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organiser Meetings</title>
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
            max-width: 800px;
            margin-top: 70px; /* Add margin to avoid overlapping with nav bar */
        }
        h2, h3 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        form input, form button {
            width: calc(50% - 10px);
            margin: 5px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        form input:focus {
            outline: none;
            border-color: #6c5ce7;
        }
        form button {
            background-color: #6c5ce7;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #5a4bcf;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #6c5ce7;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #ddd;
        }
        table a {
            color: #6c5ce7;
            text-decoration: none;
        }
        table a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<nav>
        <a href="index.php">Home</a>
        <a href="calendar.php">Events</a>
    </nav>
    <div class="container">
        <h2>Welcome Organiser</h2>
        <form method="POST">
            <input type="text" name="meeting_name" placeholder="Meeting Name" required>
            <input type="date" name="meeting_date" required>
            <input type="time" name="meeting_time" required>
            <input type="text" name="des" placeholder="Description" required>
            <input type="text" name="location" placeholder="Location" required>
            <input type="text" name="link" placeholder="link" required>
            <button type="submit" name="add_meeting">Add Meeting</button>
        </form>

        <h3>Meetings List</h3>
        <table>
            <tr>
                <th>Meeting Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Description</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['meeting_name']) ?></td>
                    <td><?= htmlspecialchars($row['meeting_date']) ?></td>
                    <td><?= htmlspecialchars($row['meeting_time']) ?></td>
                    <td><?= htmlspecialchars($row['des']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td><a href="delete_meeting.php?id=<?= $row['meeting_id'] ?>">Delete</a></td>
                </tr>
                <!-- Display Comments for Each Meeting -->
                <?php
                    $meeting_id = $row['meeting_id'];
                    $comment_sql = "SELECT * FROM comments WHERE meeting_id = $meeting_id";
                    $comment_result = mysqli_query($conn, $comment_sql);
                ?>
                <tr>
                    <td colspan="6">
                        <h4>Comments</h4>
                        <table>
                            <tr>
                                <th>User ID</th>
                                <th>Comment</th>
                            </tr>
                            <?php while ($comment_row = mysqli_fetch_assoc($comment_result)) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($comment_row['user_id']) ?></td>
                                    <td><?= htmlspecialchars($comment_row['comment_text']) ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
