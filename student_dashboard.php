<!DOCTYPE html>
<html>
<head>
  <title>SKCET - Student Dashboard</title>
  <link rel="icon" href="15.png">  
  <style>
    * {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 700px;
      margin: 20px auto;
      padding: 20px;
      background-color: #a0d2eb;
      border: 1px solid #000;
    }
    h1 {
      text-align: center;
      color: black;
    }
    select {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #f9f9f9;
      font-size: 16px;
      color: #555;
      cursor: pointer;
    }
    button {
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #45a049;
    }
    .btn {
      margin-top: 50px;
      width: 100%;
      padding: 10px;
      background-color:#ED2939;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
    }
  </style>
</head>
<body>
  <?php include 'header4addsubjects.php'; ?>
  <div class="container">
    <h1>Select Your Programme</h1>
    <form action="subjectdetails.php" method="GET">
      <select name="program_id">
        <option value="">Select a program</option>
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

        // Fetch program names from the database
        $sql = "SELECT id, name FROM programs";
        $result = $conn->query($sql);

        // Store program names and IDs in an array
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
          }
        } else {
          echo "<option value=''>No programs found</option>";
        }

        // Close database connection
        $conn->close();
        ?>
      </select>
      <button type="submit">Submit</button>
    </form>
    <form action="login.php" method="get">
      <button type="submit" class="btn" style="margin-top: 52px;">Logout</button>
    </form>
  </div>
</body>
</html>
