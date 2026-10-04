<?php
include("db.php");
require_login();

$message = "";
$is_error = false;

if (isset($_POST['save'])) {
    csrf_verify();
    $name = trim($_POST['name']);
    $rollno = trim($_POST['rollno']);
    $course = trim($_POST['course']);

    if ($name === "" || $rollno === "" || $course === "") {
        $message = "All fields are required.";
        $is_error = true;
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO students(name, rollno, course) VALUES(?, ?, ?)");
            $stmt->bind_param("sss", $name, $rollno, $course);
            $stmt->execute();
            $message = "Student Added Successfully";
        } catch (mysqli_sql_exception $ex) {
            $message = ($ex->getCode() == 1062)
                ? "A student with this roll number already exists."
                : "Could not add student.";
            $is_error = true;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Add Student</h1>

    <?php if ($message) echo "<p class='msg " . ($is_error ? "error" : "") . "'>" . e($message) . "</p>"; ?>

    <form method="post">
        <?php echo csrf_field(); ?>
        <input type="text" name="name" placeholder="Enter Name" required>
        <input type="text" name="rollno" placeholder="Enter Roll Number" required>
        <input type="text" name="course" placeholder="Enter Course" required>
        <input type="submit" name="save" value="Save Student">
    </form>

    <a class="btn" href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
