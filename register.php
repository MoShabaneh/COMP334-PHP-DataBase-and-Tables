<?php
$pdo = include 'dbconfig.in.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Information System</title>
</head>
<body>
    
    <h1>Student Profile</h1>
    <p>To view all students click on the following link <a href="students.php">Students.</a></p>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" style="margin: 10px;"
                value="<?php echo isset($student) ? $student->studentID : ""; ?>"><br><br>

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" style="margin: 10px;"
                value="<?php echo isset($student) ? $student->firstName : ""; ?>">
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" style="margin: 10px;"
                value="<?php echo isset($student) ? $student->lastName : ""; ?>"><br><br>


                <label for="gender">Gender:</label>
<input type="radio" id="gender_male" name="gender" value="1"
    <?php echo (isset($student) && $student->gender == 1) ? 'checked' : ''; ?>>Male</input>
<input type="radio" id="gender_female" name="gender" value="2"
    <?php echo (isset($student) && $student->gender == 2) ? 'checked' : ''; ?>>Female</input><br><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" style="margin: 10px;"
                value="<?php  if (isset($student)) {
                                if ($student->dob) {
                                    $student->dob = date('Y-m-d', strtotime($student->dob));
                                }
                                echo $student->dob;
                              } else {
                                    echo "";
                              }; ?>"><br><br>

        <label for="dep">Department:</label>
        <input type="text" id="dep" name="dep" style="margin: 10px;"
                value="<?php echo isset($student) ? $student->dep : ""; ?>">

        <label for="avg">Average:</label>
        <input type="text" id="avg" name="avg" style="margin: 10px;"
                value="<?php echo isset($student) ? $student->avg : ""; ?>"><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" style="margin: 10px;"
                value="<?php echo isset($student) ? $student->address : ""; ?>"><br><br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" style="margin: 10px;"
                value="<?php echo isset($student) ? $student->city : ""; ?>">
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" style="margin: 10px;"
                value="<?php echo isset($student) ? $student->country : ""; ?>"><br><br>

        <label for="tel">Telephone:</label>
        <input type="text" id="tel" name="tel" style="margin: 10px;" placeholder="+970598363203"
                value="<?php echo isset($student) ? $student->tel : ""; ?>"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" style="margin: 10px;" placeholder= moeshabaneh@gmail.com
                value="<?php echo isset($student) ? $student->email : ""; ?>"><br><br>
        
        <label for="photo">Student Photo:</label>
        <input type="file" id="photo" name="photo" accept=".jpeg,.jpg" style="margin: 10px;"><br><br>

        <button type="submit" name="action" value="insert">Insert</button>
        
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['action']) && $_POST['action'] == 'insert') {
                // Check if file was uploaded
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                    // Check if file is a JPEG image
                    $file_info = getimagesize($_FILES['photo']['tmp_name']);
                    if ($file_info !== false && $file_info[2] === IMAGETYPE_JPEG) {
                        // Move the uploaded file to the 'images' directory and rename it to the student's ID
                        $new_filename = $_POST['student_id'] . '.jpeg';
                        move_uploaded_file($_FILES['photo']['tmp_name'], 'images/' . $new_filename);
                    } else {
                        echo "File is not a JPEG image.";
                        exit;
                    }
                } else {
                    echo "No file was uploaded or there was an error uploading the file.";
                    exit;
                }
                // Insert a new student
                $stmt = $pdo->prepare("INSERT INTO student (studentID, firstName, lastName, gender, dob, dep, avg, address, city, country, tel, email, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$_POST['student_id'], $_POST['first_name'], $_POST['last_name'], $_POST['gender'], $_POST['dob'], $_POST['dep'], $_POST['avg'], $_POST['address'], $_POST['city'], $_POST['country'], $_POST['tel'], $_POST['email'], $new_filename]);
                echo "Student inserted successfully!";
            }
        }
    ?>

</body>
</html>