<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "me";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['batch']) && isset($_POST['semester']) && isset($_POST['subject']) && isset($_POST['program_id'])) {
    // Retrieve form data and assign to variables
    $program_id = $_POST['program_id'];
    $batch = $_POST['batch'];
    $semester = $_POST['semester'];
    $subject = $_POST['subject'];

    // Save data into subjects table using prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO subjects (name, semester, batch, program_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $subject, $semester, $batch, $program_id);
    if ($stmt->execute()) {
        echo "";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    echo $program_id;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Batch Selection - SKASC</title>
    <link rel="icon" href="New folder/5.png">
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 8px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .delete-form {
            display: inline-block;
        }
    </style>
</head>
<body>
    <form action="details_page.php" method="post"> <!-- changed action -->
        <?php
        // You can retrieve program_id here from wherever it comes from and include it as a hidden input field
        ?>
        <input type="hidden" name="program_id" value="<?php echo $program_id; ?>">
        <label for="batch">Select Batch:</label>
        <select name="batch" id="batch">
            <option value="2018">2018</option>
            <option value="2019">2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <!-- Add more options as needed -->
        </select>

        <label for="semester">Select Semester:</label>
        <select name="semester" id="semester">
            <option value="1">Semester 1</option>
            <option value="2">Semester 2</option>
            <option value="3">Semester 3</option>
            <option value="4">Semester 4</option>
            <option value="5">Semester 5</option>
            <option value="6">Semester 6</option>
            <option value="7">Semester 7</option>
            <option value="8">Semester 8</option>
            <!-- Add more options as needed -->
        </select>

        <label for="subject">Enter Subject Name:</label>
        <input type="text" name="subject" id="subject" required>

        <input type="submit" value="Submit">
    </form>

    <!-- Display the table only if data is submitted -->
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['batch']) && isset($_POST['semester']) && isset($_POST['subject']) && isset($_POST['program_id'])) { ?>
        <h2>Stored Subjects</h2>
        <table>
            <tr>
                <th>Program Name</th>
                <th>Batch</th>
                <th>Semester</th>
                <th>Subject</th>
                <th>Action</th>
            </tr>
            <?php
            // Retrieve and display records related to the program_id
            $program_id = $_POST['program_id'];
            $records_query = "SELECT programs.name AS program_name, subjects.batch, subjects.semester, subjects.name AS subject_name, subjects.id AS subject_id FROM subjects INNER JOIN programs ON subjects.program_id = programs.id WHERE subjects.program_id = '$program_id' ORDER BY subjects.batch ASC, subjects.semester ASC";
            $records_result = $conn->query($records_query);
            if ($records_result) {
                if ($records_result->num_rows > 0) {
                    while ($row = $records_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["program_name"] . "</td>";
                        echo "<td>" . $row["batch"] . "</td>";
                        echo "<td>" . $row["semester"] . "</td>";
                        echo "<td>" . $row["subject_name"] . "</td>";
                        echo "<td><form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'><input type='hidden' name='subject_id' value='" . $row["subject_id"] . "'><input type='submit' value='Delete' onclick='return confirm(\"Are you sure you want to delete this subject?\")'></form></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No records found</td></tr>";
                }
            } else {
                echo "Error: " . $conn->error;
            }
            ?>
        </table>
    <?php } ?>
    
    <?php
    // Handle subject deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['subject_id']) && isset($_POST['program_id'])) {
    $subject_id = $_POST['subject_id'];
    $program_id = $_GET['program_id'];
    // Check if the subject exists before deletion
    $check_query = "SELECT * FROM subjects WHERE id = $program_id";
    $check_result = $conn->query($check_query);
    if ($check_result) {
        if ($check_result->num_rows > 0) {
            // Subject exists, proceed with deletion
            $delete_query = "DELETE FROM subjects WHERE id = $subject_id";
            if ($conn->query($delete_query) === TRUE) {
                echo "<p>Subject deleted successfully.</p>";
            } else {
                echo "Error deleting subject: " . $conn->error;
            }
        } else {
            echo "<p>Subject does not exist.</p>";
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
    ?>
</body>
</html>