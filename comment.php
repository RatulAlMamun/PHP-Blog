<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirmlogin() ?>

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
    <div style="height: 10px; background-color: #27aae1;"></div>
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="index.php" class="navbar-brand">
                    <img src="image/logo.jpg" alt="LOGO" style="width: 50px; margin-top: -16px;">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="nav navbar-nav">
                    <li><a href="#">Home</a></li>
                    <li class="active"><a href="blog.php" target="_blank">Blog</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
                <form action="blog.php" class="navbar-form navbar-right">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Search Here...">
                    </div>
                    <button type="submit" name="searchbutton" class="btn btn-success">Search</button>
                </form>
            </div>
        </div>
        <div style="height: 10px; background-color: #27aae1;"></div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <h1 class="py-2">CMS Blog</h1>
                <hr class="bg-light">
                <ul id="sideMenu" class="nav nav-pills nav-stacked">
                    <li><a href="dashboard.php"><i class="fa fa-th" aria-hidden="true"></i>&nbsp; Dashboard</a></li>
                    <li><a href="addnewpost.php"><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp; Add New Post</a></li>
                    <li><a href="categories.php"><i class="fa fa-tag" aria-hidden="true"></i>&nbsp; Categories</a></li>
                    <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Manage Admins</a></li>
                    <li class="active"><a href="comment.php"><i class="fa fa-comments" aria-hidden="true"></i>&nbsp; Comments</a></li>
                    <li><a href="#"><i class="fa fa-list" aria-hidden="true"></i>&nbsp; Live Blog</a></li>
                    <li><a href="#"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp; Logout</a></li>
                </ul>
            </div>
            <div class="col-sm-10">
                <?php
                    echo message();
                    echo successmessage();
                ?>
                <h1 class="display-1">Un-Approved Comments</h1>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Delete Comment</th>
                            <th>Details</th>
                        </tr>
                        <?php
                            $query = "SELECT * FROM comments WHERE status='OFF' ORDER By datetime DESC";
                            $execute = mysqli_query($connection, $query);
                            $x = 0;
                            while ($datarows = mysqli_fetch_array($execute))
                            {
                                $commentid = $datarows['id'];
                                $datetime = $datarows['datetime'];
                                $name = $datarows['name'];
                                $comment = $datarows['comment'];
                                $admin_panel_id = $datarows['admin_panel_id'];
                                $x++;
                        ?>
                        <tr>
                            <td><?php echo $x; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $datetime; ?></td>
                            <td><?php echo $comment; ?></td>
                            <td><a href="approvecomment.php?id=<?php echo $commentid; ?>" class="btn btn-success">Approve</a></td>
                            <td><a href="deletecomment.php?id=<?php echo $commentid; ?>" class="btn btn-danger">Delete</a></td>
                            <td><a href="fullpost.php?id=<?php echo $admin_panel_id; ?>" class="btn btn-primary" target="_blank">Live Preview</a></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </table>
                </div>

                <h1 class="display-1">Approved Comments</h1>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Comment</th>
                            <th>Approved By</th>
                            <th>Revert Approve</th>
                            <th>Delete Comment</th>
                            <th>Details</th>
                        </tr>
                        <?php
                            $query = "SELECT * FROM comments WHERE status='ON' ORDER BY datetime DESC";
                            $execute = mysqli_query($connection, $query);
                            $x = 0;
                            while ($datarows = mysqli_fetch_array($execute))
                            {
                                $commentid = $datarows['id'];
                                $datetime = $datarows['datetime'];
                                $name = $datarows['name'];
                                $comment = $datarows['comment'];
                                $approvedby = $datarows['approvedby'];
                                $admin_panel_id = $datarows['admin_panel_id'];
                                $x++;
                        ?>
                        <tr>
                            <td><?php echo $x; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $datetime; ?></td>
                            <td><?php echo $comment; ?></td>
                            <td><?php echo $approvedby; ?></td>
                            <td><a href="disapprovecomment.php?id=<?php echo $commentid; ?>" class="btn btn-warning">Dis-Approve</a></td>
                            <td><a href="deletecomment.php?id=<?php echo $commentid; ?>" class="btn btn-danger">Delete</a></td>
                            <td><a href="fullpost.php?id=<?php echo $admin_panel_id; ?>" class="btn btn-primary" target="_blank">Live Preview</a></td>
                        </tr>
                        <?php
                            }
                        ?>
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