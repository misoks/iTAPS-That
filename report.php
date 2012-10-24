<?php
session_start();
require_once "db.php";
$user_id = $_SESSION['userid'];
$user_program = $_SESSION['specialization'];
$requirements_query = "SELECT DISTINCT r.r_id, r.description, r.credits
						from Requirements r WHERE r.specialization = 'MSI'
						or r.specialization = '$user_program'";
$result = mysql_query($requirements_query);
//echo '<form method="post">';
while($row = mysql_fetch_row($result)){
	$requirement = $row[0];
	echo "<p>".htmlentities($row[1])."</p>";
	$taken_class_query = "SELECT DISTINCT c.class_id, c.title, c.credits, c.pep_credits
							FROM Class c, Takes t, Fulfills f WHERE c.class_id = t.class_id
							AND t.user_id = '$user_id' AND c.class_id = f.class_id AND f.r_id
							= '$requirement'";
	$tcq_result = mysql_query($taken_class_query);
	while($row2 = mysql_fetch_row($tcq_result)){
		echo '<table border="1">'."\n";
		echo "<tr><td>";
		echo '<input type="checkbox" value="taken" checked>';
		echo("</td><td>");
		echo(htmlentities($row2[1]));
		echo("</td><td>");
		echo(htmlentities($row2[2]));
		echo("</td><td>");
		echo(htmlentities($row2[3]));
		echo("</td></tr>\n");
		echo'</table>';
	}
	$remaining_class_query = "SELECT DISTINCT c.class_id, c.title, c.credits, c.pep_credits
								FROM Class c, Fulfills f WHERE c.class_id = f.class_id and 
								f.r_id = '$requirement' AND NOT EXISTS(SELECT c1.class_id, c1.title,
								c1.credits, c1.pep_credits FROM Class c1, Takes t WHERE t.class_id =
								c1.class_id and t.user_id = '$user_id' and c1.class_id = c.class_id)";
	$rcq_result = mysql_query($remaining_class_query);
	while($row3 = mysql_fetch_row($rcq_result)){
		echo '<table border="1">'."\n";
		echo "<tr><td>";
		echo '<input type="checkbox" value="not taken">';
		echo("</td><td>");
		echo(htmlentities($row3[1]));
		echo("</td><td>");
		echo(htmlentities($row3[2]));
		echo("</td><td>");
		echo(htmlentities($row3[3]));
		echo("</td></tr>\n");
		echo'</table>';
	}
	//echo '</form>';
}
?>
