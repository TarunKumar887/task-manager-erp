<?php
session_start();
session_unset(); // Good practice to clear variables first
session_destroy();
header("Location: ../index.php"); // The '../' means "go out of the src folder"
exit();
?>