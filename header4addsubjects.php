<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Logo</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        header {
            background-color: #a0d2eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            border-radius: 10px;
            border: 1px solid #000; /* Black border */
        }
        .Logo {
            color: rgb(44, 44, 44);
            font-size: 1.5em;
            flex-shrink: 0; /* Prevents the logo from shrinking */
        }
        .nav {
            display: flex;
            align-items: center;
        }
        .nav ol {
            display: flex;
            list-style: none;
        }
        .btn {
            position: relative;
            width: 25px;
            height: 25px;
            -webkit-appearance: none;
            appearance: none;
            cursor: pointer;
            display: none;
        }
        .btn::before {
            content: '\f0c9';
            position: absolute;
            top: 0;
            left: 0;
            font-family: 'Font Awesome 5 Free';
            font-weight: 700;
            font-size: 2em;
        }
        .nav ol li {
            margin: 1em;
        }
        .nav ol li a {
            text-decoration: none;
            padding: 0.2em 1.2em 0.9em 1.2em;
            border-radius: 10px 10px 0 0;
            color: rgb(39, 39, 39);
            transition: all .4s;
            position: relative;
            z-index: 1;
        }
        .nav ol li a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 41px;
            border-radius: 10px 10px 0 0;
            background: #853333;
            transform-origin: bottom;
            background: linear-gradient(to right, #2C5364, #203A43, #0F2027);
            transform: scaleY(0.05);
            z-index: -1;
            transition: all .4s;
        }
        .nav ol li a:hover::before {
            transform: scaleY(1.1);
        }
        .nav ol li a:hover {
            color: white;
        }
        h3{
            font-size: 20px;
            margin-left: -1200px;
            font-weight: bold;
        }
        @media (max-width: 1850px) {
            header {
                display: none;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="Logo">
            <img src="New folder/5.png" alt="Logo" style="max-width: 100px; margin-left:565px;" >
        </div>
        <img class="logo2" src="15.png" alt="Logo" style="max-width: 100px; margin-left:240px;" >
        <p class="Logo"></p>
        <h3>Sri Krishna College of Engineering and Technology <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An Autonomous Institution <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Coimbatore</h3>
        <input type="checkbox" name="" class="btn">
        <div class="nav">
            <ol>
                <li><a href="home.php">Home</a></li>
                <li><a href="https://skcet.ac.in/">Contact us</a></li>
                <li><a href="https://skcet.ac.in/about-us/institution/">About</a></li>
            </ol>
        </div>
    </header>
</body>
</html>
