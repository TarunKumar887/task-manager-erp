<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $p_id = $_POST['project_id'];
    $e_id = $_POST['employee_id'];
    $desc = $_POST['task_description'];

    $sql = "INSERT INTO tasks (project_id, employee_id, task_description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $p_id, $e_id, $desc);

    if ($stmt->execute()) {
        header("Location: ../tasks.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>