<?php

//Redirects and can passes a status message to the header of the new page
function movePage($url, $msg, $type) {
    //Types: 'success' or 'error'
    $_SESSION['message'] = "<p class='message $type'>$msg</p>";
    header ("Location: $url");
} 

//Sets a greeting message for logged in users
function greeting() {
    $id = $_SESSION['userid'];
    $sql = "SELECT u.username FROM Student u where user_id = $id";
    $result = mysql_query($sql);
    $row = mysql_fetch_row($result);
    $username = htmlentities($row[0]);
    
    $messages = array();
    $messages[] = "How are those PEP credits lookin'?";
    $messages[] = "Finished your Management requirement yet?";
    $messages[] = "Is there a SISA Happy Hour tonight?";
    $messages[] = "It's only two years, you can do it.";
    $messages[] = "Hope this is helping your information overload.";
    $messages[] = "It's not about the grades, it's about the journey.";
    $num = rand(0, 5);
    return "<span id='user'>Welcome back, $username!</span><br><span id='msg'>$messages[$num]</span>";
}

//Checks for duplicate course
function check_duplicate($cid) {
    $uid = $_SESSION['userid'];
    $sql = "SELECT 1 FROM Takes WHERE user_id = $uid and class_id= $cid LIMIT 1";
    $result = mysql_query($sql);
    if (mysql_num_rows($result) != 1) {
        return FALSE;
    }
    else {
        return TRUE;
    }
}

//Returns the user's specialization(s)
function get_specialization() {
    $id = $_SESSION['userid'];
    $sql = "SELECT u.specialization, u.second_spec FROM Student u where user_id = $id";
    $result = mysql_query($sql);
    $row = mysql_fetch_row($result);
    $spec1 = htmlentities($row[0]);
    $spec2 = htmlentities($row[1]);
    if ($spec2 == 'None' ) {
        return "Specialization: $spec1";
    }
    else {
        return "Specializations: $spec1, $spec2";
    }
}

//Converts the requirement name into a text ID that can be used by CSS & JS
function make_req_id($name) {
    $name = str_replace('(', '', $name);
    $name = str_replace(')', '', $name);
    $name = str_replace('-', '', $name);
    $name = str_replace(',', '', $name);
    $id = str_replace(' ', '', $name);
    return $id;
}

//Returns the title of a course based on its ID
function get_title($id) {
    if ($id < 999 ) {
        $sql = "SELECT c.title FROM Class c WHERE class_id = $id";
        $result = mysql_query($sql);
        $row = mysql_fetch_row($result);
    }
	else {
		$sql = "SELECT m.title FROM Manually_Entered_Class m WHERE class_id = $id";
		$result = mysql_query($sql);
		$row = mysql_fetch_row($result);
	}
    return htmlentities($row[0]);
}
    
//Checks for current page and modifies nav links accordingly
function navLink($url, $linktext) {
    $current = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    if ($url == $current) {
        return '<span class="selected">'.$linktext.'</span>';
    }
    else {
        return '<a href="'.$url.'">'.$linktext.'</a>';
    }
}

//Trims course names in drop-down so the box isn't super wide
function strtrim($str, $maxlen=40, $elli='...', $maxoverflow=5) {
    global $CONF;
    if (strlen($str) > $maxlen) {
        if ($CONF["BODY_TRIM_METHOD_STRLEN"]) {
            return substr($str, 0, $maxlen);
        }
        $output = NULL;
        $body = explode(" ", $str);
        $body_count = count($body);
        $i=0;
        do {
            $output .= $body[$i]." ";
            $thisLen = strlen($output);
            $cycle = ($thisLen < $maxlen && $i < $body_count-1 && ($thisLen+strlen($body[$i+1])) < $maxlen+$maxoverflow?true:false);
            $i++;
        } while ($cycle);
        return $output.$elli;
    }
    else return $str;
}

// Adds regular classes
function add_class($class_id, $location) {
    //Location is the page you want it to reload on after the class is added
    $course_title = get_title($class_id);
    $userid = mysql_real_escape_string($_SESSION['userid']);
    if (check_duplicate($class_id) ==TRUE) {
        movePage($location, "$course_title has already been added!", 'error');
    }
    else {
        $sql = "INSERT INTO Takes (class_id, user_id)
                VALUES ('$class_id', '$userid')";
        mysql_query($sql);
        movePage($location, "$course_title successfully added!", 'success');
	}
}

// Adds Manual Entry classes
function manual_add_class($n, $t, $c, $p, $f, $r, $r2) {
    $user_id = $_SESSION['userid'];
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
	if ($r2) {
		$sql5 = "INSERT INTO Fulfills(r_id, class_id)
				SELECT '$r2', m.class_id
				FROM Manually_Entered_Class m WHERE m.title = '$f'";
		mysql_query($sql5);
	}
	movePage('manual.php', "$n - $t successfully added!", 'success'); 
}


// Deletes regular and manual classes
function delete_class($class_id, $location) {
    $userid = mysql_real_escape_string($_SESSION['userid']);  
    $course_title = get_title($class_id);  
    if ($class_id < 999) {
        $sql = "DELETE FROM Takes WHERE user_id = $userid and class_id = $class_id";
	    mysql_query($sql);
    }
    else {
        $sql = "DELETE FROM Manually_Entered_Class WHERE class_id = $class_id";
        mysql_query($sql);
        $sql2 = "DELETE FROM Takes WHERE user_id = $userid and class_id = $class_id";
        mysql_query($sql2);
    }
    if(mysql_affected_rows() == -1 ){
	    movePage($location,"$course_title was not able to be removed. Please try again.", 'error');
	}
	else {
		movePage($location,"$course_title successfully removed!", 'success');
	}
}

?>