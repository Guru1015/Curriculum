<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Logo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        header {
            background: #495057;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.35);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .logo img {
            max-width: 100px;
            margin-bottom: 10px;
        }
        .logo h3 {
            color: white;
            margin: 0;
            font-size: 16px;
            line-height: 1.5;
        }
        .nav {
            display: flex;
            align-items: center;
        }
        .nav ol {
            display: flex;
            list-style: none;
        }
        .nav ol li {
            margin-right: 20px;
        }
        .nav ol li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            transition: color 0.3s;
        }
        .nav ol li a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <div class="logo">
                <img src="New folder/5.png" alt="Logo1">
                <img src="New folder/3.png" alt="Logo2">
            </div>
            <h3>Sri Krishna Arts and Science College <br>An Autonomous Institution <br>Coimbatore</h3>
        </div>
        <div class="nav">
            <ol>
                <li><a href="student_dashboard.php">Home</a></li>
                <li><a href="student_dashboard.php">⬅️ Previous</a></li>
                <li><a href="#">➡️ Next</a></li>
                <li><a href="https://skasc.ac.in/index.php/aboutus">About</a></li>
            </ol>
        </div>
    </header>
</body>
</html>
