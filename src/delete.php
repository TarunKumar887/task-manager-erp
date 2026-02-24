<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = intval($_GET['id']);
    $table = "";

   
    if ($type === 'employee') $table = "employees"; 
    if ($type === 'project') $table = "projects";
    if ($type === 'task') $table = "tasks";
    if ($type === 'dept') $table = "departments";

    if ($table !== "") {
        $stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}


header("Location: " . $_SERVER['HTTP_REFERER']);
exit();