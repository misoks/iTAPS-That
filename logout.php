<?php
session_start();
unset($_SESSION['userid']);
?>
<p>Logged out...</p>
<p><a href="login.php">Login Again</a></p>
