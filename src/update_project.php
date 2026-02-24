<?php
session_start();
require_once 'db.php';
if ($_SESSION['role'] !== 'admin') exit();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("UPDATE projects SET project_name=?, deadline=? WHERE id=?");
    $stmt->bind_param("ssi", $_POST['project_name'], $_POST['deadline'], $_POST['id']);
    $stmt->execute();
}
header("Location: ../projects.php");
exit();