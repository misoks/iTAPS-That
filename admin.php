<?php
//connect to db
$page_title = "Admin";
session_start();
include_once('header.php');

echo '<h1>Administration</h1>';

// Edit a class
if (isset($_POST['update']) && isset($_POST['title']) && isset($_POST['link']) 
     && isset($_POST['credits']) && is_numeric($_POST['credits']) 
	 && is_numeric($_POST['pep_credits']) && !(trim($_POST['title'])==='')) {
    $title = mysql_real_escape_string($_POST['title']);
    echo $title;
    $link = mysql_real_escape_string($_POST['link']);
    $credits = mysql_real_escape_string($_POST['credits']);
    $pep_credits = mysql_real_escape_string($_POST['pep_credits']);
	$id = mysql_real_escape_string($_POST['id']);
    /*$special = mysql_real_escape_string($_POST['specialization']);
    $description = mysql_real_escape_string($_POST['description']);
    $r_id = mysql_real_escape_string($_POST['r_id']); */
    $sql = " UPDATE Class SET title = '$title', link = '$link',
              credits = '$credits', pep_credits = '$pep_credits' WHERE class_id='$id'" /*AND
              UPDATE Requirements SET specialization = '$special', description = '$description' WHERE r_id = '$r_id'*/;
    mysql_query($sql);
		
    movePage('admin.php', htmlentities(get_title($id)).' Updated Successfully', 'success');
}
else if(isset($_POST['title']) && ((trim($_POST['title'])==='') )){
    $_SESSION['error'] = 'Error, check to see that all fields are entered.';
    header( 'Location: admin.php' );
}	
else if ( isset($_POST['title']) && isset($_POST['credits']) && (!is_numeric($_POST['credits'])) && (!is_numeric($_POST['pep_credits']))) {
    movePage('admin.php', 'Error: Value for credits must be numeric.', 'error');
 	return;	
}

if(isset($_POST['delete'])){
	$id = $_GET['id'];
	$d = mysql_real_escape_string($_POST['delete']);
	$deletesql = "DELETE FROM Fulfills  Where class_id = '$id' and r_id = '$d'";
	$result = mysql_query($deletesql);
	$num = mysql_affected_rows();
}
if(isset($_POST['addto'])){
	$id = $_GET['id'];
	$a = mysql_real_escape_string($_POST['addto']);
	$addsql = "INSERT INTO FULFILLS(r_id, class_id) VALUES ('$a','$id')";
	$result = mysql_query($addsql);
}

if ( isset($_POST['add_course_number']) && isset($_POST['add_title']) && isset($_POST['add_link'])
     && isset($_POST['add_credits']) && isset($_POST['add_pep_credits']) 
	 && is_numeric($_POST['add_credits']) && is_numeric($_POST['add_pep_credits'])
	 && isset($_POST['add_requirement']) ) {
   $n = mysql_real_escape_string($_POST['add_course_number']);
   $t = mysql_real_escape_string($_POST['add_title']);
   $c = mysql_real_escape_string($_POST['add_credits']);
   $p = mysql_real_escape_string($_POST['add_pep_credits']);
   $l = mysql_real_escape_string($_POST['add_link']);
   $f = $n . " - " . $t;
   $r = mysql_real_escape_string($_POST['add_requirement']);
   if(isset($_POST['add_second_requirement'])){ //and second_requirement isnt empty
		$r2  = $_POST['add_second_requirement'];
	}
	else { 
		$r2 = FALSE; 
	}
	$sqlnewclass = "INSERT INTO Class(title, link, credits, pep_credits) VALUES ('$f','$l','$c','$p')";
	mysql_query($sqlnewclass);
	$sqlfulfills = "INSERT INTO Fulfills(r_id, class_id) SELECT '$r', c.class_id from Class c where c.title = '$f'";
	mysql_query($sqlfulfills);
	if($r2){
		$sqlfulfills2 = "INSERT INTO Fulfills(r_id, class_id) SELECT '$r2', c.class_id from Class c where c.title = '$f'";
	}
	mysql_query($sqlfulfills2);
	movePage('admin.php', "$n - $t successfully added!", 'success'); 
  }
  
else if ( isset($_POST['add_course_number']) && isset($_POST['add_title']) && isset($_POST['add_link'])
     && isset($_POST['add_credits']) && isset($_POST['add_pep_credits'])
	 && (!is_numeric($_POST['add_credits']) || !is_numeric($_POST['add_pep_credits']))) {
	movePage('admin.php', "Error, values for credits and PEP credits must be numeric.", 'error');
	return;
}

// Delete a class
if ( isset($_POST['delete']) && isset($_POST['id']) ) {
    $id = mysql_real_escape_string($_POST['id']);
    $course_title = get_title($id);
    $sql = "DELETE FROM Class WHERE class_id = $id";
    mysql_query($sql);
    movePage('admin.php', $course_title.' successfully deleted.', 'success');
}

if(isset($_GET['id'])){
	$id = mysql_real_escape_string($_GET['id']);
	$action = mysql_real_escape_string($_GET['action']);

	if($action == 'edit'){
		$result = mysql_query("SELECT title, link, credits, pep_credits, class_id 
			FROM Class WHERE class_id='$id' ");
		$row = mysql_fetch_row($result);
		if ( $row == FALSE ) {
		    movePage('admin.php', 'Error: Invalid class id', 'error');
      return;
		} 
  
		$title = htmlentities($row[0]);
		$link = htmlentities($row[1]);	
		$credits = htmlentities($row[2]);
		$pep_credits = htmlentities($row[3]);
	
	
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
		    <input type="hidden" name="id" value="'.$id.'">';
			echo'<p><input type="submit" value="Update" name="update"/>
		    <a href="admin.php" class="cancel">Cancel</a></p>
			</form>';
		$reqsql = "SELECT r.r_id, r.description, r.specialization from Requirements r, Fulfills f
		WHERE r.r_id = f.r_id and f.class_id = '$id'";
		$result = mysql_query($reqsql);
		echo '<h2>Remove Requirement</h2>';
		echo '<form method="post">';
		while($row = mysql_fetch_row($result)){
			echo "<div class='list-item'><input type='radio' name='delete' value='$row[0]'><span>".htmlentities($row[2]).' - '.htmlentities($row[1]).'</span></div>';
			echo '<br/>';
		}
		echo'<p><input type="submit" value="Remove" name="remove" />';
		echo'</form>';
		echo '<h2>Add Requirement</h2>';
		echo'<form method="post">';
		$reqsql2 = "SELECT DISTINCT r.r_id, r.description, r.specialization from Requirements r
		WHERE r.r_id NOT IN(SELECT r1.r_id from Requirements r1, Fulfills f WHERE r1.r_id = f.r_id and f.class_id = '$id')";
		$result2 = mysql_query($reqsql2);
		while($row2 = mysql_fetch_row($result2)){
			echo "<div class='list-item'><input type='radio' name='addto' value='$row2[0]'><span>".htmlentities($row2[2]).' - '.htmlentities($row2[1]).'</span></div>';
			echo '<br/>';
		}
		echo'<p><input type="submit" value="Add" name="add"/></p>';
		echo'</form>';
	}
	else if($action == 'delete'){
		$result = mysql_query("SELECT title , class_id FROM Class WHERE class_id='$id'");
		$row = mysql_fetch_row($result);
		if ( $row == FALSE ) {
		  //  movePage('admin.php', 'Error: Invalid class id', 'error');
			return;
		}

		echo "<p>Are you sure you want to delete '$row[0]'?</p>\n";
		echo('<form method="post"><input type="hidden" ');
		echo('name="id" value="'.$row[1].'">'."\n");
		echo('<input type="submit" value="Delete" name="delete">');
		echo('<a href="admin.php" class="cancel">Cancel</a>');
		echo("\n</form>\n");
	}
}
else{

	echo'<div id="add-class">
    <h2>Add a New Class</h2>
    <form method="post">
        <table>
            <tr>
                <td class="label">Course #:</td>
                <td class="input"><input type="text" name="add_course_number" class="course"><em class="example"> e.g. SI 539</em></td>
            </tr>
            <tr>
                <td class="label">Title:</td>
                <td class="input"><input type="text" name="add_title" class="title"><em class="example"> e.g. Design of Complex Websites</em></td>
            </tr>
			<tr>
                <td class="label">Link:</td>
                <td class="input"><input type="text" name="add_link" class="link"><em class="example"> http://umich.edu</em></td>
            </tr>
            <tr>
                <td class="label">Credits:</td>
                <td class="input"><input type="text" name="add_credits" class="credits"><em class="example"> e.g. 3</em></td>
            </tr>
            <tr>
                <td class="label">PEP Credits:</td>
                <td class="input"><input type="text" name="add_pep_credits" class="credits" value="0"><em class="example"> e.g. 0</em></td>
            </tr>
        </table>
        <p>Select which requirement this class fulfills:</p>
        <select name="add_requirement">
        <option value=-1>Select</option>';
    $user_program = $_SESSION['specialization'];
    $user_second_program = $_SESSION['second_specialization'];
    $sql3 = "SELECT DISTINCT r.r_id, r.description,r.specialization from Requirements r";
    $result = mysql_query($sql3);
    while($row = mysql_fetch_row($result)){
        echo "<option value=".htmlentities($row[0]).">".htmlentities($row[2])." - ".htmlentities($row[1])."</option>";
    }
    echo "</select>";
    echo '<p>Optional: Select a second requirement this class also fulfills:</p>
        <select name="add_second_requirement">
        <option value=-1>Select</option>';
	$user_program = $_SESSION['specialization'];
    $user_second_program = $_SESSION['second_specialization'];
    $sql4 = "SELECT DISTINCT r.r_id, r.description,r.specialization from Requirements r";
    $result1 = mysql_query($sql4);
    while($row = mysql_fetch_row($result1)){
		echo "<option value=".htmlentities($row[0]).">".htmlentities($row[2])." - ".htmlentities($row[1])."</option>";
    }
    echo "</select>";
    echo '<p><input type="submit" value="Enter Class"/>
    </form>

<h2>Classes</h2>';

	$sql = "SELECT c.class_id, c.title, c.credits, c.pep_credits, c.link FROM Class c ORDER BY c.title";
	$result = mysql_query($sql);
	echo '<table border="1" id="admin-classes">'."\n";
	echo "<thead><th>Course Title</th><th>Credits</th><th>PEP</th><th class='edit'>Edit</th><th class='delete'>Delete</th></thead>";
	while($row = mysql_fetch_row($result)){
	    echo "<tr><td class='course-title'>";
		echo '<a href="'.htmlentities($row[4]).'">'.htmlentities($row[1]).'</a>';
		echo "</td>";
		echo "<td class='credits'>".htmlentities($row[2])."</td>";
		echo "<td class='pep'>".htmlentities($row[3])."</td>";
		echo '<td class="edit"><a href="admin.php?id='.htmlentities($row[0]).'&action=edit"><img src="images/edit.png" alt="Edit Class"></a></td>';
		echo '<td class="delete"><a href="admin.php?id='.htmlentities($row[0]).'&action=delete"><img src="images/delete.png" alt="Delete Class"></a></td>';
		echo "</td></tr>\n";
	}
	echo '</table>';
}
?>

<?php include_once('footer.php'); ?>