<?php
session_start();
unset($_SESSION['userid']);
?>

<html>
<head>
    <title>Logout - iTAPS That</title>
    <link rel=stylesheet href="style.css" type="text/css" media="screen" />
</head>

<body>

<p>Logged out...</p>
<p><a href="login.php">Login Again</a></p>

</body>

</html>
