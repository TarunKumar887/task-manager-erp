<?php
session_start();
require_once __DIR__ . '/db.php';

if (isset($_POST['login'])) {
    $user_input = $_POST['username']; // This could be username or email
    $pass_input = $_POST['password'];

    // 1. FIRST: Check the 'users' table (Admin)
    $sql = "SELECT id, username as login_id, password, role FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user_input);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // 2. SECOND: If not found in users, check the 'employees' table
    if (mysqli_num_rows($result) === 0) {
        $sql = "SELECT id, email as login_id, password, 'employee' as role FROM employees WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $user_input);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($pass_input, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['login_id'];
            $_SESSION['role'] = $row['role'];
            
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