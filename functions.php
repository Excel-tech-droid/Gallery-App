<?php

$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'excel123';
$db_name = 'gallery';

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (mysqli_connect_errno()) {
    exit('failed to connect to mysql: ' . mysqli_connect_error());
}
?>

