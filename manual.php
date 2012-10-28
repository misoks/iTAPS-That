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
	
else if ( isset($_POST['course_number']) && isset($_POST['title']) 
     && isset($_POST['credits']) && isset($_POST['pep_credits']) 
	 && is_numeric($_POST['credits']) && is_numeric($_POST['pep_credits'])
	 && isset($_POST['requirement']) && isset($_SESSION['userid'])) {
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
	if(isset($_SESSION['second_requirement'])){
		$r2  = $_SESSION['second_requirement'];
		$sql5 = "INSERT INTO Fulfills(r_id, class_id)
				SELECT '$r2', m.class_id
				FROM Manually_Entered_Class m WHERE m.title = '$f'";
		mysql_query($sql5);
	}
	header( 'Location: manual.php' ) ;
   return;
  }
  
else if ( isset($_POST['course_number']) && isset($_POST['title']) 
     && isset($_POST['credits']) && isset($_POST['pep_credits'])&& isset($_SESSION['userid'])
	 && (!is_numeric($_POST['credits']) || !is_numeric($_POST['pep_credits']))) {
	$_SESSION['error'] = 'Error, values for credits and PEP credits must be numeric.';
	header( 'Location: manual.php' ) ;
	return;
}
else if(!isset($_SESSION['userid'])){
	header('Location: login.php');
}
?>

<h1>Select a Class</h1>
<form method="post">
<select name= "class_id">
<option value=-1>Select</option>
<?php
	$user_program = $_SESSION['specialization'];
	$sql_3 = "SELECT class_id, title FROM class";
	$result = mysql_query($sql_3);
	while($row = mysql_fetch_row($result)){
		echo "<option value=".htmlentities($row[0]).">".htmlentities($row[1])."</option>";
	}
?>
<p><input type="submit" value="Submit"/></p>
</form>
<p/>
<h1>Search for a Class</h1>
<form method="post" action="search.php">
<p><input type="text" name="search">
<input type="submit" value="Submit"/>
</form>
<p/>
<h1>Can't find a class? Enter a new one here!</h1>
<form method="post">
<p>Course #:
<input type="text" name="course_number"> example:<i> SI 539</i></p>
<p>Title:
<input type="text" name="title"><i> Design of Complex Websites</i></p>
<p>Credits:
<input type="text" name="credits"><i> 3</i></p>
<p>PEP Credits:
<input type="text" name="pep_credits"><i> 0</i></p>
<p>Select which requirement this class fulfills:</p>
<select name="requirement">
<option value=-1>Select</option>
<?php
    $user_program = $_SESSION['specialization'];
	$user_second_program = $_SESSION['second_specialization'];
	$sql3 = "SELECT r.r_id, r.description from Requirements r WHERE
				r.specialization = '$user_program' or r.specialization = 'MSI'
				or r.specialization = '$user_second_program'";
	$result = mysql_query($sql3);
	while($row = mysql_fetch_row($result)){
		echo "<option value=".htmlentities($row[0]).">".htmlentities($row[1])."</option>";
	}
	echo "</select>";
?>
<p>Optional: Select a second requirement this class also fulfills:</p>
<select name="second_requirement">
<option value=-1>Select</option>
<?php
	$user_program = $_SESSION['specialization'];
    $user_second_program = $_SESSION['second_specialization'];
	$sql4 = "SELECT r.r_id, r.description from Requirements r WHERE
				r.specialization = '$user_program' or r.specialization = 'MSI'
				or r.specialization = '$user_second_program'";
	$result1 = mysql_query($sql4);
	while($row = mysql_fetch_row($result1)){
		echo "<option value=".htmlentities($row[0]).">".htmlentities($row[1])."</option>";
	}
	echo "</select>";
?>
<p><input type="submit" value="Submit"/>
<br/>
<p>Not sure which requirement this class fulfills? Check the
<a href="http://www.si.umich.edu/academics/msi/msi-degree-components">MSI Degree Components</a>
page to find out.</p>
<p>Disclaimer: Be sure to check with an academic advisor to see which requirements a class fulfills.</p>
</form>
<form method="get" action="http://localhost/si664/itaps/report.php">
<p><input type="submit" value="Generate Report"/></p>
</form>
<a href="logout.php">Logout</a>