<?php
session_start();
require_once __DIR__ . '/db.php';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    
    $sql = "SELECT id, username, password, role_id FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    
    mysqli_stmt_bind_param($stmt, "s", $user);
    
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        
        if ($pass === $row['password']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role_id'] = $row['role_id'];
            
            header("Location: ../dashboard.php");
            exit();
        } else {
            header("Location: ../index.php?error=1");
            exit();
        }
    } else {
        header("Location: ../index.php?error=1");
        exit();
    }
}
?>