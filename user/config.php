<?php
$host = "localhost";
$db_name = "qsi_inc";
$db_user = "root";
$db_pass = "";

$conn =mysqli_connect($host,$db_user,$db_pass)or die(mysqli_eror());

mysqli_select_db($conn,$db_name)or die(mysqli_eror());
?>