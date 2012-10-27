<?php
session_start();
require_once "db.php";

 include_once('header.php');
 
if(isset($_SESSION['userid'])){
	$user_id = $_SESSION['userid'];
	$user_program = $_SESSION['specialization'];
	$user_second_program = $_SESSION['second_specialization'];
	$requirements_query = "SELECT DISTINCT r.r_id, r.description, r.credits
							from Requirements r WHERE r.specialization = 'MSI'
							or r.specialization = '$user_program' or 
							r.specialization = '$user_second_program'";
	$result = mysql_query($requirements_query);
	$credits_query = "SELECT SUM(c.credits) FROM Takes t, Class c WHERE
						c.class_id = t.class_id and t.user_id = '$user_id'";
	$me_credits_query = "SELECT SUM(m.credits) FROM Takes t, Manually_Entered_Class m
						WHERE m.class_id = t.class_id and t.user_id = '$user_id'";
	$cq_result = mysql_query($credits_query);
	$me_cq_result = mysql_query($me_credits_query);
	echo '<h1>ITAPS Report</h1><form id="report">';
	$cq_row = mysql_fetch_row($cq_result);
	$me_cq_row = mysql_fetch_row($me_cq_result);
	$total_credits = $cq_row[0] + $me_cq_row[0];
	echo "<p>You have completed ".htmlentities($total_credits)." total credits and have ";
	echo htmlentities(48-$total_credits)." remaining. Classes you have submitted on the 
	    previous page are saved and appear on this report with a check mark next to them. 
	    Below that are classes that you have not yet taken. When you select them on 
	    this report, your credit totals will be updated here, but these classes will not 
	    be saved unless you enter them in on the course entry page.</p>";
	while($row = mysql_fetch_row($result)){
		$requirement = $row[0];
		$requirement_name = $row[1];
		
		// Getting a version of the requirement name without spaces for naming tables in HTML and JS
		$req_arr = explode(' ',trim($requirement_name));
        $requirement_id = $req_arr[0];
        
		$credits = $row[2];
		$taken_credits = 0.0;
		echo "<h2>".htmlentities($requirement_name)."</h2>";
		$taken_class_query = "SELECT c.class_id, c.title, c.link, c.credits, c.pep_credits
								FROM Class c, Takes t, Fulfills f WHERE c.class_id = t.class_id
								AND t.user_id = '$user_id' AND c.class_id = f.class_id AND f.r_id
								= '$requirement' UNION SELECT m.class_id, m.title, m.link, m.credits,
								m.pep_credits FROM Manually_Entered_Class m, Takes t1, Fulfills f1
								WHERE m.class_id = t1.class_id AND t1.user_id = '$user_id' AND 
								m.class_id = f1.class_id AND f1.r_id = '$requirement'";
		$tcq_result = mysql_query($taken_class_query);
		echo '<table border=1px id="manual"><tbody><tr><th class="taken-check">Taken?</th>
		<th class="course-title">Course Title</th><th class="credits">Credits</th><th class="pep">PEP</th></tr>';
		while($row2 = mysql_fetch_row($tcq_result)){
			$taken_credits = $taken_credits + $row2[3];
			echo "<tr><td>";
			echo '<input type="checkbox" value="taken" checked>';
			echo('</td><td class="course-title">');
			if($row2[2] != NULL){
				echo '<a href="'.htmlentities($row2[2]).'">'.htmlentities($row2[1]).'</a>';
			}
			else{
				echo(htmlentities($row2[1]));
			}
			echo("</td><td>");
			echo(htmlentities($row2[3]));
			echo("</td><td>");
			echo(htmlentities($row2[4]));
			echo("</td></tr>\n");
		}
		echo '</table>';
		$remaining_credits = $credits - $taken_credits;
		if($remaining_credits < 0){
			$remaining_credits = 0;
		}	
		echo "<p>";
		echo htmlentities($requirement_name)." requires a minimum of ".htmlentities($credits)." credits.";
		echo "You have completed ".htmlentities($taken_credits)." credits and have ".htmlentities($remaining_credits)." remaining.</p>";
		$remaining_class_query = "SELECT DISTINCT c.class_id, c.title, c.link, c.credits, c.pep_credits
									FROM Class c, Fulfills f WHERE c.class_id = f.class_id and 
									f.r_id = '$requirement' AND NOT EXISTS(SELECT c1.class_id, c1.title,
									c1.credits, c1.pep_credits FROM Class c1, Takes t WHERE t.class_id =
									c1.class_id and t.user_id = '$user_id' and c1.class_id = c.class_id)";
		$rcq_result = mysql_query($remaining_class_query);
		echo '<table border=1px id="'.$requirement_id.'"><tbody><tr><th class="taken-check">Taken?</th>
		<th class="course-title">Course Title</th><th class="credits">Credits</th><th class="pep">PEP</th></tr>';
		while($row3 = mysql_fetch_row($rcq_result)){
			echo "<tr><td>";
			echo '<input type="checkbox" name="'.$requirement_id.'" value="not taken">';
			echo('</td><td class="course-title">');
			if($row3[2] != NULL){
				echo '<a href="'.htmlentities($row3[2]).'">'.htmlentities($row3[1]).'</a>';
			}
			else{
				echo(htmlentities($row3[1]));
			}
			echo("</td><td>");
			echo(htmlentities($row3[3]));
			echo("</td><td>");
			echo(htmlentities($row3[4]));
			echo("</td></tr>\n");
		}
		//echo '<button onlick="countCheckboxes('.'report'.', '.$requirement_id.')">Click me</button>';
		echo'</tbody></table>';
	}
	echo "</form>";
}
else if(!isset($_SESSION['userid'])){
	header('Location: login.php');
}
?>
<br/>
<a href="manual.php">Forgot to add a class? Go back!</a>
<br/>
<a href="logout.php">Logout</a>

<?php include_once('footer.php'); ?>