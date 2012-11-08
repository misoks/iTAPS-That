<?php
@include("functions.php");
?>
<html>

<head>
    <title><?php echo "$page_title - "; ?>iTAPS That</title>
    <link rel=stylesheet href="style2.css" type="text/css" media="screen" />
    <script type="text/javascript" src="script.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>

<?php 
    $title_short = str_replace(' ', '-', $page_title);
    echo "<body id='$title_short'>"; 
?>

<div id="container">
<div id="header">
    <div id="bar">&nbsp;</div>
    <a id="title" href="index.php">
        <img src="images/logosmall.png">
        <div id="title-text">iTAPS That</div>
    </a>
    
    <div id="navigation">
        <ul>
            <?php if (isset($_SESSION['userid'])) { ?>
                <li><?php navLink('report.php', 'My Report'); ?>
                <li><?php navLink('manual.php', 'Add Classes'); ?>
                <li><?php navLink('logout.php', 'Log Out'); ?>
            <?php } else { ?>
                <li><?php navLink('newAccount.php', 'Create an Account');?>
                <li><?php navLink('login.php', 'Log In'); ?>
            <?php } ?>
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
if(isset($_GET['msg']) && isset($_GET['type'])) {
    $msg = htmlspecialchars($_GET['msg']);
    if ($msg) {
        $type = htmlspecialchars($_GET['type']);
        echo "<p class='message $type'>$msg</p>";
    }
}
?>