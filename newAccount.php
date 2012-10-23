<?php
session_start();
require_once "db.php";

if ( isset($_POST['username']) && isset($_POST['password'])
	&& isset($_POST['specialization']) && isset($_POST['year'])
	&& is_numeric($_POST['year'])){
   $u = mysql_real_escape_string($_POST['username']);
   $p = mysql_real_escape_string($_POST['password']);
   $s = mysql_real_escape_string($_POST['specialization']);
   $y = mysql_real_escape_string($_POST['year']);
   $sql = "INSERT INTO Student (username, password, specialization, year)
				VALUES('$u', '$p', '$s', '$y')";
   $result = mysql_query($sql);
   if ( $result === FALSE ) {
      echo "<p>Account creation failed. Please enter a different username</p>\n";
	  echo '<a href="newAccount.php">Return...</a>';
      unset($_SESSION['userid']);
   } else { 
      echo "<p>Account creation succeeded.</p>";
	  echo '<a href="login.php">Continue...</a>';
   }
   return;
}
?>
<html>
<head>
    <title>Create an Account - iTAPS That</title>
    <link rel=stylesheet href="style.css" type="text/css" media="screen" />
</head>

<body>

<p>Create an Account</p>
<form method="post">
<p>Username:
<input type="text" name="username"></p>
<p>Password:
<input type="text" name="password"></p>
<p>Specialization:
<select name="specialization">
<option value=-1>Select</option>
<?php
	$sql3 = "SELECT DISTINCT r.specialization FROM Requirements r";
	$result = mysql_query($sql3);
	while($row = mysql_fetch_row($result)){
		echo "<option value=".htmlentities($row[0]).">".htmlentities($row[0])."</option>";
	}
	echo "</select>";
?>
<p/>
<p>Year of Graduation:
<select name="year">
<option value=-1>Select</option>
<?php
	$current_year = intval(date('Y'));
	for($i = ($current_year - 1); $i < ($current_year + 6); $i = $i + 1){
		echo "<option value=".$i.">".$i."</option>";
	}
	echo "</select>";
?>
<!--<option value=2011>2011</option>
<option value=2012>2012</option>
<option value=2013>2013</option>
<option value=2014>2014</option>
<option value=2015>2015</option>-->
<p/>
<input type="submit" value="Submit"/>
</form>

</body>
</html>