<?php
include("config.php");
session_start();

$user=$_POST['user'];
$pass=$_POST['pass'];

//echo $user."###".$pass;
$sql = "SELECT id, user, user FROM users where user='".$user."' AND pwd='".$pass."'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  $_SESSION['userid']=$user;
echo $_SESSION['userid'];
  header('location:/ha/index.php');
} else {
  $SESSION['userid']='';
  header('location:/ha/login.php?err=1');
}

?>