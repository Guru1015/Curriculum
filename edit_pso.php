<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "me";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get PSO details
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $pso_id = $_GET['id'];
    $sql = "SELECT id, title, description, program_id FROM pso WHERE id = $pso_id";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $pso = $result->fetch_assoc();
    } else {
        echo "PSO not found";
        exit;
    }
} else {
    echo "Invalid PSO ID";
    exit;
}

// Update PSO
if(isset($_POST['pso_title']) && isset($_POST['pso_description'])) {
    $pso_title = $_POST['pso_title'];
    $pso_description = $_POST['pso_description'];
    $program_id = $_POST['program_id'];
    
    $sql_update_pso = "UPDATE pso SET title = '$pso_title', description = '$pso_description' WHERE id = $pso_id";
    if ($conn->query($sql_update_pso) === TRUE) {
        // Redirect to the program page after updating
        header("Location: program.php?id=" . $program_id);
        exit;
    } else {
        echo "Error updating PSO: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SKASC - Edit PSO: <?php echo $pso["title"]; ?></title>
    <link rel="icon" href="New folder/5.png">
    <style>
        * {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            color: white;
        }
        .container {
            margin: 20px auto;
            max-width: 600px;
            padding: 20px;
            border-radius: 8px;
            background-color: rgba(0, 0, 0, 0.35);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }
        h2 {
            margin-top: 0;
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"],
        textarea {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php include 'header4edit_pso.php'; ?>
    <div class="container">
        <h2>Edit PSO: <?php echo $pso["title"]; ?></h2>
        <form action="" method="post">
            <input type="hidden" name="pso_id" value="<?php echo $pso_id; ?>">
            <input type="hidden" name="program_id" value="<?php echo $pso['program_id']; ?>">
            <label for="pso_title">PSO Title:</label>
            <input type="text" id="pso_title" name="pso_title" value="<?php echo $pso["title"]; ?>" required>
            <label for="pso_description">PSO Description:</label>
            <textarea id="pso_description" name="pso_description" rows="4" required><?php echo $pso["description"]; ?></textarea>
            <input type="submit" value="Update PSO">
        </form>
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
