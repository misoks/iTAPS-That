<?php
session_start();
include_once('header.php');
unset($_SESSION['userid']);
movePage('index.php', "You've been logged out.", 'success');
?>


<p>You've logged out.</p>
<p><a href="login.php">Log in again</a></p>

<?php include_once('footer.php'); ?>
