<?php
include("db.php");
require_login();

$message = "";
$is_error = false;

if (isset($_POST['save'])) {
    csrf_verify();
    $student_id = (int)$_POST['student_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    $d = DateTime::createFromFormat('Y-m-d', $date);
    $valid_date = $d && $d->format('Y-m-d') === $date;

    if ($student_id <= 0 || !$valid_date || !in_array($status, ['Present', 'Absent'], true)) {
        $message = "Please select a student, a valid date and a status.";
        $is_error = true;
    } else {
        // If attendance already exists for this student+date, update it
        $stmt = $conn->prepare(
            "INSERT INTO attendance(student_id, date, status) VALUES(?, ?, ?)
             ON DUPLICATE KEY UPDATE status = VALUES(status)"
        );
        $stmt->bind_param("iss", $student_id, $date, $status);
        $stmt->execute();
        $message = "Attendance Saved Successfully";
    }
}

$students = $conn->query("SELECT id, name, rollno FROM students ORDER BY name");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Mark Attendance</h1>

    <?php if ($message) echo "<p class='msg " . ($is_error ? "error" : "") . "'>" . e($message) . "</p>"; ?>

    <form method="post">
        <?php echo csrf_field(); ?>

        <select name="student_id" required>
            <option value="">-- Select Student --</option>
            <?php while ($s = $students->fetch_assoc()) { ?>
                <option value="<?php echo (int)$s['id']; ?>">
                    <?php echo e($s['name'] . " (" . $s['rollno'] . ")"); ?>
                </option>
            <?php } ?>
        </select>

        <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>

        <select name="status">
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
        </select>

        <input type="submit" name="save" value="Save Attendance">
    </form>

    <a class="btn" href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
