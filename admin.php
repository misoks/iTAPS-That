<?php
session_start();
//connect to db
$page_title = "Admin";
require_once "db.php";
include_once('header.php');

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
    $_SESSION['success'] = 'Record updated';
    header( 'Location: admin.php' ) ;
    return;
}

else if(isset($_POST['title']) && ((trim($_POST['title'])==='') )){
	$_SESSION['error'] = 'Error, check to see that all fields are entered.';
	header( 'Location: admin.php' );
}
else if ( isset($_POST['title']) && isset($_POST['credits']) && (!is_numeric($_POST['credits']))) {
	$_SESSION['error'] = 'Error, value for credits must be numeric.';
	header( 'Location: admin.php' );
	return;
}

if ( isset($_POST['delete']) && isset($_POST['id']) ) {
    $id = mysql_real_escape_string($_POST['id']);
    $sql = "DELETE FROM Class WHERE class_id = $id";
    mysql_query($sql);
    header( 'Location: admin.php' ) ;
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
			$_SESSION['error'] = 'Bad value for id';
			header( 'Location: admin.php' ) ;
			return;
		}
		$title = htmlentities($row[0]);
		$link = htmlentities($row[1]);	
		$credits = htmlentities($row[2]);
		$pep_credits = htmlentities($row[3]);
		$id = htmlentities($row[4]);
	
		echo '<p>Edit Class</p>
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
		<a href="admin.php">Cancel</a></p>
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

		echo "<p>Confirm: Deleting $row[0]</p>\n";
		echo('<form method="post"><input type="hidden" ');
		echo('name="id" value="'.$row[1].'">'."\n");
		echo('<input type="submit" value="Delete" name="delete">');
		echo('<a href="admin.php">Cancel</a>');
		echo("\n</form>\n");
	}
}
?>



<h1>Select a class to edit or delete</h1>

<?php
	$sql = "SELECT c.class_id, c.title FROM Class c";
	$result = mysql_query($sql);
	echo '<table border="1">'."\n";
	while($row = mysql_fetch_row($result)){
	    echo "<tr><td>";
		echo strtrim(htmlentities($row[1]));
		echo("</td><td>\n");
		echo('<a href="admin.php?id='.htmlentities($row[0]).'&action=edit">Edit</a> / ');
		echo('<a href="admin.php?id='.htmlentities($row[0]).'&action=delete">Delete</a>');
		echo("</td></tr>\n");
	}
?>


<?php include_once('footer.php'); ?>