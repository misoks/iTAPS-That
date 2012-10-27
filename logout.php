<?php
session_start();
unset($_SESSION['userid']);
?>

<?php include_once('header.php'); ?>

<p>Logged out...</p>
<p><a href="login.php">Login Again</a></p>

<?php include_once('footer.php'); ?>
