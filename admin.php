<?php
$user = $_SESSION['username'];
//connect to db
$db = mysql_connect("localhost","kdsoltis", "sql1user") or die('Fail message');//change to your username/password to test on your machine
mysql_select_db("itaps") or die("Fail message");//create itaps db and run createTables, loadData before using these php files
$get = mysql_query("SELECT * FROM users WHERE user_level='1' AND user_level='0'");
while($row = mysql_fetch_array($get)) 
{
	$admin = $row['user_level'];
}
if ($admin == 0) {
	echo "<a href='login.php'>Log in</a> | <a href='logout.php'>Log out</a>
		  <h1>Login with User Access</h1>";
	exit();
}
if ($admin == 1) {
	echo "<a href='login.php'>Log in</a> | <a href='logout.php'>Log out</a>
		  <h1>Login with Admin Access<h1>";
	exit();
}
?>