<?php
session_start();
require_once "db.php";
$page_title = "My Report";
include_once('header.php');
include_once('report_menu.php');


echo '<script>
$(function() {
    var fixadent = $("#report-menu"), pos = fixadent.offset();
    $(window).scroll(function() {
        if($(this).scrollTop() > (pos.top + 5)) { 
            fixadent.removeClass("absolute"); 
            fixadent.addClass("fixed"); 
        }
        else if($(this).scrollTop() <= pos.top && fixadent.hasClass("fixed")){ 
            fixadent.removeClass("fixed"); 
            fixadent.addClass("absolute"); 
        }
    })
});</script>';

if(isset($_POST['add'])) {
	$class_id = mysql_real_escape_string($_POST['add']);
	add_class($class_id, 'report.php');
}
if(isset($_POST['delete']) && $_POST['delete'] != -1) {
	$class_id = mysql_real_escape_string($_POST['delete']);
	remove_class($class_id, 'report.php');
}

 $running_total = 0;
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
	echo '<h1>My Report</h1>';
	echo '<h3 class="overview-spec">'.get_specialization().'</h3>';
	
	$cq_row = mysql_fetch_row($cq_result);
	$me_cq_row = mysql_fetch_row($me_cq_result);
	$total_credits = $cq_row[0] + $me_cq_row[0];
	$running_total = $running_total + $total_credits;
	$total_remaining = 48 - $total_credits;
	if ($total_remaining < 0) { $total_remaining = 0; }
	echo "<p>Classes you have submitted on the <a href='manual.php'>Add Classes</a> page are saved and appear on this 
	    report with a check mark next to them. Below them are classes that you have not 
	    yet taken that can help you fulfill your requirements.</p>";
	/*if ($total_remaining == 0) {
	    echo "<p class='summary completed'>You have completed ".htmlentities($total_credits)." credits and thus your 
	    overall MSI credit requirement! Check below to see if you still have any requirements
	    left to fulfill.";
	}
	else {
	    echo "<p class='summary uncompleted'>You have completed ".htmlentities($total_credits)." total credits and have ";
	    echo htmlentities($total_remaining)." still to complete.</p>";
	}*/
	
	while($row = mysql_fetch_row($result)){
		$requirement = $row[0];
		$requirement_name = $row[1];
        $requirement_id = make_req_id($requirement_name);
		$testedout = false;
		$testedout502 = false;
		$taken502 = false;
		$credits = $row[2];
		$taken_credits = 0.0;
		echo '<div id="requirement-block">';
		echo '<h2><a name="'.htmlentities($requirement_id).'">'.htmlentities($requirement_name)."</a></h2>";
		echo '<a class="top-link" href="#top">Top</a>';
		
		// ALL courses a user has taken 
		$taken_class_query = "SELECT c.class_id, c.title, c.link, c.credits, c.pep_credits
								FROM Class c, Takes t, Fulfills f WHERE c.class_id = t.class_id
								AND t.user_id = '$user_id' AND c.class_id = f.class_id AND f.r_id
								= '$requirement' UNION SELECT m.class_id, m.title, m.link, m.credits,
								m.pep_credits FROM Manually_Entered_Class m, Takes t1, Fulfills f1
								WHERE m.class_id = t1.class_id AND t1.user_id = '$user_id' AND 
								m.class_id = f1.class_id AND f1.r_id = '$requirement'";
		$tcq_result = mysql_query($taken_class_query);
		$num_rows = mysql_num_rows($tcq_result);
        echo '<table border=0px class="taken"><tr><thead><th class="taken-check">Taken?</th>
        <th class="course-title">Course</th><th class="credits">Credits</th><th class="pep">PEP</th></thead></tr><tbody>';
        while($row2 = mysql_fetch_row($tcq_result)){
			if($row2[1] == 'SI 502 - Networked Computing: Storage, Communication, and Processing'){
				$taken502 = true;
			}
			if($row2[3] == 0 && $requirement_name != 'Foundations'){
				$testedout = true;
			}
			else if($row2[3] == 0 && $requirement_name == 'Foundations'){
				$testedout502 = true;
			}
			$taken_credits = $taken_credits + $row2[3];
			echo "<tr><td>";
			echo '<form method="post">	
			<input type="submit" value="'.htmlentities($row2[0]).'" name="delete">
				</form>';
			echo('</td><td class="course-title">');
			if($row2[2] != NULL){
				echo '<a href="'.htmlentities($row2[2]).'">'.htmlentities($row2[1]).'</a>';	
			}
			else{
				echo(htmlentities($row2[1]));
			}
			echo("</td><td>");
			echo(htmlentities($row2[3]));
			echo("</td><td class='last-col'>");
			echo(htmlentities($row2[4]));
			echo("</td></tr>\n");
		}
		if($requirement_name == 'Foundations' && $taken_credits == 6 &&
			($taken502 == false) && $testedout502){
			$testedout = true;
		}
		
        if ( $taken_credits >= $credits || $testedout) {
            echo '<tr class="total-row complete">';
            echo '<script>
                var menuitem = $("#menu-'.$requirement_id.'")
                menuitem.addClass("complete"); 
            </script>';
        }
        else {
            echo '<tr class="total-row incomplete">';
            echo '<script>
                var menuitem = $("#menu-'.$requirement_id.'")
                menuitem.addClass("incomplete"); 
            </script>';
        }
        echo '<td></td><td class="total">Total:</td><td>'.htmlentities($taken_credits).' / '.htmlentities($credits).'</td><td class="last-col"></td></tr>';
        echo '</table>';
        
        
        // Credit requirements
		$remaining_credits = $credits - $taken_credits;
		if($testedout502 && ($taken502 == false)){
			$remaining_credits = $remaining_credits - 3;
		}
		$requirement_name_mod = str_replace(' Credits', '', $requirement_name);
		if($remaining_credits < 0) {
			$remaining_credits = 0;
		}
		if ($remaining_credits == 0 || $testedout) {
		    echo "<p class='summary completed'> You have completed the $requirement_name_mod requirement! </p>";
		}
		else {
            echo "<p class='summary uncompleted'>";
          //  echo htmlentities($requirement_name)." requires a minimum of ".htmlentities($credits)." credits.";
            echo "You need ".htmlentities($remaining_credits)." more $requirement_name_mod credits.</p>";
		}
		
		// Classes from database
		$remaining_class_query = "SELECT DISTINCT c.class_id, c.title, c.link, c.credits, c.pep_credits
									FROM Class c, Fulfills f WHERE c.class_id = f.class_id and 
									f.r_id = '$requirement' AND NOT EXISTS(SELECT c1.class_id, c1.title,
									c1.credits, c1.pep_credits FROM Class c1, Takes t WHERE t.class_id =
									c1.class_id and t.user_id = '$user_id' and c1.class_id = c.class_id)";
		$rcq_result = mysql_query($remaining_class_query);
		$num_rows = mysql_num_rows($rcq_result);
		if ( $num_rows > 0 ) {
            echo '<table border=0px id="'.htmlentities($requirement_id).'-untaken" class="untaken"><thead><tr><th class="taken-check">Taken?</th>
            <th class="course-title">Course</th><th class="credits">Credits</th><th class="pep">PEP</th></tr></thead><tbody>';
            while($row3 = mysql_fetch_row($rcq_result)){
                echo "<tr><td>";
                echo '
                <form method="post">
                <input type="submit" value="'.htmlentities($row3[0]).'" name="add">
                </form>';
                echo('</td><td class="course-title">');
                if($row3[2] != NULL){
                    echo '<a href="'.htmlentities($row3[2]).'">'.htmlentities($row3[1]).'</a>';
                }
                else{
                    echo(htmlentities($row3[1]));
                }
                echo("</td><td>");
                echo(htmlentities($row3[3]));
                echo("</td><td class='last-col'>");
                echo(htmlentities($row3[4]));
                echo("</td></tr>\n");
            }
            echo'</tbody></table>';
		}
		echo '</div>';
	}
	//classes that dont fulfill any requirements should show up here
	echo "<h2>Other Classes</h2>";
	$taken_credits = 0;
	$otherclasses_sql = "(SELECT c.class_id, c.title, c.link, c.credits, c.pep_credits FROM Class c,
							Takes t WHERE c.class_id = t.class_id and t.user_id = '$user_id' and 
							c.class_id NOT IN (SELECT f.class_id FROM Fulfills f,
							Requirements r WHERE f.r_id = r.r_id and (r.specialization = 'MSI' or
							r.specialization = '$user_program' or r.specialization = '$user_second_program')))
							UNION (SELECT m.class_id, m.title, m.link, m.credits, m.pep_credits FROM 
							Manually_Entered_Class m, Takes t WHERE m.class_id = t.class_id and t.user_id = '$user_id' and 
							m.class_id NOT IN (SELECT f.class_id FROM Fulfills f,
							Requirements r WHERE f.r_id = r.r_id and (r.specialization = 'MSI' or
							r.specialization = '$user_program' or r.specialization = '$user_second_program')))";
	$other_class_result = mysql_query($otherclasses_sql);
	echo '<table border=0px id="other" class="taken"><tr><thead><th class="taken-check">Taken?</th>
        <th class="course-title">Course</th><th class="credits">Credits</th><th class="pep">PEP</th></thead></tr><tbody>';
        while($row5 = mysql_fetch_row($other_class_result)){
            $taken_credits = $taken_credits + $row5[3];
            echo "<tr><td>";
            echo '<form method="post">
                <input type="submit" value="'.htmlentities($row5[0]).'" name="delete">
                </form>';
            echo('</td><td class="course-title">');
            if($row5[2] != NULL){
                echo '<a href="'.htmlentities($row5[2]).'">'.htmlentities($row5[1]).'</a>';
            }
            else{
                echo(htmlentities($row5[1]));
            }
            echo("</td><td>");
            echo(htmlentities($row5[3]));
            echo("</td><td>");
            echo(htmlentities($row5[4]));
            echo("</td></tr>\n");
        }
        echo '<tr class="total-row"><td></td><td class="total">Total:</td><td>'.htmlentities($taken_credits).'</td><td></td></tr>';
        echo '</table>';
	
}
else if(!isset($_SESSION['userid'])){
	header('Location: login.php');
}
?>

<?php echo '<div id="total-credits">Total MSI Credits: ';
if ($total_credits > 48) {
    echo '<span class="completed">'.htmlentities($total_credits)."/48</span></div>"; 
    echo '<script>
                var menuitem = $("#menu-total")
                menuitem.addClass("complete"); 
            </script>';
}
else {
    echo '<span class="uncompleted">'.htmlentities($total_credits)."/48</span></div>"; 
    echo '<script>
                var menuitem = $("#menu-total")
                menuitem.addClass("incomplete"); 
        </script>';
}
?>
<p id="add-more"><a href="manual.php">Add More Classes</a></p>



<?php include_once('footer.php'); ?>