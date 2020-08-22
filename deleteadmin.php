<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>

<?php
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		$query = "DELETE FROM registration WHERE id='$id'";
		$execute = mysqli_query($connection, $query);
		if ($execute) 
		{
			$_SESSION["SuccessMessage"] = "Admin Removed Successfully";
			Redirect_to("admins.php");
		}
		else
		{
			$_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again!!";
			Redirect_to("admins.php");
		}
	}
?>