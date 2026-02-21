<?php
require_once 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $sql = "DELETE FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
    
        header("Location: ../employees.php?deleted=1");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>