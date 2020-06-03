
<?php
$servername = "localhost";
$username = "root";
$password = "Psshv@3522";
$database="Home automation";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$database);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>


