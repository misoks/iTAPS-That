<?php
session_start();
require_once "db.php";
$page_title = "Log In";
include_once('header.php');

if ( isset($_POST['username']) && isset($_POST['password'])) {
   $u = mysql_real_escape_string($_POST['username']);
   $p = mysql_real_escape_string($_POST['password']);
   $sql = "SELECT s.user_id, s.specialization, s.second_spec FROM Student s
              WHERE username = '$u' AND password='$p'";
   $result = mysql_query($sql);
   $row = mysql_fetch_row($result);	
   if ( $row === FALSE ) {
      movePage('login.php', "The username and/or password you entered is incorrect.", 'error');
      unset($_SESSION['userid']);
      include_once('footer.php');
   } else { 
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
	  include_once('footer.php');
   }
   return;
}
if ( isset($_SESSION['userid']) ) {
   header('Location: manual.php');
   return;
}


?>


<h1>Log In</h1>
<form method="post">
<p>Username:
<input type="text" name="username"></p>
<p>Password:
<input type="password" name="password"></p>
<p><input type="submit" value="Login"/>
</form>

<?php include_once('footer.php'); ?>