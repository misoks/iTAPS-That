<?php
session_start();
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


  if(isset($_POST['delete']) && $_POST['delete'] != -1) {	
    $class_id = mysql_real_escape_string($_POST['delete']);
    $userid = mysql_real_escape_string($_SESSION['userid']);
 	 	$sql = "DELETE FROM Takes  WHERE user_id = '$userid' and class_id = '$class_id'";
    mysql_query($sql);
 	 	$course_title = get_title($class_id);	
    if(mysql_affected_rows() == 1){	
    movePage('manual.php',"$course_title successfully removed!", 'success');
    }	
    else{	
    movePage('manual.php',"$course_title was not able to be removed. Please try again.", 'error');
 	   }	
    return;
}
?>


<h1>Select a Class</h1>
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
		}if(mysql_num_rows($result) == 0);
			echo "Your search returned no results.<br>";	
		}else{
			echo '<a href="manual.php">Go Back</a>';
	}		
?>
<p><input type="submit" value="Add Class"/></p>
</form>

</td>
<td id="added-classes">
<h2>View/Remove My Classes</h2>	
<form method="post">
<select name= "delete">
<option value=-1>View/Select</option>
<?php
$userid = $_SESSION['userid'];
 	$sql_myclasses = "SELECT c.class_id, c.title FROM Class c, Takes t
  WHERE c.class_id = t.class_id and t.user_id = 
 	'$userid' UNION SELECT m.class_id, m.title from 
  Manually_Entered_Class m, Takes t1 WHERE m.class_id =
  t1.class_id and t1.user_id = '$userid'";
  $result = mysql_query($sql_myclasses);
  while($row = mysql_fetch_row($result)){
    echo "<option value=".htmlentities($row[0]).">".strtrim(htmlentities($row[1]))."</option>";
 }
?>
p><input type="submit" value="Delete"/></p>
</form></td></tr></table>



<?php include_once('footer.php'); ?>