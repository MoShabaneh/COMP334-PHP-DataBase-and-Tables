<?php
$pdo = include 'dbconfig.in.php';
$studentID = $_GET['id']; // Get the student ID from the URL

$stmt = $pdo->prepare("SELECT * FROM student WHERE studentID = ?");
$stmt->execute([$studentID]);
$student = $stmt->fetch();
?>
<!DOCTYPE html>
<html>
<head>
<title>Student Information System</title>
</head>
<body>
    <p><img src='images/<?php echo $student['photo']; ?>' width='200' height='200'></p>
    
    <h1>Student ID: <?php echo $student['studentID']; ?>, Name: <?php echo $student['firstName'] . " " . $student['lastName'];?></h1>
    <ul>
        <li>Average: <?php echo $student['avg']; ?></li>
        <li>Department: <?php echo $student['dep']; ?></li>
        <li>Date of birth: <?php echo $student['dob']; ?></li>
    </ul>
    <h2>Contacts</h2>
    <p>Send Email to: <?php echo $student['email']; ?></p>
    <p>Tel: <?php echo $student['tel']; ?></p>
    
    <p>Address: <?php echo $student['city'] . ' ' . $student['country'] ?></p>

    <p><a href="students.php">Back to Students</a></p>
</body>
</html>