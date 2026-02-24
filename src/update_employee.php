<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit("Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("UPDATE employees SET full_name=?, dept_id=?, position=?, salary=? WHERE id=?");
    $stmt->bind_param("sisdi", $_POST['full_name'], $_POST['dept_id'], $_POST['position'], $_POST['salary'], $_POST['id']);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../employees.php");
exit();