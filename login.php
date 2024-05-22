<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if it's a staff login
    if (isset($_POST['staff_username']) && isset($_POST['staff_password'])) {
        $staff_username = $_POST['staff_username'];
        $staff_password = $_POST['staff_password'];

        // Extract the domain part of the username
        $domain = substr($staff_username, strpos($staff_username, '@') + 1);

        // Check if the domain part matches your desired domain and password is correct
        if ($domain === "skcet.ac.in" && $staff_password === "password") {
            // Authentication successful, redirect to home page
            $_SESSION['staff_username'] = $staff_username;
            header("Location: home.php");
            exit;
        } else {
            // Authentication failed, set error message
            echo "<script>alert('Username or password is incorrect');</script>";
            header("Location: login.php");
            exit;
        }
    }

    // Check if it's a student login
    if (isset($_POST['student_username']) && isset($_POST['student_password'])) {
        $student_username = $_POST['student_username'];
        $student_password = $_POST['student_password'];

        // Extract the domain part of the username
        $domain = substr($student_username, strpos($student_username, '@') + 1);

        // Check if the domain part matches your desired domain and password is correct
        if ($domain === "skcet.ac.in" && $student_password === "password") {
            // Authentication successful, redirect to student dashboard or wherever you want
            $_SESSION['student_username'] = $student_username;
            header("Location: student_dashboard.php");
            exit;
        } else {
            // Authentication failed, set error message
            $_SESSION['error_message'] = "Username or password is incorrect";
            header("Location: login.php");
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title style="color: white;">SKCET - Login Page</title>
<link rel="icon" href="15.png">
<style>
    body {
        background-color: rgba(255, 255, 255, 0.5);
        background-size: cover; /* Cover the entire viewport */
        background-repeat: no-repeat; /* No repeat */
        background-attachment: fixed; /* Fixed background */
        background-position: center; /* Center the background image */
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    
    }

    .login-container {
        border: 2px solid #000; /* Black border */
        background-color: aqua ;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        background-color: rgba(0, 0, 0, 0.35);   
    }

    button {
        padding: 10px 20px;
        margin: 10px;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        background-color: #007bff;
        color: #fff;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }

    .login-form {
        display: none;
    }

    .login-form h3 {
        margin-top: 0;
        color: #333;
    }

    .login-form input {
        display: block;
        margin: 10px auto;
        padding: 8px 12px;
        width: 250px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .login-form button {
        margin-top: 10px;
    }
    .back-video{
        position: fixed;
        top: 0;
        left: 0;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto; 
        object-fit: cover;
        z-index: -1;
    }
    @media(min-aspect-ratio:16/9){
        .back-video{
            width: 100%;
            height: 100%;
        }
    }
    @media(max-aspect-ratio:16/9){
        .back-video{
            width: 100%;
            height: 100%;
        }
    }

</style>
</head>
<body>
<video autoplay loop muted plays-inline class="back-video">
    <source src="video.mp4" type="video/mp4">
</video>
<div class="login-container">
    <h2 style="color:white;">Login </h2>
    <button onclick="showLoginForm('staff')">Staff Login</button>
    <button onclick="showLoginForm('student')">Student Login</button>

    <!-- Staff Login Form -->
    <div id="staffLoginForm" class="login-form">
        <h3 style="color: white;">Staff Login</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="staff_username" placeholder="Username" required>
            <input type="password" name="staff_password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>

    <!-- Student Login Form -->
    <div id="studentLoginForm" class="login-form">
        <h3 style="color: white;">Student Login</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="student_username" placeholder="Username" required>
            <input type="password" name="student_password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</div>

<script>
function showLoginForm(userType) {
    if (userType === 'staff') {
        document.getElementById('staffLoginForm').style.display = 'block';
        document.getElementById('studentLoginForm').style.display = 'none';
    } else if (userType === 'student') {
        document.getElementById('studentLoginForm').style.display = 'block';
        document.getElementById('staffLoginForm').style.display = 'none';
    }
}
</script>

</body>
</html>
