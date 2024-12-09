<?php
session_start(); //logout session dan akan terus keluar ke login page
session_destroy();
header("Location: login.php");
exit();
?>
