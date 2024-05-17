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

// Check if PO ID is provided
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $po_id = $_GET['id'];
    
    // SQL to delete PO
    $sql_delete_po = "DELETE FROM po WHERE id = $po_id";

    if ($conn->query($sql_delete_po) === TRUE) {
        // Redirect back to the page after deletion
        header("Location: program.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid PO ID";
}
?>
