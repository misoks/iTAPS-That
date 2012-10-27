<?php
session_start();
require_once "db.php";

if ( isset($_POST['username']) && isset($_POST['password'])
	&& ($_POST['specialization'] != -1) && ($_POST['year'] != -1)){
   $u = mysql_real_escape_string($_POST['username']);
   $p = mysql_real_escape_string($_POST['password']);
   $s = mysql_real_escape_string($_POST['specialization']);
   $s2 = mysql_real_escape_string($_POST['second_specialization']);
   $y = mysql_real_escape_string($_POST['year']);
   if($s2 == -1){
		$s2 = "None";
	}
   $sql = "INSERT INTO Student (username, password, specialization, second_spec, year)
				VALUES('$u', '$p', '$s', '$s2', '$y')";
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
   else if(isset($_POST['username']) && isset($_POST['password'])
	&& (($_POST['specialization'] == -1) || ($_POST['year'] == -1))){
	 echo "<p>Account creation failed. Please check to see that you completed all required fields.</p>\n";
      unset($_SESSION['userid']);
	}

?>

<?php include_once('header.php'); ?>

<p>Create an Account</p>
<form method="post">
<p>Username:
<input type="text" name="username"></p>
<p>Password:
<input type="password" name="password"></p>
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
<p>(Optional) Second Specialization:
<select name="second_specialization">
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

<p/>
<input type="submit" value="Submit"/>
</form>

<?php include_once('footer.php'); ?>