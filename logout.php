<?php
include 'koneksi.php';
session_destroy();
$session_out=mysqli_query($conn,"UPDATE user set last_activity=null where username='".$_SESSION['username']."'");

header("Location: login.php");
exit;
