<?php
include("db.php");
require_login();

$student_count = $conn->query("SELECT COUNT(*) AS c FROM students")->fetch_assoc()['c'];
$attendance_count = $conn->query("SELECT COUNT(*) AS c FROM attendance")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Welcome, <?php echo e($_SESSION['admin']); ?></h1>

    <h2>Total Students: <?php echo (int)$student_count; ?></h2>
    <h2>Total Attendance Records: <?php echo (int)$attendance_count; ?></h2>

    <a class="btn" href="students.php">Add Student</a><br>
    <a class="btn" href="report.php">View Students</a><br>
    <a class="btn" href="attendance.php">Mark Attendance</a><br>
    <a class="btn" href="attendance_report.php">Attendance Report</a><br>
    <a class="btn" href="logout.php">Logout</a>
</div>
</body>
</html>
