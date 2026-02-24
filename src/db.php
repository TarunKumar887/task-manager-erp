<?php

$host = 'sql306.infinityfree.com';
$user = 'if0_41234153';
$pass = 'ERPmanager2026';
$dbname = 'if0_41234153_erp_db'; 

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>