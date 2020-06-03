<?php
session_start();
session_unset();
$_SESSION='';
session_destroy();
header('Location: /ha/login.php');
exit();
?>
