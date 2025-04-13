<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;  /* Lighter background color */
        }
        header {
            background-color: #2c3e50;  /* Dark blue-grey background */
            color: #ecf0f1;  /* Light text color */
            padding: 15px;
            text-align: center;
        }
        nav {
            background-color: #34495e;  /* Slightly lighter grey-blue */
            overflow: hidden;
        }
        nav a {
            float: left;
            display: block;
            padding: 14px 20px;
            color: #ecf0f1;  /* Light text color */
            text-align: center;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #7f8c8d;  /* Dark grey on hover */
            color: white;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .login-form, .register-form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            background-color: #27ae60;  /* Green button color */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .btn:hover {
            background-color: #2ecc71;  /* Light green on hover */
        }

        /* Image Carousel Styles */
        .carousel {
            width: 100%;
            overflow: hidden;
            margin: 20px 0;
        }
        .carousel-images {
            display: flex;
            transition: transform 1s ease-in-out;
        }
        .carousel-images img {
            width: 100vw;  /* Set width to 100% of the viewport width */
            height: 100vh;  /* Set height to 100% of the viewport height */
            object-fit: cover;  /* Ensure image covers the entire area without distortion */
        }
    </style>
</head>
<body>

<header>
    <h1>Meeting Management System</h1>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
</nav>

<!-- Image Carousel -->
<div class="carousel">
    <div class="carousel-images">
        <img src="../MS/image/img1.png" alt="Image 1">
        <img src="../MS/image/img2.png" alt="Image 2">
        <img src="../MS/image/img3.png" alt="Image 3">
    </div>
</div>

<div class="container">
    <h2>Welcome to the Meeting Management System</h2>
    <p>Login or Register to continue.</p>
</div>

<script>
    // JavaScript for auto sliding effect
    let currentIndex = 0;
    const images = document.querySelectorAll('.carousel-images img');
    const totalImages = images.length;

    function slideImages() {
        currentIndex = (currentIndex + 1) % totalImages;
        const newTransformValue = -currentIndex * 100;  // Move left by 100% of one image width
        document.querySelector('.carousel-images').style.transform = `translateX(${newTransformValue}vw)`;
    }

    setInterval(slideImages, 3000
