<?php
include("db.php");
require_login();

$filter = isset($_GET['date']) ? $_GET['date'] : "";
$d = DateTime::createFromFormat('Y-m-d', $filter);
$has_filter = $d && $d->format('Y-m-d') === $filter;

$sql = "SELECT a.id, s.name, s.rollno, a.date, a.status
        FROM attendance a
        JOIN students s ON s.id = a.student_id";

if ($has_filter) {
    $stmt = $conn->prepare($sql . " WHERE a.date = ? ORDER BY s.name");
    $stmt->bind_param("s", $filter);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql . " ORDER BY a.date DESC, s.name");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container wide">
    <h1>Attendance Report</h1>

    <form method="get" class="filter">
        <input type="date" name="date" value="<?php echo $has_filter ? e($filter) : ''; ?>">
        <input type="submit" value="Filter">
        <a class="btn small" href="attendance_report.php">Clear</a>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Roll No</th>
            <th>Date</th>
            <th>Status</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo (int)$row['id']; ?></td>
            <td><?php echo e($row['name']); ?></td>
            <td><?php echo e($row['rollno']); ?></td>
            <td><?php echo e($row['date']); ?></td>
            <td class="<?php echo $row['status'] === 'Present' ? 'present' : 'absent'; ?>">
                <?php echo e($row['status']); ?>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a class="btn" href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
