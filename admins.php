<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirmlogin() ?>

<?php
    if (isset($_POST['submit']))
    {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $confirmpassword = mysqli_real_escape_string($connection, $_POST['confirmpassword']);
        date_default_timezone_set("Asia/Dhaka");
        $curr_time = time();
        $datetime =strftime("%B-%d-%Y %H:%M:%S", $curr_time);
        $admin = $_SESSION["UserName"];
        if (empty($username) || empty($password) || empty($confirmpassword)) 
        {
            $_SESSION["ErrorMessage"] = "All Fields Must Be Filled Out.";
            redirect_to("admins.php");
        }
        else if (strlen($password) < 4) 
        {
            $_SESSION["ErrorMessage"] = "At least 4 character password are required";
            redirect_to("admins.php");
        }
        else if ($password !== $confirmpassword) {
            $_SESSION["ErrorMessage"] = "Password does not match. Please try again";
            redirect_to("admins.php");
        }
        else
        {
            $query = "INSERT INTO registration(datetime, username, password, addedby) VALUES ('$datetime', '$username', '$password', '$admin')";
            $execute = mysqli_query($connection, $query);
            if ($execute) 
            {
                $_SESSION["SuccessMessage"] = "Admin Added Successfully.";
                redirect_to("admins.php");
            }
            else
            {
                $_SESSION["ErrorMessage"] = "Admin Failed to Add.";
                redirect_to("admins.php");
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
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <h1 class="py-2">CMS Blog</h1>
                <hr class="bg-light">
                <ul id="sideMenu" class="nav nav-pills nav-stacked">
                    <li><a href="dashboard.php"><i class="fa fa-th" aria-hidden="true"></i>&nbsp; Dashboard</a></li>
                    <li><a href="addnewpost.php"><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp; Add New Post</a></li>
                    <li><a href="categories.php"><i class="fa fa-tag" aria-hidden="true"></i>&nbsp; Categories</a></li>
                    <li class="active"><a href="admins.php"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Manage Admins</a></li>
                    <li><a href="comment.php"><i class="fa fa-comments" aria-hidden="true"></i>&nbsp; Comments</a></li>
                    <li><a href="#"><i class="fa fa-list" aria-hidden="true"></i>&nbsp; Live Blog</a></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp; Logout</a></li>
                </ul>
            </div>
            <div class="col-sm-10">
                <h1>Manage Admin Access</h1>
                <?php
                    echo message();
                    echo successmessage();
                ?>
                <div style="padding: 20px;">
                    <form action="admins.php" method="POST">
                        <div class="form-group">
                            <label for="username">User Name</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="UserName">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Confirm Password</label>
                            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirm Password">
                        </div>
                        <input type="submit" name="submit" value="Add New Admin" class="btn btn-success">
                    </form>
                </div>

                <div style="padding: 20px;" class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>  
                            <th>#</th>
                            <th>Date & Time</th>
                            <th>Admin Name</th>
                            <th>Added Name</th>
                            <th>Action</th>
                        </tr>
                        <?php
                            $query = "SELECT * FROM registration ORDER BY datetime DESC";
                            $execute = mysqli_query($connection, $query);
                            $x = 0;
                            while ($datarows = mysqli_fetch_array($execute)) 
                            {
                                $id = $datarows["id"];
                                $datetime = $datarows["datetime"];
                                $username = $datarows["username"];
                                $addedby = $datarows["addedby"];
                                $x++;
                        ?>
                                <tr>
                                    <td><?php echo $x; ?></td>
                                    <td><?php echo $datetime; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td><?php echo $addedby; ?></td>
                                    <td>
                                        <a href="deleteadmin.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="#footer" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <hr>
                <p class="text-primary text-center">
                    Copyright &copy; All rights reserved | 2020
                </p>
                <hr>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.4.1.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>