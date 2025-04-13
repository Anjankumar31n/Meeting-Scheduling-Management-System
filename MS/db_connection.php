<?php
$servername = "localhost";
$username = "root";  // default username for MySQL
$password = "";      // default password for MySQL
$dbname = "meeting_system";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
