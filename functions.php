<?php

//Redirects and can passes a status message to the header of the new page
function movePage($url, $msg, $type) {
    //Types: 'success' or 'error'
    header ("Location: $url?msg=$msg&type=$type");
} 

//Finds the title of a course based on its ID
function get_title($id) {
    $sql = "SELECT title t FROM Class WHERE class_id = $id";
    $result = mysql_query($sql);
    $row = mysql_fetch_row($result);
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