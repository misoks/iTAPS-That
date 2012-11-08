<?php

//Redirects and can passes a status message to the header of the new page
function movePage($url, $msg, $type) {
    //Types: 'success' or 'error'
    header ("Location: $url?msg=$msg&type=$type");
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

//Finds the title of a course based on its ID
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
        echo '<span class="selected">'.$linktext.'</span>';
    }
    else {
        echo '<a href="'.$url.'">'.$linktext.'</a>';
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

?>