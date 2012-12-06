<?php
require_once "setup/db.php";
session_start();
$page_title = "Add Classes";
include_once('header.php');

if(isset($_POST['delete']) && $_POST['delete'] != -1) {
	$class_id = mysql_real_escape_string($_POST['delete']);
	remove_class($class_id, 'manual.php');
}

else if(isset($_POST['class_id']) && isset($_SESSION['userid'])) {
    $class_id = mysql_real_escape_string($_POST['class_id']);
    add_class($class_id, 'manual.php');
}
	
else if ( isset($_POST['course_number']) && isset($_POST['title']) 
     && isset($_POST['credits']) && isset($_POST['pep_credits']) 
	 && is_numeric($_POST['credits']) && is_numeric($_POST['pep_credits'])
	 && isset($_POST['requirement']) && isset($_SESSION['userid']) ) {
   $n = mysql_real_escape_string($_POST['course_number']);
   $t = mysql_real_escape_string($_POST['title']);
   $c = mysql_real_escape_string($_POST['credits']);
   $p = mysql_real_escape_string($_POST['pep_credits']);
   $f = $n . " - " . $t;
   $r = mysql_real_escape_string($_POST['requirement']);
   if(isset($_POST['second_requirement'])){ //and second_requirement isnt empty
		$r2  = $_POST['second_requirement'];
	}
	else { $r2 = FALSE; }
	manual_add_class($n, $t, $c, $p, $f, $r, $r2);
  }
  
else if ( isset($_POST['course_number']) && isset($_POST['title']) 
     && isset($_POST['credits']) && isset($_POST['pep_credits'])&& isset($_SESSION['userid'])
	 && (!is_numeric($_POST['credits']) || !is_numeric($_POST['pep_credits']))) {
	movePage('manual.php', "Error, values for credits and PEP credits must be numeric.", 'error');
	return;
}
else if(!isset($_SESSION['userid'])){
	header('Location: login.php');
}
?>
<h1>Add Classes</h1>
<p>Use this page to enter the classes you've already taken or are currently taking, either 
    by selecting them from the drop-down, searching for them by course number or title, or
    manually entering courses you can't find. The courses you enter will appear in 
    <a href="report.php">your report</a>.</p>
<div id="enter-classes">
    <div id="select-class">
        <h2>Select a Class</h2>
        <form method="post">
        <select name= "class_id">
        <option value=-1>Select</option>
        <?php
            $user_program = $_SESSION['specialization'];
            $sql_3 = "SELECT class_id, title FROM Class ORDER BY title ASC";
            $result = mysql_query($sql_3);
            while($row = mysql_fetch_row($result)){
                echo "<option value=".htmlentities($row[0]).">".strtrim(htmlentities($row[1]))."</option>";
            }
        ?>
        <p><input type="submit" value="Add Class"/></p>
        </form>
    </div>
    <div id="or">- or -</div>
    <div id="search-class">
        <h2>Search for a Class</h2>
        <form method="post" action="search.php">
        <p><input type="text" name="search">
        <input type="submit" value="Search"/>
        </form>
        <p/>
    </div>
</div>
<div id="added-classes">
		<h2>Added Classes</h2>
		<form method="post">
		    <div class="two-col-list">
            <?php
                $userid = $_SESSION['userid'];
                $sql_myclasses = "SELECT c.class_id, c.title FROM Class c, Takes t
                                    WHERE c.class_id = t.class_id and t.user_id = 
                                    '$userid' UNION SELECT m.class_id, m.title from 
                                    Manually_Entered_Class m, Takes t1 WHERE m.class_id =
                                    t1.class_id and t1.user_id = '$userid'";
                $result = mysql_query($sql_myclasses);
                while($row = mysql_fetch_row($result)){
                    echo "<div class='list-item'><input type='radio' name='delete' value='$row[0]'><span>".htmlentities($row[1]).'</span></div>';
                }
            ?>
            </div>
		<p><input type="submit" value="Remove"/></p>
		</form>
	</div>
<div id="manual-entry">
    <h2>Can't find a class? Enter one manually!</h2>
    <form method="post">
        <table>
            <tr>
                <td class="label">Course #:</td>
                <td class="input"><input type="text" name="course_number" class="course"><em class="example"> e.g. SI 539</em></td>
            </tr>
            <tr>
                <td class="label">Title:</td>
                <td class="input"><input type="text" name="title" class="title"><em class="example"> e.g. Design of Complex Websites</em></td>
            </tr>
            <tr>
                <td class="label">Credits:</td>
                <td class="input"><input type="text" name="credits" class="credits"><em class="example"> e.g. 3</em></td>
            </tr>
            <tr>
                <td class="label">PEP Credits:</td>
                <td class="input"><input type="text" name="pep_credits" class="credits" value="0"><em class="example"> e.g. 0</em></td>
            </tr>
        </table>
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
        <p><input type="submit" value="Enter Class"/>
    </form>
    <p>Not sure which requirement this class fulfills? Check the
        <a href="http://www.si.umich.edu/academics/msi/msi-degree-components">MSI Degree Components</a>
        page to find out.</p>
</div>
<p id="view-report"><a href="report.php">View Report</a></p>

<?php include_once('footer.php'); ?>