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
    <title>SKASC - Programme</title>
    <link rel="icon" href="New folder/5.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin-top: 20px;
            background-image: url('20.jpg'); 
            background-color: rgba(255, 255, 255, 0.20);
            background-size: cover; 
            background-repeat: no-repeat; 
            background-attachment: fixed; 
            background-position: center; 
            color: #ffffff; 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            min-height: 100vh; /* Ensure full viewport height */
        }
        .container {
            background-color: rgba(0, 0, 0, 0.60);
            text-align: center;
            border-radius: 20px;
            padding: 20px;
            color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.50);
            margin-top: 200px;
        }
        .form-container {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .lg {
            margin-left: 47%;
            margin-top: 170px;
            height: 100px;
            width: 100px;
            margin-bottom: -170px;
        }
        .logout-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<img src="New folder/5.png" alt="lg1" class="lg">
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
