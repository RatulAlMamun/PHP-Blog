<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>

<?php
	$_SESSION["UserID"] = null;
	session_destroy();
	redirect_to("login.php");
?>