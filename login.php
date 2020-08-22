<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>

<?php
    if (isset($_POST['submit']))
    {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        if (empty($username) || empty($password)) 
        {
            $_SESSION["ErrorMessage"] = "All Fields Must Be Filled Out.";
            redirect_to("login.php");
        }
        else
        {
            $found_account = login_attempt($username, $password, $connection);
            $_SESSION["UserID"] = $found_account["id"];
            $_SESSION["UserName"] = $found_account["username"];
            if($found_account)
            {
                $_SESSION["SuccessMessage"] = "Welcome {$_SESSION['UserName']}";
                redirect_to("dashboard.php");
            }
            else
            {
                $_SESSION["ErrorMessage"] = "Invalid Username or Password";
                redirect_to("login.php");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Blog Dashboard</title>
    <!-- FONT AWESOME CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="css/adminstyle.css">
</head>
<body style="background-color: #ffffff;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
            	<br><br><br><br>
                <?php
                    echo message();
                    echo successmessage();
                ?>
                <h1 class="text-center">!!! Welcome !!!</h1>
                <br>
                <div style="padding: 20px;">
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label for="username">User Name</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope text-primary"></span>
                                </span>
                                <input type="text" name="username" id="username" class="form-control" placeholder="UserName">
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-lock text-primary"></span>
                                </span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            </div>
                        </div>                        <br>
                        <input type="submit" name="submit" value="Log In" class="btn btn-success btn-block">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.4.1.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>