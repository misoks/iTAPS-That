<?php
session_start();
require_once "db.php";

if ( isset($_POST['username']) && isset($_POST['password'])) {
   $u = mysql_real_escape_string($_POST['username']);
   $p = mysql_real_escape_string($_POST['password']);
   $sql = "SELECT s.user_id, s.specialization FROM Student s
              WHERE username = '$u' AND password='$p'";
   $result = mysql_query($sql);
   $row = mysql_fetch_row($result);	
   if ( $row === FALSE ) {
      echo "<p>Login incorrect.</p>\n";
      unset($_SESSION['userid']);
   } else { 
      echo "<p>Login success.</p>";
	  echo '<a href="manual.php">Continue...</a>';
      $_SESSION['userid'] = htmlentities($row[0]);
	  $_SESSION['specialization'] = htmlentities($row[1]);
   }
   return;
}
if ( isset($_SESSION['userid']) ) {
   echo('<p><a href="logout.php">Logout</a></p>'."\n");
   return;
}
?>
<p>Login</p>
<form method="post">
<p>Username:
<input type="text" name="username"></p>
<p>Password:
<input type="text" name="password"></p>
<p><input type="submit" value="Login"/>
</form>