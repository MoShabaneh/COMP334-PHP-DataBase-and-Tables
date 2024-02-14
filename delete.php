<?php
$pdo = include 'dbconfig.in.php';
$studentID = $_GET['id']; // Get the student ID from the URL

$stmt = $pdo->prepare("DELETE FROM student WHERE studentID = ?");
$stmt->execute([$studentID]);

header('Location: students.php'); // Redirect back to the students page
?>