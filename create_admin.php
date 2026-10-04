<?php
/* Run once to create the first admin, then DELETE this file. */
include("db.php");

$message = "";
$exists = $conn->query("SELECT COUNT(*) AS c FROM admin")->fetch_assoc()['c'] > 0;

if ($exists) {
    $message = "An admin already exists. Delete this file.";
} elseif (isset($_POST['create'])) {
    csrf_verify();
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username === "" || strlen($password) < 6) {
        $message = "Username required and password must be at least 6 characters.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO admin(username, password) VALUES(?, ?)");
        $stmt->bind_param("ss", $username, $hash);
        $stmt->execute();
        $message = "Admin created. Delete create_admin.php now, then log in.";
        $exists = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Create Admin</h1>
    <?php if ($message) echo "<p class='msg'>" . e($message) . "</p>"; ?>
    <?php if (!$exists) { ?>
    <form method="post">
        <?php echo csrf_field(); ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password (min 6 chars)" required>
        <input type="submit" name="create" value="Create Admin">
    </form>
    <?php } ?>
    <a class="btn" href="login.php">Go to Login</a>
</div>
</body>
</html>
