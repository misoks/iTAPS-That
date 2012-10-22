<?php
require_once "db.php";
session_start();

if ( isset($_POST['course_number']) && isset($_POST['title']) 
     && isset($_POST['credits']) && isset($_POST['pep_credits']) 
	 && is_numeric($_POST['credits']) && is_numeric($_POST['pep_credits'])
	 && isset($_POST['requirement'])) {
   $n = mysql_real_escape_string($_POST['course_number']);
   $t = mysql_real_escape_string($_POST['title']);
   $c = mysql_real_escape_string($_POST['credits']);
   $p = mysql_real_escape_string($_POST['pep_credits']);
   $f = $n . " - " . $t;
   $user_id = $_SESSION['userid'];
   $r = mysql_real_escape_string($_POST['requirement']);
   $sql = "INSERT INTO Manually_Entered_Class (title, credits, pep_credits) 
              VALUES ('$f', '$c', '$p')";
	mysql_query($sql);
	$sql2 = "INSERT INTO Takes(user_id, class_id) 
				SELECT '$user_id', m.class_id 
				FROM Manually_Entered_Class m WHERE m.title = '$f'";
	mysql_query($sql2);
	$sql4 = "INSERT INTO Fulfills(r_id, class_id)
				SELECT '$r', m.class_id
				FROM Manually_Entered_Class m WHERE m.title = '$f'";
	mysql_query($sql4);
   return;
  }
else if ( isset($_POST['course_number']) && isset($_POST['title']) 
     && isset($_POST['credits']) && isset($_POST['pep_credits'])
	 && (!is_numeric($_POST['credits']) || !is_numeric($_POST['pep_credits']))) {
	$_SESSION['error'] = 'Error, values for credits and PEP credits must be numeric.';
	return;
}
   

?>
<p>Can't find a class? Enter a new one here!</p>
<form method="post">
<p>Course #:
<input type="text" name="course_number"></p>
<p>Title:
<input type="text" name="title"></p>
<p>Credits:
<input type="text" name="credits"></p>
<p>PEP Credits:
<input type="text" name="pep_credits"></p>
<p>Select which requirement this class fulfills.</p>
<p>If a class fulfills multiple requirements, please enter it multiple times.</p>
<select name="requirement">
<option value=-1>Select</option>
<?php
    $user_program = $_SESSION['specialization'];
	echo "<p>'$user_program'</p>";
	$sql3 = "SELECT r.r_id, r.description from Requirements r WHERE
				r.specialization = '$user_program' or r.specialization = 'MSI'";
	$result = mysql_query($sql3);
	while($row = mysql_fetch_row($result)){
		echo "<option value=".htmlentities($row[0]).">".htmlentities($row[1])."</option>";
	}
?>
<p><input type="submit" value="Submit"/>
</form>

