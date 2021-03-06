<?php
session_start();
$page_title = "Create an Account";
include_once('header.php'); 
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
      movePage('newAccount.php', "Sorry, that username has already been taken.", 'error');
      unset($_SESSION['userid']);
      include_once('footer.php');
   } else { 
        $sql = "SELECT s.user_id, s.specialization, s.second_spec FROM Student s
              WHERE username = '$u' AND password='$p'";
        $result = mysql_query($sql);
        $row = mysql_fetch_row($result);	
		if(htmlentities($row[0]) == 1){
			$_SESSION['admin'] = true;
			movePage('admin.php');
		}
		else{
			$_SESSION['userid'] = htmlentities($row[0]);
			$_SESSION['specialization'] = htmlentities($row[1]);
			$_SESSION['second_specialization'] = htmlentities($row[2]);
			movePage('manual.php');
		}
        movePage('manual.php', "Account creation succeeded!", 'success');
	  include_once('footer.php');
   }
   return;
   }
   else if(isset($_POST['username']) && isset($_POST['password'])
	&& (($_POST['specialization'] == -1) || ($_POST['year'] == -1))){
	 movePage('newAccount.php', "Please complete all the required fields.", 'error');
      unset($_SESSION['userid']);
	}

?>



<h1>Create an Account</h1>
<form method="post">
<p>Username:
<input type="text" name="username"></p>
<p>Password:
<input type="password" name="password"></p>
<p>Specialization:
<select name="specialization">
<option value=-1>Select</option>
<?php
	$sql3 = "SELECT DISTINCT r.specialization FROM Requirements r WHERE r.specialization != 'MSI' ";
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
	$sql3 = "SELECT DISTINCT r.specialization FROM Requirements r WHERE r.specialization != 'MSI' ";
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