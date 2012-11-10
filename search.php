<?php
session_start();
require_once "db.php";
$page_title = "Search";
include_once('header.php');

if(isset($_POST['class_id']) && isset($_SESSION['userid'])) {
    $class_id = mysql_real_escape_string($_POST['class_id']);
    add_class($class_id, 'manual.php');
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
		
		if (mysql_num_rows($result) != 0) {
		    while($row = mysql_fetch_row($result)) {
			    echo '<input type = "radio" value ="'.htmlentities($row[0]).'" name ="class_id">'.htmlentities($row[1]).'<br>';
		    }
		    echo '<p><input type="submit" value="Add Class"/><a class="cancel" href="manual.php">Go Back</a></p>';
		}
		else {
			echo "<p>Your search returned no results.</p>";
			echo '<p><a href="manual.php">Go Back</a></p>';	
		}
	}		
?>

</form>

<?php include_once('footer.php'); ?>
