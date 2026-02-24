<?php
$myPassword = 'admin123'; 
echo "Copy this hash for the password <b>$myPassword</b> : <br>";
echo password_hash($myPassword, PASSWORD_DEFAULT);
?>