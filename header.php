<?php
@include("functions.php");
?>
<html>

<head>
    <title>iTAPS That Project</title>
    <link rel=stylesheet href="style.css" type="text/css" media="screen" />
    <script type="text/javascript" src="script.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>

<body>

<div id="container">
<div id="header">
    <div id="site-name">
        <a href="index.php">iTAPS That</a>
    </div>
    
    <div id="navigation">
        <ul>
            <?php if (isset($_SESSION['userid'])) { ?>
                <li><?php navLink('report.php', 'My Report'); ?>
                <li><?php navLink('manual.php', 'Enter Classes'); ?>
                <li><?php navLink('logout.php', 'Log Out'); ?>
            <?php } else { ?>
                <li><?php navLink('newAccount.php', 'Create an Account');?>
                <li><?php navLink('login.php', 'Log In'); ?>
            <?php } ?>
        </ul>  
    </div>
</div>

<div id="content">

<?php 
if(isset($_GET['msg'])) {
    $msg = htmlspecialchars($_GET['msg']);
    if ($msg) {
        $type = htmlspecialchars($_GET['type']);
        echo "<p class='message $type'>$msg</p>";
    }
}

 ?>