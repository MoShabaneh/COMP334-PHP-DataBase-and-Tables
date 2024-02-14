<?php
$pdo = include 'dbconfig.in.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if file was uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        // Check if file is a JPEG image
        $file_info = getimagesize($_FILES['photo']['tmp_name']);
        if ($file_info !== false && $file_info[2] === IMAGETYPE_JPEG) {
            // Move the uploaded file to the 'images' directory and rename it to the student's ID
            $new_filename = $_POST['studentID'] . '.jpeg';
            if (!move_uploaded_file($_FILES['photo']['tmp_name'], 'images/' . $new_filename)) {
                echo "Failed to move uploaded file.";
                exit;
            }
            $photo = $new_filename;
        } else {
            echo "File is not a JPEG image.";
            exit;
        }
    } else {
        // No new photo was uploaded, keep the old one
        $photo = $_POST['old_photo'];
    }

    // Update the student's details
    $stmt = $pdo->prepare("UPDATE student SET firstName = ?, lastName = ?, avg = ?, dep = ?, photo = ?, email = ?, gender = ?, dob = ?, address = ?, country = ?, city = ?, tel = ? WHERE studentID = ?");
    if (!$stmt->execute([$_POST['firstName'], $_POST['lastName'], $_POST['avg'], $_POST['dep'], $photo, $_POST['email'], $_POST['gender'], $_POST['dob'], $_POST['address'], $_POST['country'], $_POST['city'], $_POST['tel'], $_POST['studentID']])) {
        print_r($stmt->errorInfo());
        exit;
    }
    header('Location: students.php'); // Redirect back to the students page
} else {
    // Fetch the student's details
    $studentID = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM student WHERE studentID = ?");
    $stmt->execute([$studentID]);
    $student = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Student Information System</title>
</head>
<body>
    <h1>Edit Student</h1>
    
    <form action="edit.php" method="post" enctype="multipart/form-data">
        <input type="hidden" id="studentID" name="studentID" value="<?php echo $student['studentID']; ?>">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" style="margin: 10px;"
                value="<?php echo $student['firstName']; ?>">
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" style="margin: 10px;"
                value="<?php echo $student['lastName']; ?>"><br><br>


                <label for="gender">Gender:</label>
<input type="radio" id="gender_male" name="gender" value="1"
    <?php echo ( $student['gender'] == 1 ) ? 'checked' : ''; ?>>Male</input>
<input type="radio" id="gender_female" name="gender" value="2"
    <?php echo ( $student['gender'] == 2 ) ? 'checked' : ''; ?>>Female</input><br><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" style="margin: 10px;"
                value="<?php echo $student['dob']; ?>"><br><br>

        <label for="dep">Department:</label>
        <input type="text" id="dep" name="dep" style="margin: 10px;"
                value="<?php echo $student['dep']; ?>">

        <label for="avg">Average:</label>
        <input type="text" id="avg" name="avg" style="margin: 10px;"
                value="<?php echo $student['avg']; ?>"><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" style="margin: 10px;"
                value="<?php echo $student['address']; ?>"><br><br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" style="margin: 10px;"
                value="<?php echo $student['city']; ?>">
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" style="margin: 10px;"
                value="<?php echo $student['country']; ?>"><br><br>

        <label for="tel">Telephone:</label>
        <input type="text" id="tel" name="tel" style="margin: 10px;" placeholder="+970598363203"
                value="<?php echo $student['tel']; ?>"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" style="margin: 10px;" placeholder= moeshabaneh@gmail.com
                value="<?php echo $student['email']; ?>"><br><br>
        
        <!-- <label for="old_photo">Previous Student Photo:</label><br>
        <img src='images/<?php echo $student['photo']; ?>' width='200' height='200'><br><br>
        <input type="hidden" id="old_photo" name="old_photo" value="<?php echo $student['photo']; ?>"> -->

        <label for="photo">New Student Photo:</label>
        <input type="file" id="photo" name="photo" style="margin: 10px;"><br><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>