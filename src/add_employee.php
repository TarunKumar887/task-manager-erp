<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = trim($_POST['full_name']);
    $email   = trim($_POST['email']);
    $dept_id = intval($_POST['dept_id']);
    $pos     = trim($_POST['position']);
    $sal     = floatval($_POST['salary']);
    $raw_password = $_POST['password'];

    if (empty($name) || empty($email) || empty($raw_password)) {
        header("Location: ../employees.php?error=missing_fields");
        exit();
    }

    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO employees (full_name, email, password, dept_id, position, salary) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisd", $name, $email, $hashed_password, $dept_id, $pos, $sal);

    if ($stmt->execute()) {
        header("Location: ../employees.php?success=added");
        exit();
    } else {
        header("Location: ../employees.php?error=" . urlencode($conn->error));
        exit();
    }
}
?>