<?php
// Database connection
$servername = "localhost"; // Change as per your configuration
$username = "root"; // Change as per your configuration
$password = ""; // Change as per your configuration
$dbname = "me"; // Change as per your configuration

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the program name is set in the URL
if(isset($_GET['program_name'])) {
    // Retrieve the program name from the URL parameter
    $program_name = urldecode($_GET['program_name']);
    // Define the header tag with the program name
    $header_tag = '<h1 style="color:black; text-align:center;">' . $program_name . '</h1>';
    
    // Fetch program_id based on program_name
    $sql_program_id = "SELECT id FROM programs WHERE name = '$program_name'";
    $result_program_id = $conn->query($sql_program_id);
    if ($result_program_id->num_rows > 0) {
        $row_program_id = $result_program_id->fetch_assoc();
        $program_id = $row_program_id["id"];
    } else {
        // Program not found, handle error
        $program_id = null; // or set a default value
    }
} else {
    // If program name is not set, display an error message
    $header_tag = '<h1 style="color:red; text-align:center;">Program name not found!</h1>';
}

// Check if a semester is selected and set
if(isset($_POST['semester']) && isset($_POST['batch'])) {
    // Get the selected semester value
    $selected_semester = $_POST['semester'];
    // Get the selected batch value
    $selected_batch = $_POST['batch'];

    // Check if subject, course code, and nature of course are set
    if(isset($_POST['subject']) && isset($_POST['course_code']) && isset($_POST['nature_of_course'])) {
        // Get the subject, course code, and nature of course values
        $subject = $_POST['subject'];
        $course_code = $_POST['course_code'];
        $nature_of_course = $_POST['nature_of_course'];

        // Insert subject into subjects table with batch, course code, and nature of course
        $sql_subject = "INSERT INTO subjects (name, program_id, semester, batch, course_code, nature_of_course) 
                        VALUES ('$subject', $program_id, '$selected_semester', '$selected_batch', '$course_code', '$nature_of_course')";

        if ($conn->query($sql_subject) === TRUE) {
            echo '<script>alert("Subject \'' . $subject . '\' added successfully for Semester ' . $selected_semester . ' and Batch ' . $selected_batch . '");</script>';
        } else {
            echo "Error: " . $sql_subject . "<br>" . $conn->error;
        }
    }
}

// Handle subject deletion
if(isset($_POST['delete_subject'])) {
    // Get the subject ID to delete
    $subject_id = $_POST['delete_subject'];
    
    // Delete the subject from the database
    $sql_delete_subject = "DELETE FROM subjects WHERE id = $subject_id";
    
    if ($conn->query($sql_delete_subject) === TRUE) {
        echo '<script>alert("Subject deleted successfully.");</script>';
    } else {
        echo "Error deleting subject: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKASC - Add Subjects</title>
    <link rel="icon" href="New folder/5.png">
    <link rel="stylesheet" href="styles.css">
    <style>    
        /* Global styles */
        * {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {      
            max-width: 1100px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.35);    
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }
        h1 {
            color: #333;
        }
        .subject-list {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }
        .subject-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 6px;
        }
        .subject-details {
            flex: 1;
        }
        .delete-btn-container {
            width: 120px; /* Fixed width for the delete button container */
        }
        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;    
            padding: 5px 10px;  
            width: 70%; /* Make the delete button fill the container */
            text-align: center; /* Center the text */
        }
        .add-btn {
            background-color: blue;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;    
            padding: 5px 10px;  
            width: 100px; /* Fixed width for the "Add Details" button */
            text-align: center; /* Center the text */
        }

        /* Form styles */
        .form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .form label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }
        .form select, .form input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            color: #555;
        }
        .form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
    </style>
</head>
<body>
    <?php include 'header4add_subjects.php'; ?>
    <div class="container">
        <div class="header">
            <!-- Display the header tag -->
            <?php echo $header_tag; ?>
        </div>

        <!-- Form to add subjects -->
        <div class="form">
            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                <label for="semester" style="font-weight: bold;">Select Semester:</label>
                <select name="semester" id="semester">
                    <?php
                    // Loop to generate options for semesters 1 to 8
                    for ($i = 1; $i <= 8; $i++) {
                        echo '<option value="' . $i . '">Semester ' . ($i == 1 ? '1' : $i) . '</option>';
                    }
                    ?>
                </select>
                <label for="subject" style="font-weight: bold;">Add Subject:</label>
                <input type="text" name="subject" id="subject" required>
                <label for="course_code" style="font-weight: bold;">Course Code:</label>
                <input type="text" name="course_code" id="course_code" required>
                <label for="nature_of_course" style="font-weight: bold;">Nature of Course:</label>
                <select name="nature_of_course" id="nature_of_course">
                    <option value="theory">Theory</option>
                    <option value="practical">Practical</option>
                    <option value="theory_practical">Theory and Practical</option>
                </select>
                <label for="batch" style="font-weight: bold;">Select Batch:</label>
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
                <input type="hidden" name="program_name" value="<?php echo $program_name; ?>">
                <input type="submit"  value="Submit">
            </form>
        </div>

        <!-- Display subjects for the program -->
        <div class="subject-list">
            <h2>Subjects for <?php echo $program_name; ?>:</h2>
            <?php
            // Fetch subjects for the program from the database
            $sql_subjects = "SELECT id, name, semester, batch, course_code, nature_of_course FROM subjects WHERE program_id = $program_id ORDER BY batch DESC, semester ASC";
            $result_subjects = $conn->query($sql_subjects);
            if ($result_subjects->num_rows > 0) {
                while($row = $result_subjects->fetch_assoc()) {
                    echo '<div class="subject-item">';
                    echo '<div class="subject-details">';
                    echo '<span>' . $row["name"] . '  |  Semester ' . $row["semester"] . '  |  Batch ' . $row["batch"] . '</span>';
                    echo '<span>   |  Course Code :  ' . $row["course_code"] . ' |  Nature of Course: ' . $row["nature_of_course"] . '</span>'; // Display course code and nature of course
                    echo '</div>';
                    // Add delete button for each subject
                    echo '<div class="delete-btn-container">';
                    echo '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">';
                    echo '<input type="hidden" name="delete_subject" value="' . $row["id"] . '">';
                    echo '<input type="submit" value="Delete" class="delete-btn">';
                    echo '</form>';
                    echo '</div>';
                    
                    // Modify form action dynamically based on the nature of the course
                    if ($row["nature_of_course"] == "theory") {
                        $form_action = "theory.php?subject_name=" . urlencode($row["name"]) . "&course_code=" . urlencode($row["course_code"]);
                    } else {
                        // If the nature of the course is not theory, keep the original action
                        $form_action = $_SERVER['REQUEST_URI'];
                    }
                    echo '<form action="' . $form_action . '" method="post">';
                    echo '<input type="hidden" name="subject_id" value="' . $row["id"] . '">'; // Pass subject_id
                    echo '<input type="hidden" name="subject_name" value="' . $row["name"] . '">'; // Pass subject_name
                    echo '<input type="hidden" name="program_id" value="' . $program_id . '">'; // Pass program_id
                    echo '<input type="submit" value="Add Details" class="add-btn">';
                    echo '</form>';
                    echo '</div>';
                    
                }
            } else {
                echo '<div class="subject-item">No subjects added yet.</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
