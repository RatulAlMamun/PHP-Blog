<?php require_once("db.php"); ?>
<?php require_once("session.php"); ?>

<?php
	function redirect_to($new_location)
	{
		header("Location:".$new_location);
        exit;
	}


	function login_attempt($username, $password, $conn)
	{
		$query = "SELECT * FROM registration WHERE username='$username' AND password='$password'";
		$execute = mysqli_query($conn, $query);
		if($admin = mysqli_fetch_assoc($execute))
		{
			return $admin;
		}
		else
		{
			return null;
		}
	}


	function login()
	{
		if(isset($_SESSION["UserID"]))
		{
			return true;
		}
	}


	function confirmlogin()
	{
		if(!login())
		{
			$_SESSION["ErrorMessage"] = "Login Required";
			redirect_to("login.php");
		}
	}
?>