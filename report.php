<?php
include("db.php");
require_login();

$result = $conn->query("SELECT id, name, rollno, course FROM students ORDER BY id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container wide">
    <h1>Student List</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Roll Number</th>
            <th>Course</th>
            <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo (int)$row['id']; ?></td>
            <td><?php echo e($row['name']); ?></td>
            <td><?php echo e($row['rollno']); ?></td>
            <td><?php echo e($row['course']); ?></td>
            <td>
                <a class="link" href="edit.php?id=<?php echo (int)$row['id']; ?>">Edit</a> |
                <form method="post" action="delete.php" class="inline"
                      onsubmit="return confirm('Delete this student and their attendance records?');">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                    <button type="submit" class="link danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a class="btn" href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
