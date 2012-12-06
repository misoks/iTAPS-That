<?php
require_once "setup/db.php";
@include("functions.php");
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo "$page_title - "; ?>iTAPS That</title>
    <link rel=stylesheet href="style.css" type="text/css" media="screen" />
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="script/script.js"></script>
    <script src="script/jquery.scrollTo.js"></script>
    <script src="script/jquery.localscroll.js"></script>
</head>

<?php 
    $title_short = str_replace(' ', '-', $page_title);
    echo "<body id='$title_short'>"; 
?>
<a name="top"></a>
<div id="container">
<div id="header">
    <div id="bar">&nbsp;</div>
    <a id="title" href="index.php">
        <img src="images/logosmall.png">
        <div id="title-text">iTAPS That</div>
    </a>

    <div id="navigation">
        <ul>
            <?php 
            if ($page_title == 'Admin' ) {
                echo "<li>".navLink('logout.php', 'Log Out'); 
            }
            elseif (isset($_SESSION['userid'])) {
                echo "<li>".navLink('report.php', 'My Report');
                echo "<li>".navLink('manual.php', 'Add Classes');
                echo "<li>".navLink('logout.php', 'Log Out');
            } 
            else {
                echo "<li>".navLink('newAccount.php', 'Create an Account');
                echo "<li>".navLink('login.php', 'Log In'); 
            }
            ?>
        </ul>  
    </div>
    <?php if (isset($_SESSION['userid'])) { 
            echo "<div id='greeting'>".greeting()."</div>";
        }
    ?>
</div>

<div id="content">
<div id="header-space"></div>

<?php 
if( isset($_SESSION['message']) )
{
    echo $_SESSION['message']; 
    unset($_SESSION['message']);
}
?>