<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit("Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id      = intval($_POST['id']);
    $name    = trim($_POST['full_name']);
    $dept_id = intval($_POST['dept_id']);
    $pos     = trim($_POST['position']);
    $sal     = floatval($_POST['salary']);
    $new_pass = $_POST['password'];

    if (!empty($new_pass)) {
        $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE employees SET full_name=?, dept_id=?, position=?, salary=?, password=? WHERE id=?");
        $stmt->bind_param("sisdsi", $name, $dept_id, $pos, $sal, $hashed_password, $id);
    } else {
        $stmt = $conn->prepare("UPDATE employees SET full_name=?, dept_id=?, position=?, salary=? WHERE id=?");
        $stmt->bind_param("sisdi", $name, $dept_id, $pos, $sal, $id);
    }

    $stmt->execute();
    $stmt->close();
}

header("Location: ../employees.php?updated=1");
exit();