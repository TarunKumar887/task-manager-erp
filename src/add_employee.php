<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $pos = $_POST['position'];
    $sal = $_POST['salary'];

    $sql = "INSERT INTO employees (full_name, email, position, salary) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssd", $name, $email, $pos, $sal);

    if ($stmt->execute()) {
        header("Location: ../employees.php?success=1");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>