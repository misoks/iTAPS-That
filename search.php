<?php
require_once "db.php";
session_start();

if(isset($_POST['class_id']) && isset($_SESSION['userid'])) {
    $class_id = mysql_real_escape_string($_POST['class_id']);
    $userid = mysql_real_escape_string($_SESSION['userid']);
    $sql = "INSERT INTO takes (class_id, user_id)
            VALUES ('$class_id', '$userid')";
	header( 'Location: manual.php' ) ;
    mysql_query($sql);
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
			echo '<input type = "radio" value ="'.htmlentities($row[0]).'" name ="class_id">'.htmlentities($row[1]).'<br>';
		}
	}
	else{
		echo "Your search returned no results.<br>";
		echo '<a href="manual.php">Go Back</a>';
	}
		
?>
<p><input type="submit" value="Submit"/></p>
</form>
