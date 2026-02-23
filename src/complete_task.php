<?php
require_once 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Update the status to Completed
    $sql = "UPDATE tasks SET status = 'Completed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../tasks.php?updated=1");
        exit(); // Stops the script here so the redirect happens cleanly
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: ../tasks.php");
    exit();
}
?>