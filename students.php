<?php
$pdo = include 'dbconfig.in.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Student Information System</title>
<style>
    table {
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid black;
        padding: 5px;
    }
    .table {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
    }
</style>
</head>
<body>
<p>To Register a new student click on the following link <a href="register.php">Register.</a></p>
<p>Or use the actions below to edit or delete a student's record.</p><br>
<div class="table">
    <p> Students Table Results</p>
    <table>
        <tr>
            <th>Student Photo</th>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Average</th>
            <th>Department</th>
            <th>Actions</th>
        </tr>
        <?php
        $stmt = $pdo->prepare("SELECT * FROM student");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td><img src='images/" . $row['photo'] . "' width='100' height='100'></td>";
            echo "<td><a href='view.php?id=" . $row['studentID'] . "'>" . $row['studentID'] . "</a></td>";
            echo "<td>" . $row['firstName'] . " " . $row['lastName'] . "</td>";
            echo "<td>" . $row['avg'] . "</td>";
            echo "<td>" . $row['dep'] . "</td>";
            echo "<td>";
            echo "<button onclick=\"location.href='edit.php?id=" . $row['studentID'] . "'\"><img src='edit.png' alt='Edit'></button>";
            echo "<button onclick=\"location.href='delete.php?id=" . $row['studentID'] . "'\"><img src='delete.png' alt='Delete'></button>";            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>