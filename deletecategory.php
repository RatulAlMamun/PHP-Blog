<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>

<?php
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		$query = "DELETE FROM categories WHERE id='$id'";
		$execute = mysqli_query($connection, $query);
		if ($execute) 
		{
			$_SESSION["SuccessMessage"] = "Category Removed Successfully";
			Redirect_to("categories.php");
		}
		else
		{
			$_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again!!";
			Redirect_to("categories.php");
		}
	}
?>