<?php
// Start the session
session_start();

// Include database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "me";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$course_code = "";
$subject_id = "";

// Check if course_code is set in the URL
if(isset($_GET['course_code'])) {
    // Retrieve course code from URL
    $course_code = $_GET['course_code'];

    // Fetch subject ID from the database based on the course code
    $sql_subject_id = "SELECT id FROM subjects WHERE course_code = ?";
    $stmt = $conn->prepare($sql_subject_id);
    $stmt->bind_param("s", $course_code);
    $stmt->execute();
    $stmt->bind_result($subject_id);
    $stmt->fetch();
    $stmt->close();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $course_title = $_POST['course_title'];
    $nature = $_POST['nature'];
    $prerequisites = $_POST['prerequisites'];
    $objectives = json_encode($_POST['objective']); // Convert objectives array to JSON string
    $course_code = $_POST['course_code']; // Retrieve course_code from the form

    // Check if course_code is set and proceed with updating the record
    if (!empty($course_code)) {
        // Update data in the database
        $sql = "UPDATE subjects SET course_title=?, nature=?, prerequisites=?, objectives=? WHERE course_code=?";

        // Prepare and bind the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $course_title, $nature, $prerequisites, $objectives, $course_code);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: Course Code not found in the form.";
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theory Page</title>
    <style>
        /* CSS styles */
        * {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .container {      
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.35);    
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }
        h1 {
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .add-row-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            padding: 10px 20px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Display the course code in the heading -->
        <h1><?php echo isset($_GET['course_code']) ? $_GET['course_code'] : "Course Code Not Found"; ?></h1>
        
        <!-- Form to collect details -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> <!-- Pass course_code -->
            <input type="hidden" name="course_code" value="<?php echo htmlspecialchars($_GET['course_code'] ?? '', ENT_QUOTES); ?>"> <!-- Ensure course_code is properly sanitized -->

            <label for="course_title">Title of the Course:</label>
            <input type="text" id="course_title" name="course_title" required>

            <label for="nature">Nature of the Course:</label>
            <input type="text" id="nature" name="nature" required>

            <label for="prerequisites">Pre-requisite(s):</label>
            <textarea id="prerequisites" name="prerequisites" rows="4" required></textarea>

            <label for="objectives">Course Objectives:</label>
            <table id="objectives_table">
                <tr>
                    <th>Serial No.</th>
                    <th>Objective</th>
                </tr>   
                <tr>
                    <td>1</td>
                    <td><input type="text" name="objective[]"></td>
                </tr>
            </table>
            <button type="button" class="add-row-btn" onclick="addRow()">Add Objective</button>
            
            <input type="submit" value="Save Details">
        </form>
    </div>

    <script>
        // JavaScript function to add a row to the objectives table
        function addRow() {
            var table = document.getElementById("objectives_table");
            var row = table.insertRow(table.rows.length);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            cell1.innerHTML = table.rows.length - 1;
            cell2.innerHTML = '<input type="text" name="objective[]">';
        }
    </script>
</body>
</html>
