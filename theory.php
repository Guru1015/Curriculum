<?php
// Retrieve subject name and course code from URL parameters
if (isset($_GET['subject_name']) && isset($_GET['course_code'])) {
    $subject_name = urldecode($_GET['subject_name']);
    $course_code = urldecode($_GET['course_code']);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
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

    $course_title = isset($_POST['course_title']) ? $_POST['course_title'] : '';
    $prerequisites = isset($_POST['prerequisites']) ? $_POST['prerequisites'] : '';

    // Handle objectives
    $objectives = [];
    if (isset($_POST['serial'])) {
        // Iterate through each serial and objective
        foreach ($_POST['serial'] as $index => $serial) {
            // Check if both serial and objective are not empty
            if (!empty($serial) && !empty($_POST['objective'][$index])) {
                // Construct a string with serial and objective separated by a delimiter
                $objectives[] = $serial . '|' . $_POST['objective'][$index];
            }
        }
    }
    // Implode the objectives array to a string
    $objectives = implode(',', $objectives);


    // Handle outcomes
    $outcomes = [];
    if (isset($_POST['co']) && isset($_POST['description']) && isset($_POST['uup'])) {
        $cos = $_POST['co'];
        $descriptions = $_POST['description'];
        $uups = $_POST['uup'];
        foreach ($cos as $index => $co) {
            if (!empty($co) && !empty($descriptions[$index]) && !empty($uups[$index])) {
                $outcomes[] = $co . '|' . $descriptions[$index] . '|' . $uups[$index];
            }
        }
    }
    $outcomes = implode(',', $outcomes);

    // Handle course content
    $course_content = [];
    if (isset($_POST['module_no']) && isset($_POST['content_description']) && isset($_POST['time'])) {
        $module_nos = $_POST['module_no'];
        $descriptions = $_POST['content_description'];
        $times = $_POST['time'];
        foreach ($module_nos as $index => $module_no) {
            if (!empty($module_no) && !empty($descriptions[$index]) && !empty($times[$index])) {
                $course_content[] = $module_no . '|' . $descriptions[$index] . '|' . $times[$index];
            }
        }
    }
    $course_content = implode(',', $course_content);

    // Handle textbooks
    $textbooks = [];
    if (isset($_POST['textbook_no']) && isset($_POST['textbook_description'])) {
        $textbook_nos = $_POST['textbook_no'];
        $textbook_descriptions = $_POST['textbook_description'];
        foreach ($textbook_nos as $index => $textbook_no) {
            if (!empty($textbook_no) && !empty($textbook_descriptions[$index])) {
                $textbooks[] = $textbook_no . ' : ' . $textbook_descriptions[$index];
            }
        }
    }
    $textbooks = implode(",\n", $textbooks); // Separate rows by new line

    // Handle reference books
    $referencebooks = [];
    if (isset($_POST['referencebook_no']) && isset($_POST['referencebook_description'])) {
        $referencebook_nos = $_POST['referencebook_no'];
        $referencebook_descriptions = $_POST['referencebook_description'];
        foreach ($referencebook_nos as $index => $referencebook_no) {
            if (!empty($referencebook_no) && !empty($referencebook_descriptions[$index])) {
                $referencebooks[] = $referencebook_no . ' : ' . $referencebook_descriptions[$index];
            }
        }
    }
    $referencebooks = implode(",\n", $referencebooks); // Separate rows by new line

    // Handle web references
    $webreferences = [];
    if (isset($_POST['webreferences_no']) && isset($_POST['webreferences_description'])) {
        $webreferences_nos = $_POST['webreferences_no'];
        $webreferences_descriptions = $_POST['webreferences_description'];
        foreach ($webreferences_nos as $index => $webreferences_no) {
            if (!empty($webreferences_no) && !empty($webreferences_descriptions[$index])) {
                $webreferences[] = $webreferences_no . ' : ' . $webreferences_descriptions[$index];
            }
        }
    }
    $webreferences = implode(",\n", $webreferences); // Separate rows by new line

    // Handle online references
    $onlinereferences = [];
    if (isset($_POST['onlinereferences_no']) && isset($_POST['onlinereferences_description'])) {
        $onlinereferences_nos = $_POST['onlinereferences_no'];
        $onlinereferences_descriptions = $_POST['onlinereferences_description'];
        foreach ($onlinereferences_nos as $index => $onlinereferences_no) {
            if (!empty($onlinereferences_no) && !empty($onlinereferences_descriptions[$index])) {
                $onlinereferences[] = $onlinereferences_no . ' : ' . $onlinereferences_descriptions[$index];
            }
        }
    }
    $onlinereferences = implode(",\n", $onlinereferences); // Separate rows by new line

    // Update the database using prepared statements
    $stmt = $conn->prepare("UPDATE subjects SET course_title = ?, prerequisites = ?, objectives = ?, outcomes = ?, course_content = ?, textbook = ?, referencebook = ?, webreferences = ?, onlinereferences = ? WHERE name = ? AND course_code = ?");
    $stmt->bind_param("sssssssssss", $course_title, $prerequisites, $objectives, $outcomes, $course_content, $textbooks, $referencebooks, $webreferences, $onlinereferences, $subject_name, $course_code);

    if ($stmt->execute()) {
        echo '<script>alert("Record updated successfully");</script>';
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theory Page - SKASC</title>
    <link rel="icon" href="New folder/5.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #495057;
            background-color: rgba(0, 0, 0, 0.35);  
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: calc(100% - 16px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
        .del-row-btn{
            background-color: red;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }
        .save-btn{
            background-color: green;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }
        .add-row-btn {
            background-color: #007bff;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }



        .btn-group {
            margin-bottom: 20px;
            text-align: center;
        }

        .btn-group::after {
            content: "";
            display: table;
            clear: both;
        }

        .btn-group button {
            float: none;
        }

        .btn-group button:last-child {
            float: right;
        }
    </style>
</head>
<body>
    
    <!-- Other content of the page can be added here -->
    <div class="container">
        <!-- Display the course code in the heading -->
        <h2><?php echo $subject_name . ' - ' . $course_code; ?></h2>
        
        <!-- Form to collect details -->
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?subject_name=' . urlencode($subject_name) . '&course_code=' . urlencode($course_code); ?>" method="post"> <!-- Pass subject_name and course_code in the URL -->
            <input type="hidden" name="course_code" value="<?php echo htmlspecialchars($_GET['course_code'] ?? '', ENT_QUOTES); ?>"> <!-- Ensure course_code is properly sanitized -->

            <label for="course_title">Title of the Course:</label>
            <input type="text" id="course_title" name="course_title" required>


            <label for="prerequisites" style="margin-top: 10px;">Pre-requisite(s):</label>
            <textarea id="prerequisites" name="prerequisites" rows="4" required></textarea>

            <label for="objectives"style="margin-top: 10px;">Course Objectives:</label>
            <table id="objectives_table">
                <tr>
                    <th>S.No</th>
                    <th>Objective</th>
                </tr>   
                <tr>
                    <td><textarea name ="serial[]" rows="4" required></textarea></td>
                    <td><textarea name="objective[]" rows="4"></textarea></td>
                </tr>
            </table>
            <button type="button" class="add-row-btn" onclick="addRow('objectives_table')">Add Row</button>
            <button type="button" class="del-row-btn" onclick="delRow('objectives_table')">Delete Row</button>


            <label for="course_outcomes"style="margin-top: 10px;">Course Outcomes:</label>
            <table id="outcomes_table">
                <tr>
                    <th>CO</th>
                    <th>Description</th>
                    <th>UUP</th>
                </tr>   
                <tr>
                    <td><textarea name="co[]" rows="4" required></textarea></td>
                    <td><textarea name="description[]" rows="4" required></textarea></td>
                    <td><textarea name="uup[]" rows="4" required></textarea></td>
                </tr>
            </table>
            <button type="button" class="add-row-btn" onclick="addRow('outcomes_table')">Add Row</button>
            <button type="button" class="del-row-btn" onclick="delRow('outcomes_table')">Delete Row</button>

            <label for="course_content"style="margin-top: 10px;">Course Content:</label>
            <table id="content_table">
                <tr>
                    <th>Module No.</th>
                    <th>Description</th>
                    <th>Time</th>
                </tr>   
                <tr>
                    <td><textarea name="module_no[]" rows="4" required></textarea></td>
                    <td><textarea name="content_description[]" rows="4" required></textarea></td>
                    <td><textarea name="time[]" rows="4" required></textarea></td>
                </tr>
            </table>
            <button type="button" class="add-row-btn" onclick="addRow('content_table')">Add Row</button>
            <button type="button" class="del-row-btn" onclick="delRow('content_table')">Delete Row</button>

            <!-- Textbooks -->
            <label for="textbook"style="margin-top: 10px;">Text Book:</label>
            <table id="textbook_table">
                <tr>
                    <th>No</th>
                    <th>Description</th>
                </tr>
                <!-- Initial row -->
                <tr>
                    <td><textarea name="textbook_no[]" rows="4" required></textarea></td>
                    <td><textarea name="textbook_description[]" rows="4" required></textarea></td>
                </tr>
            </table>
            <button type="button" class="add-row-btn" onclick="addRow('textbook_table')">Add Row</button>
            <button type="button" class="del-row-btn" onclick="delRow('textbook_table')">Delete Row</button>

            <!-- Reference Books -->
            <label for="referencebook"style="margin-top: 10px;">Reference Book:</label>
            <table id="referencebook_table">
                <tr>
                    <th>No</th>
                    <th>Description</th>
                </tr>
                <!-- Initial row -->
                <tr>
                    <td><textarea name="referencebook_no[]" rows="4" required></textarea></td>
                    <td><textarea name="referencebook_description[]" rows="4" required></textarea></td>
                </tr>
            </table>
            <button type="button" class="add-row-btn" onclick="addRow('referencebook_table')">Add Row</button>
            <button type="button" class="del-row-btn" onclick="delRow('referencebook_table')">Delete Row</button>

            <!-- Web References -->
            <label for="webreferences"style="margin-top: 10px;">Web References:</label>
            <table id="webreferences_table">
                <tr>
                    <th>No</th>
                    <th>Description</th>
                </tr>
                <!-- Initial row -->
                <tr>
                    <td><textarea name="webreferences_no[]" rows="4" required></textarea></td>
                    <td><textarea name="webreferences_description[]" rows="4" required></textarea></td>
                </tr>
            </table>
            <button type="button" class="add-row-btn" onclick="addRow('webreferences_table')">Add Row</button>
            <button type="button" class="del-row-btn" onclick="delRow('webreferences_table')">Delete Row</button>

            <!-- Online References -->
            <label for="onlinereferences"style="margin-top: 10px;">Online References:</label>
            <table id="onlinereferences_table">
                <tr>
                    <th>No</th>
                    <th>Description</th>
                </tr>
                <!-- Initial row -->
                <tr>
                    <td><textarea name="onlinereferences_no[]" rows="4" required></textarea></td>
                    <td><textarea name="onlinereferences_description[]" rows="4" required></textarea></td>
                </tr>
            </table>
            <button type="button" class="add-row-btn" onclick="addRow('onlinereferences_table')">Add Row</button>
            <button type="button" class="del-row-btn" onclick="delRow('onlinereferences_table')">Delete Row</button>
                        
            <input type="submit" name="submit" class="save-btn" value="Save Details">

        </form>
    </div>
    <script>
        function addRow(tableId) {
            var table = document.getElementById(tableId);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);

            // Add textarea fields based on table structure
            switch (tableId) {
                case 'objectives_table':
                    // For Course Objectives table
                    addTextarea(row, 'objective[]');
                    addTextarea(row, 'serial[]');
                    break;
                case 'outcomes_table':
                    // For Course Outcomes table
                    addTextarea(row, 'co[]');
                    addTextarea(row, 'description[]');
                    addTextarea(row, 'uup[]');
                    break;
                case 'content_table':
                    // For Course Content table
                    addTextarea(row, 'module_no[]');
                    addTextarea(row, 'content_description[]');
                    addTextarea(row, 'time[]');
                    break;
                case 'textbook_table':
                    // For Textbook table
                    addTextarea(row, 'textbook_no[]');
                    addTextarea(row, 'textbook_description[]');
                    break;
                case 'referencebook_table':
                    // For Reference Book table
                    addTextarea(row, 'referencebook_no[]');
                    addTextarea(row, 'referencebook_description[]');
                    break;
                case 'webreferences_table':
                    // For Web References table
                    addTextarea(row, 'webreferences_no[]');
                    addTextarea(row, 'webreferences_description[]');
                    break;
                case 'onlinereferences_table':
                    // For Online References table
                    addTextarea(row, 'onlinereferences_no[]');
                    addTextarea(row, 'onlinereferences_description[]');
                    break;
                // Add cases for other tables if needed
                default:
                    break;
            }
            
        }
        
        // Function to add textarea fields to a table row
        function addTextarea(row, name) {
            var cell = row.insertCell();
            var textarea = document.createElement('textarea');
            textarea.name = name;
            textarea.rows = "4"; // Set the number of rows
            cell.appendChild(textarea);
        }

        // Function to delete the last row of a table
        function delRow(tableId) {
            var table = document.getElementById(tableId);
            var rowCount = table.rows.length;
            // Ensure that there's at least one row remaining
            if (rowCount > 2) {
                table.deleteRow(rowCount - 1);
            } else {
                alert("At least one row is required!");
            }
        }
    </script>
</body>
</html>

