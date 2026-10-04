<?php
include("db.php");
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT id, name, rollno, course FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    header("Location: report.php");
    exit();
}

$message = "";

if (isset($_POST['update'])) {
    csrf_verify();
    $name = trim($_POST['name']);
    $rollno = trim($_POST['rollno']);
    $course = trim($_POST['course']);

    if ($name === "" || $rollno === "" || $course === "") {
        $message = "All fields are required.";
    } else {
        try {
            $upd = $conn->prepare("UPDATE students SET name = ?, rollno = ?, course = ? WHERE id = ?");
            $upd->bind_param("sssi", $name, $rollno, $course, $id);
            $upd->execute();
            header("Location: report.php");
            exit();
        } catch (mysqli_sql_exception $ex) {
            $message = ($ex->getCode() == 1062)
                ? "Another student already has this roll number."
                : "Could not update student.";
        }
    }
    // keep what the user typed
    $row['name'] = $name;
    $row['rollno'] = $rollno;
    $row['course'] = $course;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Edit Student</h1>

    <?php if ($message) echo "<p class='msg error'>" . e($message) . "</p>"; ?>

    <form method="post">
        <?php echo csrf_field(); ?>
        <input type="text" name="name" value="<?php echo e($row['name']); ?>" required>
        <input type="text" name="rollno" value="<?php echo e($row['rollno']); ?>" required>
        <input type="text" name="course" value="<?php echo e($row['course']); ?>" required>
        <input type="submit" name="update" value="Update Student">
    </form>

    <a class="btn" href="report.php">Back</a>
</div>
</body>
</html>
