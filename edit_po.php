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

// Get PO details
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $po_id = $_GET['id'];
    $sql = "SELECT id, title, description, program_id FROM po WHERE id = $po_id";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $po = $result->fetch_assoc();
    } else {
        echo "PO not found";
        exit;
    }
} else {
    echo "Invalid PO ID";
    exit;
}

// Update PO
if(isset($_POST['po_title']) && isset($_POST['po_description'])) {
    $po_title = $_POST['po_title'];
    $po_description = $_POST['po_description'];
    $program_id = $_POST['program_id'];
    
    $sql_update_po = "UPDATE po SET title = '$po_title', description = '$po_description' WHERE id = $po_id";
    if ($conn->query($sql_update_po) === TRUE) {
        // Redirect to the program page after updating
        header("Location: program.php?id=" . $program_id);
        exit;
    } else {
        echo "Error updating PO: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>SKCET - Edit PO: <?php echo $po["title"]; ?></title>
    <link rel="icon" href="15.png">
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
            background-color: #a0d2eb;
            border: 1px solid #000; /* Black border */
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
    <?php include 'header4edit_po.php'; ?>
    <div class="container">
        <h2 style="color: #000;">Edit PO: <?php echo $po["title"]; ?></h2>
        <form action="" method="post">
            <input type="hidden" name="po_id" value="<?php echo $po_id; ?>">
            <input type="hidden" name="program_id" value="<?php echo $po['program_id']; ?>">
            <label style="color: #000;" for="po_title">PO Title:</label>
            <input type="text" id="po_title" name="po_title" value="<?php echo $po["title"]; ?>" required>
            <label style="color: #000;" for="po_description">PO Description:</label>
            <textarea id="po_description" name="po_description" rows="4" required><?php echo $po["description"]; ?></textarea>
            <input type="submit" name="update" value="Update PO">
        </form>
    </div>
</body>
</html>
