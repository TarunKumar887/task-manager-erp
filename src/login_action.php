<?php
session_start();
require_once __DIR__ . '/db.php';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Updated SQL to match our new 'role' column
    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Checking plain text password (as per your current setup)
        if ($pass === $row['password']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role']; // Store 'admin' or 'user'
            
            header("Location: ../dashboard.php");
            exit();
        } else {
            header("Location: ../index.php?error=invalid_password");
            exit();
        }
    } else {
        header("Location: ../index.php?error=user_not_found");
        exit();
    }
}
?>