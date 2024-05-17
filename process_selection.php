<?php
// Database configuration
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

// Initialize variables
$program_name = "";
$subjects = [];

// Retrieve the selected program ID
if(isset($_POST["program_id"]) && !empty($_POST["program_id"])) {
    $program_id = $_POST["program_id"];
    
    // Fetch the name of the selected program
    $sql_program = "SELECT name FROM programs WHERE id = $program_id";
    $result_program = $conn->query($sql_program);
    
    if ($result_program->num_rows > 0) {
        $row_program = $result_program->fetch_assoc();
        $program_name = $row_program["name"];
    }
    
    // Fetch Program Outcomes (POs) based on the selected program ID
    $sql_po = "SELECT title, description FROM po WHERE program_id = $program_id";
    $result_po = $conn->query($sql_po);
    
    // Fetch Program Specific Outcomes (PSOs) based on the selected program ID
    $sql_pso = "SELECT title, description FROM pso WHERE program_id = $program_id";
    $result_pso = $conn->query($sql_pso);
    
    // Fetch subjects related to the selected program grouped by semester
    $sql_subjects = "SELECT semester, GROUP_CONCAT(name) AS subjects FROM subjects WHERE program_id = $program_id GROUP BY semester";
    $result_subjects = $conn->query($sql_subjects);
    
    if ($result_subjects->num_rows > 0) {
        while($row = $result_subjects->fetch_assoc()) {
            $subjects[] = $row;
        }
    }
} else {
    echo "No program selected.";
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>SKASC - Program Details for <?php echo $program_name; ?></title>
    <link rel="icon" href="New folder/5.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            
            margin: 0;
            padding: 0;
            color: #222; /* Dark black */
        }
        .container {
            width: 80%;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.35);    
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }
        h1 {
            margin-top: 15px;
            text-align: center;
            color: white;
        }
        h2 {
            margin-top: 15px;
            color: black;
        }
        table {
            margin-top: 15px;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            margin-top: 15px;
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            margin-top: 15px;
            background-color: #f2f2f2;
            color: #222; /* Dark black */
        }
        .semester {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include 'header4process_selection.php'; ?>
    <div class="container">
        <h1>Program Details for <?php echo $program_name; ?></h1>
        
        <h2>Program Outcomes (POs)</h2>
        <?php if ($result_po->num_rows > 0): ?>
            <?php while($row = $result_po->fetch_assoc()): ?>
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['description']; ?></p>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No POs found for this program</p>
        <?php endif; ?>

        <h2>Program Specific Outcomes (PSOs)</h2>
        <?php if ($result_pso->num_rows > 0): ?>
            <?php while($row = $result_pso->fetch_assoc()): ?>
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['description']; ?></p>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No PSOs found for this program</p>
        <?php endif; ?>

        <h2>Subjects</h2>
        <table>
            <tr>
                <th>Semester</th>
                <th>Subjects</th>
            </tr>
            <?php foreach($subjects as $subject): ?>
            <tr>
                <td class="semester"><?php echo $subject['semester']; ?></td>
                <td><?php echo $subject['subjects']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
