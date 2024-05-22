<!DOCTYPE html>
<html>
<head>
  <title>SKCET - Subject Details</title>
  <link rel="icon" href="15.png">  
  <style>
    * {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .container {
        margin: 20px auto;
        max-width: 800px;
        padding: 20px;
        background-color: #a0d2eb;
        border: 1px solid #000; /* Black border */
    }
    h1 {
      text-align: center;
      color: #333;
      margin-top: 20px;
    }
    h2{
      text-align: left;
      color: #333;
      margin-top: 20px;
    }
    p {
      margin: 10px 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }
    table, th, td {
        border: 2px solid #000;
    }
    th, td {
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    .view-btn {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 5px 10px;
      cursor: pointer;
      border-radius: 3px;
      text-decoration: none;
    }
    .view-btn:hover {
      background-color: #45a049;
    }
  </style>
  <script>
    function viewSubject(subjectId, subjectName, courseCode, natureOfCourse) {
      var form = document.getElementById('viewForm');
      switch (natureOfCourse.toLowerCase()) {
        case 'theory':
          form.action = 'theoryview.php';
          break;
        case 'practical':
          form.action = 'practicalview.php';
          break;
        case 'theory_practical':
          form.action = 'theory_practicalview.php';
          break;
        default:
          form.action = 'otherpage.php';
      }
      var subjectIdInput = document.createElement('input');
      subjectIdInput.type = 'hidden';
      subjectIdInput.name = 'subject_id';
      subjectIdInput.value = subjectId;
      form.appendChild(subjectIdInput);
      
      var subjectNameInput = document.createElement('input');
      subjectNameInput.type = 'hidden';
      subjectNameInput.name = 'subject_name';
      subjectNameInput.value = subjectName;
      form.appendChild(subjectNameInput);
      
      var courseCodeInput = document.createElement('input');
      courseCodeInput.type = 'hidden';
      courseCodeInput.name = 'course_code';
      courseCodeInput.value = courseCode;
      form.appendChild(courseCodeInput);
      
      form.submit();
    }
  </script>
</head>
<body>
<?php include 'header4addsubjects.php'; ?>
  <div class="container">
    <h1>Details for <?php 
        if (isset($_GET['program_id']) && !empty($_GET['program_id'])) {
            $program_id = $_GET['program_id'];
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

            // Fetch program name from the database
            $stmt = $conn->prepare("SELECT name FROM programs WHERE id = ?");
            $stmt->bind_param("i", $program_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo htmlspecialchars($row['name']);
            } else {
                echo "Unknown Program";
            }

            // Close database connection
            $stmt->close();
            $conn->close();
        } else {
            echo "Unknown Program";
        }
    ?></h1>
    <?php
    if (isset($_GET['program_id']) && !empty($_GET['program_id'])) {
      $program_id = $_GET['program_id'];

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

      // Fetch POs from the database
      $po_sql = "SELECT title, description FROM po WHERE program_id = ?";
      $po_stmt = $conn->prepare($po_sql);
      $po_stmt->bind_param("i", $program_id);
      $po_stmt->execute();
      $po_result = $po_stmt->get_result();

      // Fetch PSOs from the database
      $pso_sql = "SELECT title, description FROM pso WHERE program_id = ?";
      $pso_stmt = $conn->prepare($pso_sql);
      $pso_stmt->bind_param("i", $program_id);
      $pso_stmt->execute();
      $pso_result = $pso_stmt->get_result();

      echo "<h2>Program Outcomes (POs)</h2>";
      if ($po_result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Title</th><th>Description</th></tr>";
        while($row = $po_result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
          echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
          echo "</tr>";
        }
        echo "</table>";
      } else {
        echo "<p>No POs found for the selected program.</p>";
      }

      echo "<h2>Program Specific Outcomes (PSOs)</h2>";
      if ($pso_result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Title</th><th>Description</th></tr>";
        while($row = $pso_result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
          echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
          echo "</tr>";
        }
        echo "</table>";
      } else {
        echo "<p>No PSOs found for the selected program.</p>";
      }

      // Fetch subject details from the database
      $sql = "SELECT id, name, semester, batch, nature_of_course, course_code FROM subjects WHERE program_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $program_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        echo "<h2>Subject Details</h2>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Semester</th><th>Batch</th><th>Nature of Course</th><th>Action</th></tr>";

        while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
          echo "<td>" . htmlspecialchars($row["semester"]) . "</td>";
          echo "<td>" . htmlspecialchars($row["batch"]) . "</td>";
          echo "<td>" . htmlspecialchars($row["nature_of_course"]) . "</td>";
          echo "<td><button class='view-btn' onclick=\"viewSubject(" . $row["id"] . ", '" . htmlspecialchars($row["name"]) . "', '" . htmlspecialchars($row["course_code"]) . "', '" . $row["nature_of_course"] . "')\">View</button></td>";
          echo "</tr>";
        }

        echo "</table>";
      } else {
        echo "<p>No subjects found for the selected program.</p>";
      }

      // Close database connection
      $stmt->close();
      $conn->close();
    } else {
      echo "<p>Invalid program ID.</p>";
    }
    ?>
    <form id="viewForm" method="GET" style="display:none;">
      <!-- Form will be populated dynamically with JavaScript -->
    </form>
  </div>
</body>
</html>
