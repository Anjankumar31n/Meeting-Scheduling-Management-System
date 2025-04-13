<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include('db_connection.php');

if (isset($_GET['id'])) {
    $meeting_id = intval($_GET['id']); // Sanitize input

    // Delete the meeting from the database
    $sql = "DELETE FROM meetings WHERE meeting_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $meeting_id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $_SESSION['message'] = "Meeting deleted successfully.";
        } else {
            $_SESSION['message'] = "No meeting found with the provided ID.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = "Failed to prepare the statement.";
    }
} else {
    $_SESSION['message'] = "Invalid request.";
}

header("Location: admin_dashboard.php");
exit;
?>
