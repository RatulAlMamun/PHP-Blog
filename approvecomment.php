<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>

<?php
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		$admin = $_SESSION['UserName'];
		$query = "UPDATE comments SET status='ON', approvedby='$admin' WHERE id='$id'";
		$execute = mysqli_query($connection, $query);
		if ($execute) 
		{
			$_SESSION["SuccessMessage"] = "Comment Approved Successfully";
			Redirect_to("comment.php");
		}
		else
		{
			$_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again!!";
			Redirect_to("comment.php");
		}
	}
?>