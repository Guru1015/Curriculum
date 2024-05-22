<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="15.png">
    <title>Practical Page - SKCET</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFF8DC;
        }
        .container {
            width: 95%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #000;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-weight: bold;
            font-size: 18px;
            color: black;
            text-align: center;
            margin: 0;
            padding: 10px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            border-spacing: 1px;
            border: 2px solid #000;
        }
        th, td {
            border: 2px solid #000;
            padding: 8px;
            text-align: justify;
            vertical-align: top;
         
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .btn-download {
            display: block;
            width: 200px;
            padding: 10px;
            margin: 20px auto;
            color: white;
            background-color: royalblue;
            border-radius: 5px;
            border: none;
            text-align: center;
            cursor: pointer;
        }
        .table-title {
            font-weight: bold;
            margin-bottom: 5px;
            padding: 10px;
            text-align: left;
        }
        @media print {
            body {
                margin: 20px;
            }
            .container {
                border: none;
                box-shadow: none;
            }
            .btn-download {
                display: none;
            }
        }
    </style>
</head>
<body>
<?php include 'header4details.php'; ?>
<div class="container" id="container">
    <?php
    if (isset($_GET['subject_name']) && isset($_GET['course_code'])) {
        $course_code = urldecode($_GET['course_code']);

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "me";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM subjects WHERE course_code = '$course_code'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<table style="width: 100%; height: auto;"><tr><td style="text-align:left; font-weight: bold;">' . (isset($row['course_code']) ? strtoupper(htmlspecialchars($row['course_code'])) : 'COURSE CODE') . '</td><td><h1 style="text-transform: uppercase; font-weight: bold;">' . (isset($row['course_title']) ? strtoupper(htmlspecialchars($row['course_title'])) : 'COURSE TITLE') . '</h1></td><td style="text-align:right; font-weight: bold;"><strong></strong> ' . strtoupper(nl2br(htmlspecialchars($row['ltpc']))) . '</td></tr></table>';
                echo '<table>';
                echo '<tr><td colspan="3"><strong>Nature of the Course:<br></strong>Practical - (External Mark: 40/ Internal Mark: 60)<br>End Semester Mark Splitup: <strong>(End Semester Practical Maximum Marks- 100(Weightage- 40%))</strong></td></tr>';
                echo '</table>';

                echo '<table>';
                echo '<tr><th colspan="2">Course Information:</th></tr>';
                echo '<tr><td><strong>Subject Name:</strong></td><td>' . htmlspecialchars($row['course_title']) . '</td></tr>';
                echo '<tr><td><strong>Course Code:</strong></td><td>' . htmlspecialchars($row['course_code']) . '</td></tr>';
                echo '<tr><td><strong>Prerequisites:</strong></td><td>' . nl2br(htmlspecialchars($row['prerequisites'])) . '</td></tr>';
                echo '</table>';


                echo '<table><tr><th colspan="3">Course Objectives:</th></tr>';
                $objectives = explode("$\n", $row['objectives']);
                foreach ($objectives as $index => $objective) {
                    $cells = explode('|', $objective);  // Ensure each cell is trimmed to remove extra spaces
                    echo '<tr>';
                    foreach ($cells as $cell) {
                        echo '<td>' . htmlspecialchars($cell) . '</td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';


                echo '<table><tr><th colspan="3">Course Outcomes: <br>Upon completion of the course, students shall have ability to</th></tr>';
                $outcomes = explode("$\n", $row['outcomes']);
                foreach ($outcomes as $outcome) {
                    $cells = explode('|', $outcome);
                    echo '<tr>';
                    foreach ($cells as $cell) {
                        echo '<td>' . htmlspecialchars($cell) . '</td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';

                echo '<table>';
                echo '<tr><th>S.No</th><th>List of Experiments</th><th>CO Mapping</th><th>RBT</th></tr>';
                $lab_components = explode("$\n", $row['lab_components']); // Changed variable name to lab_components
                foreach ($lab_components as $component) { // Changed variable name to lab_components
                    list($module_no, $description, $co_mapping, $rbt) = explode('|', $component); // Changed variable name to lab_components
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($module_no) . '</td>';
                    echo '<td>' . htmlspecialchars($description) . '</td>';
                    echo '<td>' . htmlspecialchars($co_mapping) . '</td>';
                    echo '<td>' . htmlspecialchars($rbt) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';

                echo '<table><tr><th colspan="2">Text Books:</th></tr>';
                $textbooks = explode("$\n", $row['textbook']);
                foreach ($textbooks as $textbook) {
                    list($no, $description) = explode(' : ', $textbook);
                    echo '<tr><td>' . htmlspecialchars($no) . '</td><td>' . htmlspecialchars($description) . '</td></tr>';
                }
                echo '</table>';

                echo '<table><tr><th colspan="2">Reference Books:</th></tr>';
                $referencebooks = explode("$\n", $row['referencebook']);
                foreach ($referencebooks as $referencebook) {
                    list($no, $description) = explode(' : ', $referencebook);
                    echo '<tr><td>' . htmlspecialchars($no) . '</td><td>' . htmlspecialchars($description) . '</td></tr>';
                }
                echo '</table>';

                echo '<table><tr><th colspan="2">Web References:</th></tr>';
                $webreferences = explode("$\n", $row['webreferences']);
                foreach ($webreferences as $webreference) {
                    list($no, $description) = explode(' : ', $webreference);
                    echo '<tr><td>' . htmlspecialchars($no) . '</td><td>' . htmlspecialchars($description) . '</td></tr>';
                }
                echo '</table>';

                echo '<table><tr><th colspan="2">Online References:</th></tr>';
                $onlinereferences = explode("$\n", $row['onlinereferences']);
                foreach ($onlinereferences as $onlinereference) {
                    list($no, $description) = explode(' : ', $onlinereference);
                    echo '<tr><td>' . htmlspecialchars($no) . '</td><td>' . htmlspecialchars($description) . '</td></tr>';
                }
                echo '</table>';
            }
        } else {
            echo '<h1 style="color:red; text-align:center;">Subject details not found!</h1>';
        }
        $conn->close();
    } else {
        echo '<h1 style="color:red; text-align:center;">Subject name and course code not found!</h1>';
    }
    ?>
    <button class="btn-download" id="downloadButton" onclick="printPage()">Click to Print</button>
</div>
<script>
    function printPage() {
        window.print();
    }   
</script>
</body>
</html>
