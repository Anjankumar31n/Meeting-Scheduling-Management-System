<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('db_connection.php');
    
    // Ensure session variable for username is set
    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user']; // Get username from session
        $meeting_id = $_POST['meeting_id'];
        $comment_text = $_POST['comment_text'];

        // Sanitize user input to prevent SQL injection
        $username = mysqli_real_escape_string($conn, $username);
        $meeting_id = mysqli_real_escape_string($conn, $meeting_id);
        $comment_text = mysqli_real_escape_string($conn, $comment_text);

        // Retrieve user_id based on the username from the users table
        $check_user_sql = "SELECT user_id FROM users WHERE username = '$username'";
        $check_result = mysqli_query($conn, $check_user_sql);
        if (mysqli_num_rows($check_result) > 0) {
            // Fetch the user_id from the result
            $user_row = mysqli_fetch_assoc($check_result);
            $user_id = $user_row['user_id']; // Get the user_id

            // Proceed to insert the comment
            $sql = "INSERT INTO comments (user_id, meeting_id, comment_text) VALUES ('$user_id', '$meeting_id', '$comment_text')";
            if (mysqli_query($conn, $sql)) {
                header("Location: user_dashboard.php");
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Invalid user.";
        }
    } else {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit();
    }
}
?>
