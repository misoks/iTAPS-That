<?php
require_once "db.php";
include_once('header.php');
session_start();

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
   
<h2>Select a Class</h2>
<form method="post">
<?php
	if(isset($_POST['search'])){
		$search = mysql_real_escape_string($_POST['search']);
		$searchstring = '%'.$search.'%';
		$userprogram = $_SESSION['specialization'];
		$sql2 = "SELECT class_id, title from Class where title LIKE '$searchstring'";
		$result = mysql_query($sql2);
		
		while($row = mysql_fetch_row($result)){
			echo '<input type = "radio" value ="'.htmlentities($row[0]).'" name ="class_id">'.htmlentities($row[1]).'<br>';
		}if (mysql_num_rows($result) == 0);
			echo "Your search returned no results.<br>";	
		}else{
			echo '<a href="manual.php">Go Back</a>';
	}		
?>
<p><input type="submit" value="Add Class"/></p>
</form>

<?php include_once('footer.php'); ?>
