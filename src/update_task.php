<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit("Unauthorized");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("UPDATE tasks SET project_id=?, employee_id=?, task_description=?, status=? WHERE id=?");
    $stmt->bind_param("iissi", $_POST['project_id'], $_POST['employee_id'], $_POST['task_description'], $_POST['status'], $_POST['id']);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../tasks.php");
exit();