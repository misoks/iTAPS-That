<?php
session_start();
//connect to db
$page_title = "Admin";
require_once "db.php";
include_once('header.php');

echo '<h1>Select a Class to Edit as an Administrator</h1>';

if ( isset($_POST['title']) && isset($_POST['link']) 
     && isset($_POST['credits']) && is_numeric($_POST['credits'])
	 && is_numeric($_POST['pep_credits']) && !(trim($_POST['title'])==='')) {
    $title = mysql_real_escape_string($_POST['title']);
	$link = mysql_real_escape_string($_POST['link']);
	$credits = mysql_real_escape_string($_POST['credits']);
    $pep_credits = mysql_real_escape_string($_POST['pep_credits']);
    $sql = "UPDATE Class SET title = '$title', link = '$link',
              credits = '$credits', pep_credits = '$pep_credits' WHERE class_id='$id'"; 
    mysql_query($sql);
    movePage('admin.php', "Class '$title' updated successfully.", 'success');
    return;
}

else if(isset($_POST['title']) && ((trim($_POST['title'])==='') )){
	movePage('admin.php', "Make sure you've filled in all fields.", 'error');
}
else if ( isset($_POST['title']) && isset($_POST['credits']) && (!is_numeric($_POST['credits'])) && (!is_numeric($_POST['pep_credits']))) {
	movePage('admin.php', 'Error, value for credits must be numeric.', 'error');
	return;
}

if ( isset($_POST['delete']) && isset($_POST['id']) ) {
    $id = mysql_real_escape_string($_POST['id']);
    $course_title = get_title($id);
    $sql = "DELETE FROM Class WHERE class_id = $id";
    mysql_query($sql);
    movePage('admin.php', "$course_title has been deleted.", 'success');
    return;
}
if(isset($_GET['id'])){
	$id = mysql_real_escape_string($_GET['id']);
	$action = mysql_real_escape_string($_GET['action']);

	if($action == 'edit'){
		$result = mysql_query("SELECT title, link, credits, pep_credits, class_id 
			FROM Class WHERE class_id='$id'");
		$row = mysql_fetch_row($result);
		if ( $row == FALSE ) {
		    movePage('admin.php', "Course ID could not be found.", 'error');
			return;
		}
		$title = htmlentities($row[0]);
		$link = htmlentities($row[1]);	
		$credits = htmlentities($row[2]);
		$pep_credits = htmlentities($row[3]);
		$id = htmlentities($row[4]);
	
		echo '<h2>Edit Class</h2>
		<form method="post">
		<p>Title:
		<input type="text" name="title" value="'.$title.'"></p>
		<p>Link:
		<input type="text" name="link" value="'.$link.'"></p>	
		<p>Credits:	
		<input type="text" name="credits" value="'.$credits.'"></p>
		<p>Pep Credits:
		<input type="text" name="pep_credits" value="'.$pep_credits.'"></p>
		<input type="hidden" name="id" value=".'.$id.'">
		<p><input type="submit" value="Update"/>
		<a href="admin.php" class="cancel">Cancel</a></p>
		</form>';
	}
	else if($action == 'delete'){
		$result = mysql_query("SELECT title , class_id FROM Class WHERE class_id='$id'");
		$row = mysql_fetch_row($result);
		if ( $row == FALSE ) {
			$_SESSION['error'] = 'Bad value for id';
			header( 'Location: admin.php' ) ;
			return;
		}

		echo "<p>Are you sure you want to delete $row[0]?</p>\n";
		echo('<form method="post"><input type="hidden" ');
		echo('name="id" value="'.$row[1].'">'."\n");
		echo('<input type="submit" value="Delete" name="delete">');
		echo('<a class="cancel" href="admin.php">Cancel</a>');
		echo("\n</form>\n");
	}
}
?>



<h2>Classes</h2>

<?php
	$sql = "SELECT c.class_id, c.title FROM Class c";
	$result = mysql_query($sql);
	echo '<table border="1" id="admin-classes">'."\n";
	while($row = mysql_fetch_row($result)){
	    echo "<tr><td class='course-title'>";
		echo htmlentities($row[1]);
		echo("</td>");
		echo('<td class="edit" width = "15%"><a href="admin.php?id='.htmlentities($row[0]).'&action=edit"><center><img src="images/edit.png">Edit</center></a></td> ');
		echo('<td class="delete" width = "85%"><a href="admin.php?id='.htmlentities($row[0]).'&action=delete"><center><img src="images/delete.png">Delete</center></a></td>');
		echo("</td></tr>\n");
	}
	echo '</table>';
?>

<?php include_once('footer.php'); ?>


