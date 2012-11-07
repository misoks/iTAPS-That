<?php
session_start();
$username = $_SESSION['username'];
//connect to db
require_once "db.php";
include_once('header.php');

if(isset($_POST['class_id']) && isset($_SESSION['userid'])) {
    $class_id = mysql_real_escape_string($_POST['class_id']);
    $userid = mysql_real_escape_string($_SESSION['userid']);
    $sql = "INSERT INTO Takes (class_id, user_id)
            VALUES ('$class_id', '$userid')";
    mysql_query($sql);
    $course_title = get_title($class_id);
	movePage('manual.php', "$course_title successfully added!", 'success');
    return;
}
?>
   
<h>Select a Class</h>
<form method="post">
<?php
	if(isset($_POST['search'])){
		$search = mysql_real_escape_string($_POST['search']);
		$searchstring = '%'.$search.'%';
		$userprogram = $_SESSION['specialization'];
		$sql2 = "SELECT class_id, title from Class where title LIKE '$searchstring'";
		$result = mysql_query($sql2);

		while($row = mysql_fetch_row($result)){
			echo '<input type = "checkbox" value ="'.htmlentities($row[0]).'" name ="class_id">'.htmlentities($row[1]).'<br>';
		}if ($result){
		if(mysql_num_rows($result) == 0);
			echo "Your search returned no results.<br>";	
		}else{
			echo '<a href="manual.php">Go Back</a>';
	}		
?>
<p><input type="submit" value="Add Class"/></p>
</form>


/* $get = mysql_query("SELECT * FROM users WHERE user_level='1' AND user_level='0'");
while($row = mysql_fetch_array($get)) 
{
	$admin = $row['user_level'];
}
if (isset($_SESSION['username']) && isset($_SESSION['user_level'])) {
	$username = $_SESSION['username'];
	if($_SESSION['user_level'] == 0) {
	echo "<a href='login.php'>Log in</a> | <a href='logout.php'>Log out</a>
		  <h1>Login with User Access</h1>";
	exit();
	} else if ($_SESSION['user_level'] == 1) {
		echo "<a href='login.php'>Log in</a> | <a href='logout.php'>Log out</a>
		 <h1>Login with Admin Access<h1>";
		exit();
	}else{
	echo "<a href = 'manual.php'> Login was unsuccessful </a>";
	exit();
    }
}
?> */

<?php include_once('footer.php'); ?>