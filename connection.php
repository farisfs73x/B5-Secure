<?php
$dbhost = "yourhostname";
$dbuser = "yourdatabaseuser";
$dbpass = "yourdatabasepassword";
$dbname = "yourdatabasename";
if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("Failed to connect!");
}
?>