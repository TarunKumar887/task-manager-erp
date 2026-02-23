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

    if (empty($name) || empty($email) || empty($dept_id)) {
        header("Location: ../employees.php?error=missing_fields");
        exit();
    }

    $sql = "INSERT INTO employees (full_name, email, dept_id, position, salary) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisd", $name, $email, $dept_id, $pos, $sal);

    if ($stmt->execute()) {
        header("Location: ../employees.php?success=added");
        exit();
    } else {
        header("Location: ../employees.php?error=" . urlencode($conn->error));
        exit();
    }
} else {
    header("Location: ../employees.php");
    exit();
}
?>