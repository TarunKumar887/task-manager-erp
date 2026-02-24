<?php
session_start();
require_once 'db.php';
if ($_SESSION['role'] !== 'admin') exit();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("UPDATE departments SET name=? WHERE id=?");
    $stmt->bind_param("si", $_POST['name'], $_POST['id']);
    $stmt->execute();
}
header("Location: ../departments.php");
exit();