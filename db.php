<?php
$db = mysql_connect("localhost","kdsoltis", "sql1user") or die('Fail message');//change to your username/password to test on your machine
mysql_select_db("itaps") or die("Fail message");//create itaps db and run createTables, loadData before using these php files
?>