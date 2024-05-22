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

// Get program details
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $program_id = $_GET['id'];
    $sql = "SELECT id, name FROM programs WHERE id = $program_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $program = $result->fetch_assoc();
    } else {
        echo "Program not found";
        exit;
    }

    // Get POs for the program
    $sql_po = "SELECT id, title, description FROM po WHERE program_id = $program_id";
    $result_po = $conn->query($sql_po);

    // Get PSOs for the program
    $sql_pso = "SELECT id, title, description FROM pso WHERE program_id = $program_id";
    $result_pso = $conn->query($sql_pso);
} else {
    echo "Invalid program ID";
    exit;
}

// Add new PO
if(isset($_POST['po_title']) && isset($_POST['po_description'])) {
    $po_title = $_POST['po_title'];
    $po_description = $_POST['po_description'];
    
    $sql_add_po = "INSERT INTO po (title, description, program_id) VALUES ('$po_title', '$po_description', $program_id)";
    if ($conn->query($sql_add_po) === TRUE) {
        // Refresh the page to reflect the changes
        header("Refresh:0");
    } else {
        echo "Error: " . $sql_add_po . "<br>" . $conn->error;
    }
}

// Add new PSO
if(isset($_POST['pso_title']) && isset($_POST['pso_description'])) {
    $pso_title = $_POST['pso_title'];
    $pso_description = $_POST['pso_description'];
    
    $sql_add_pso = "INSERT INTO pso (title, description, program_id) VALUES ('$pso_title', '$pso_description', $program_id)";
    if ($conn->query($sql_add_pso) === TRUE) {
        // Refresh the page to reflect the changes
        header("Refresh:0");
    } else {
        echo "Error: " . $sql_add_pso . "<br>" . $conn->error;
    }
}

// Delete PO
// Delete PO
if(isset($_GET['delete_po_id'])) {
    $delete_po_id = $_GET['delete_po_id'];
    
    $sql_delete_po = "DELETE FROM po WHERE id = $delete_po_id";
    if ($conn->query($sql_delete_po) === TRUE) {
        // Redirect to the same page without the delete parameter in the URL
        header("Location: {$_SERVER['PHP_SELF']}?id=$program_id");
        exit;
    } else {
        echo "Error: " . $sql_delete_po . "<br>" . $conn->error;
    }
}

// Delete PSO
if(isset($_GET['delete_pso_id'])) {
    $delete_pso_id = $_GET['delete_pso_id'];
    
    $sql_delete_pso = "DELETE FROM pso WHERE id = $delete_pso_id";
    if ($conn->query($sql_delete_pso) === TRUE) {
        // Redirect to the same page without the delete parameter in the URL
        header("Location: {$_SERVER['PHP_SELF']}?id=$program_id");
        exit;
    } else {
        echo "Error: " . $sql_delete_pso . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SKCET - <?php echo $program["name"]; ?></title>
    <link rel="icon" href="15.png">
    <style>
        * {
            margin-top: -7px;
            font-family: Arial, sans-serif;
            padding: 20px;
            
        }
        html{
            background-color: #FFF8DC;
        }
        .container {
            margin-left: 29%;
            margin-top: 20px;
            align-items: center;
            max-width: 800px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            background-color: #a0d2eb;
            border: 1px solid #000; /* Black border */
        }
        h1, h2 {
            color:black;
            text-align: center;
            margin-bottom:10px;
            margin-top:10px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            color: black;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
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
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }

        /* Media Query for Responsive Layout */
        @media only screen and (max-width: 768px) {
            .container {
                margin-left: auto;
                margin-right: auto;
            }
            h1, h2 {
                text-align: center;
            }
            input[type="submit"] {
                margin-left: auto;
                margin-right: auto;
                display: block;
            }
        }
    </style>
</head>
<body>
    <?php include 'header4program.php'; ?>
    <div class="container">
        <h1><?php echo $program["name"]; ?></h1>
        <h2>Add New Program Outcome (PO)</h2>
        <form action="" method="post">
            <input type="hidden" name="program_id" value="<?php echo $program_id; ?>">
            <label for="po_title">PO Title:</label><br>
            <input type="text" id="po_title" name="po_title" required><br>
            <label for="po_description">PO Description:</label><br>
            <textarea id="po_description" name="po_description" required></textarea><br>
            <input type="submit" value="Add PO">
        </form>

        <h2>Add New Program Specific Outcome (PSO)</h2>
        <form action="" method="post">
            <input type="hidden" name="program_id" value="<?php echo $program_id; ?>">
            <label for="pso_title">PSO Title:</label><br>
            <input type="text" id="pso_title" name="pso_title" required><br>
            <label for="pso_description">PSO Description:</label><br>
            <textarea id="pso_description" name="pso_description" required></textarea><br>
            <input type="submit" value="Add PSO">
        </form>

        <form action="add_subjects.php?program_name=<?php echo urlencode($program["name"]); ?>" method="post">
            <input type="hidden" name="program_id" value="<?php echo $program_id; ?>">
            <input type="submit" value="Sem/Batch Selection">
        </form>

        <hr>
        <h1 style="margin-bottom: 10px;">Stored PO & PSO for <?php echo $program["name"]; ?></h1>
        <h2 style="text-align:left;">Program Outcomes (POs)</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result_po->num_rows > 0) {
                while($row = $result_po->fetch_assoc()) {
                    echo "<tr><td><strong>" . $row["title"] . ":</strong></td><td>" . $row["description"] . "</td><td><a href='edit_po.php?id=" . $row["id"] . "'>Edit</a> | <a href='?id=$program_id&delete_po_id=" . $row["id"] . "'>Delete</a></td></tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No POs found for this program</td></tr>";
            }
            ?>
        </table>

        <h2 style="text-align:left;">Program Specific Outcomes (PSOs)</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result_pso->num_rows > 0) {
                while($row = $result_pso->fetch_assoc()) {
                    echo "<tr><td><strong>" . $row["title"] . ":</strong></td><td>" . $row["description"] . "</td><td><a href='edit_pso.php?id=" . $row["id"] . "'>Edit</a> | <a href='?id=$program_id&delete_pso_id=" . $row["id"] . "'>Delete</a></td></tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No PSOs found for this program</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

