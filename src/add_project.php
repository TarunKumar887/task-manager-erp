<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['project_name'];
    $desc = $_POST['description'];
    $date = $_POST['deadline'];

    $sql = "INSERT INTO projects (project_name, description, deadline) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $desc, $date);

    if ($stmt->execute()) {
        header("Location: ../projects.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>