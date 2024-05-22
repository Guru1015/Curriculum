<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "me"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$message = "New Programme Added!";
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if program_name is set and not empty
    if(isset($_POST["program_name"]) && !empty($_POST["program_name"])) {
        // Escape any special characters to prevent SQL injection
        $program_name = $conn->real_escape_string($_POST["program_name"]);
        // Insert the program name into the database
        $sql_insert_program = "INSERT INTO programs (name) VALUES ('$program_name')";
        if ($conn->query($sql_insert_program) === TRUE) {
            echo "<script>alert('$message');</script>";
        } else {
            echo "Error: " . $sql_insert_program . "<br>" . $conn->error;
        }
    } else {
        echo "Program name is required";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKCET - Programme</title>
    <link rel="icon" href="15.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin-top: 20px;
            background-image: url('3.jpg'); 
            background-color: rgba(255, 255, 255, 0.20);
            background-size: cover; 
            background-repeat: no-repeat; 
            background-attachment: fixed; 
            background-position: center; 
            color: #ffffff; 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center horizontally */
            justify-content: flex-start; /* Align to the top */
            min-height: 100vh; /* Ensure full viewport height */
        }
        .container {
            border: 2px solid #000; /* Black border */
            background-color: rgba(0, 0, 0, 0.60);
            text-align: center;
            border-radius: 20px;
            padding: 20px;
            color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.50);
            max-width: 700px; /* Set the maximum width */
            width: 100%; /* Full width */
            margin: 20px;
            margin-top: 190px;
        }
        .form-container {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .circle {
            width: 170px; /* Set the width of the circle */
            height: 170px; /* Set the height of the circle */
             /* Set background color to white */
            border-radius: 50%; /* Ensure the element is a circle */
            display: flex; /* Use flexbox to center the logo */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            margin-bottom: -85px; /* Negative margin to overlap the container */
        }
        .logo {
            width: 120px; /* Set the width of the logo */
            height: 140px; /* Set the height of the logo */
            margin-top: 140px;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            .circle {
                width: 130px;
                height: 130px;
                margin-bottom: -65px;
                
            }
            .logo {
                width: 90px;
                height: 105px;
            }
        }
    </style>
</head>
<body>
<div class="circle">
    <img src="15.png" alt="Logo" class="logo">
</div>
<div class="container">
    <h1>Programme</h1>
    <div class="form-container">
        <form action="program.php" method="GET">
            <div class="form-group">
                <select class="form-control" name="id">
                    <option value="">Select a programme</option>
                    <?php
                    // Fetch list of programs
                    $sql = "SELECT id, name FROM programs";
                    $result = $conn->query($sql);
                    // Display list of programs in dropdown
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                        }
                    } else {  
                        echo "<option value=''>No programs found</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success btn-block">SUBMIT</button>
        </form>
        <form action="" method="post">
            <div class="form-group">
                <label for="program_name" style="margin-top: 10px;">Create New Programme:</label>
                <input type="text" id="program_name" class="form-control" name="program_name" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Create Programme</button>
        </form>
    </div>
</div>
<div class="logout-btn text-center">
    <form action="login.php" method="get">
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
