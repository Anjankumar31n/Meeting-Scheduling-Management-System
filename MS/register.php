<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('db_connection.php');
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    // Insert new user
    $sql = "INSERT INTO users (username, password, phone) VALUES ('$username', '$password', '$phone')";
    if (mysqli_query($conn, $sql)) {
        echo "";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .register-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .form-group input:focus {
            outline: none;
            border-color: #6c5ce7;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #6c5ce7;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #5a4bcf;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: green;
        }
        .go-home {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
        .go-home a {
            color: #6c5ce7;
            text-decoration: none;
        }
        .go-home a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-form">
        <h2>Register</h2>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { echo '<div class="message">Registration successful!</div>'; } ?>
        <div class="go-home">
            <p>Already have an account? <a href="index.php">Go to Home Page</a></p>
        </div>
    </div>
</body>
</html>
