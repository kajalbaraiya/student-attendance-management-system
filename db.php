<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli("localhost", "root", "", "attendance_db");
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $ex) {
    die("Database connection failed: " . $ex->getMessage());
}

/* Escape output (prevents XSS) */
function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

/* Redirect to login if admin is not logged in */
function require_login()
{
    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
        exit();
    }
}

/* CSRF protection helpers */
function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function csrf_verify()
{
    if (
        empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        http_response_code(403);
        die("Invalid request.");
    }
}
?>