<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

include('db_connection.php');

// Fetch meetings to display
$sql = "SELECT meeting_name, meeting_date, meeting_time, des, location,meeting_id,link FROM meetings";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Meetings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        nav {
            width: 100%;
            background-color: #6c5ce7;
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            z-index: 1000;
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
            margin: 80px auto 0 auto;
        }
        h2, h3 {
            text-align: center;
            color: #333;
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
        table textarea {
            width: 100%;
            height: 50px;
            resize: none;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            box-sizing: border-box;
        }
        table .btn {
            background-color: #6c5ce7;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px;
        }
        table .btn:hover {
            background-color: #5a4bcf;
        }
    </style>
</head>
<body>
<nav>
    <a href="index.php">Home</a>
</nav>
<div class="container">
    <h2>Welcome User</h2>
    <h3>Meetings</h3>
    <table>
        <tr>
            <th>Meeting Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Description</th>
            <th>Location</th>
            <th>Comment</th>
            <th>Link</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['meeting_name']) ?></td>
                <td><?= htmlspecialchars($row['meeting_date']) ?></td>
                <td><?= htmlspecialchars($row['meeting_time']) ?></td>
                <td><?= htmlspecialchars($row['des']) ?></td>
                <td><?= htmlspecialchars($row['location']) ?></td>
                <td><?= htmlspecialchars($row['link']) ?></td>
                <td>
    <form method="POST" action="comment.php">
        <input type="hidden" name="meeting_id" value="<?= htmlspecialchars($row['meeting_id']) ?>">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['user']) ?>">
        <textarea name="comment_text" required></textarea>
        <button type="submit" class="btn">Comment</button>
    </form>
</td>

            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
