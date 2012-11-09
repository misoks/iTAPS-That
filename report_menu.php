<?php

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


	echo "<div id='report-menu' class='absolute'><div class='persp-box'>
	    <h3>My Requirements</h3><ul>";
	while($row = mysql_fetch_row($result)){
		$requirement = $row[0];
		$requirement_name = $row[1];
		
		// Getting a version of the requirement name without spaces for naming tables in HTML and JS
		$req_arr = explode(' ',trim($requirement_name));
        $requirement_id = $req_arr[0];
    
		echo "<li><a id='menu-$requirement_id' href='#$requirement_id'>$requirement_name</a>";
	}	
	echo "
	<li><a id='menu-total' href='#bottom'>Total Credits</a>
	</ul></div></div>";
}

?>