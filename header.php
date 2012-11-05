<?php
function navLink($url, $linktext) {
    $current = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    if ($url == $current) {
        echo $linktext;
    }
    else {
        echo '<a href="'.$url.'">'.$linktext.'</a>';
    }
}
?>
<html>

<head>
    <title>iTAPS That Project</title>
    <link rel=stylesheet href="style.css" type="text/css" media="screen" />
    <script type="text/javascript" src="script.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>

<body>

<div id="site-name">
    <a href="index.php">iTaps That</a>
</div>

<div id="navigation">
    <ul>
        <li><?php navLink('report.php', 'My Report'); ?>
        <li><?php navLink('manual.php', 'Enter Classes'); ?>
        <li><?php if ($_SESSION['userid']) { 
            echo '<a href="logout.php">Log Out</a>'; } else { echo '<a href="login.php">Log In</a>'; } ?>
    </ul>  
</div>