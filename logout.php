<?php
session_start();
unset($_SESSION['userid']);
include_once('header.php');
?>


<p>Logged out...</p>
<p><a href="login.php">Log in again</a></p>

<?php include_once('footer.php'); ?>
