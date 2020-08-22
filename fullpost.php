<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>

<?php
    if (isset($_POST['submit']))
    {
        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $comment = mysqli_real_escape_string($connection, $_POST['comment']);
        date_default_timezone_set("Asia/Dhaka");
        $curr_time = time();
        $datetime =strftime("%B-%d-%Y %H:%M:%S", $curr_time);
        $id = $_GET['id'];
        if (empty($name) || empty($email) || empty($comment)) 
        {
            $_SESSION["ErrorMessage"] = "All Fields are required";
        }
        else if (strlen($comment) > 500) 
        {
            $_SESSION["ErrorMessage"] = "Only 500 characters are allowed in comment.";
        }
        else
        {
            $query = "INSERT INTO comments(datetime, name, email, comment, approvedby, status, admin_panel_id) VALUES('$datetime', '$name', '$email', '$comment', 'Pending', 'OFF', '$id')";
            $execute = mysqli_query($connection, $query);
            if ($execute) 
            {
                $_SESSION["SuccessMessage"] = "Comment Submitted Successfully.";
                redirect_to("fullpost.php?id={$id}");
            }
            else
            {
                $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!!";
                redirect_to("fullpost.php?id={$id}");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Blog Post</title>
    <!-- FONT AWESOME CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="css/style.css">
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
                    <li class="active"><a href="blog.php">Blog</a></li>
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
    <div class="container">
        <div class="blog-header">
            <h1>The Complete Responsive CMS Blog</h1>
            <p class="lead">The complete blog using PHP by Ratul.</p>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <?php
                    echo message();
                    echo successmessage();
                    if (isset($_GET["searchbutton"])) 
                    {
                        $search = $_GET["search"];
                        $query = "SELECT * FROM admin_panel WHERE datetime LIKE '%$search%' OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%'";
                    }
                    else
                    {
                        $postIDfromURI = $_GET['id'];
                        $query = "SELECT * FROM admin_panel WHERE id='$postIDfromURI' ORDER BY datetime DESC";
                    }
                    $execute = mysqli_query($connection, $query);
                    while ($datarows = mysqli_fetch_array($execute)) 
                    {
                        $id         = $datarows["id"];
                        $datetime   = $datarows["datetime"];
                        $title      = $datarows["title"];
                        $category   = $datarows["category"];
                        $author     = $datarows["author"];
                        $image      = $datarows["image"];
                        $post       = $datarows["post"];
                ?>
                <div class="blogpost thumbnail">
                    <img class="img-responsive img-rounded" src="uploads/<?php echo $image; ?>" alt="">
                    <div class="caption">
                        <h1 id="heading"><?php echo htmlentities($title); ?></h1>
                        <p class="description">Category: <?php echo htmlentities($category); ?> | Published on: <?php echo htmlentities($datetime); ?></p>
                        <p class="post"><?php echo htmlentities($post); ?></p>
                    </div>
                </div>
                <?php
                    }
                ?>
                <br><br><br><br>
                <h2 class="text-warning">Comments</h2>
                <span class="text-warning">Share your thoughts about this post</span>
                <br>
                <?php
                    $query = "SELECT * FROM comments WHERE admin_panel_id='$id' AND status='ON'";
                    $execute = mysqli_query($connection, $query);
                    while ($datarows = mysqli_fetch_array($execute)) {
                        $commentDate = $datarows['datetime'];
                        $commentername = $datarows['name'];
                        $comment = $datarows['comment']; 
                ?>
                <div class="bg-warning" style="padding: 10px;">
                    <i class="fa fa-user pull-left" aria-hidden="true" style="background-color: #333; color: #fff; padding: 10px; font-size:30px; border-radius: 100%;"></i>
                    <p style="color: #365899; font-family: sans-serif; font-size: 1.8rem; font-weight: bold; padding-top: 10px;"><?php echo $commentername; ?></p>
                    <p style="color: #aaa; font-family: sans-serif; font-size: 1.5rem; font-weight: bold; padding-top: 10px;"><?php echo $commentDate; ?></p>
                    <p style="margin: 5px; padding-bottom: 10px; font-size: 1.6rem;"><?php echo $comment; ?></p>
                </div>
                <hr>
                <?php
                    }
                ?>
                <div style="padding: 20px;">
                    <form action="fullpost.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="Name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Your Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email">
                        </div>
                        <div class="form-group">
                            <label for="commentarea">Comment</label>
                            <textarea class="form-control" id="commentarea" name="comment"></textarea>
                        </div>
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-block">
                    </form>
                </div>
            </div>
            <div class="col-sm-offset-1 col-sm-3">
                <h2>About Me</h2>
                <img src="image/logo.jpg" class="img-responsive img-circle imageicon">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque error similique perspiciatis quis porro esse reprehenderit quia dolorem blanditiis tempora?</p>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title">Categories</h2>
                    </div>
                    <div class="panel-body">
                        <?php
                            $query = "SELECT * FROM categories ORDER BY 'DESC'";
                            $execute = mysqli_query($connection, $query);
                            while ($datarows = mysqli_fetch_array($execute))
                            {
                                $id = $datarows['id'];
                                $category = $datarows['name'];
                        ?>
                        <a href="blog.php?category=<?php echo $category; ?>">
                            <p id="heading"><?php echo $category; ?></p>
                        </a>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="panel-footer"></div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title">Recent Posts</h2>
                    </div>
                    <div class="panel-body">
                        <?php 
                            $query = "SELECT * FROM admin_panel ORDER BY datetime DESC LIMIT 0, 5";
                            $execute = mysqli_query($connection, $query);
                            while ($datarows = mysqli_fetch_array($execute)) 
                            {
                                $id = $datarows['id'];
                                $title = $datarows['title'];
                                $datetime = $datarows['datetime'];
                                $image = $datarows['image'];
                                if (strlen($datetime) > 11) 
                                {
                                    $datetime = substr($datetime, 0, 11);
                                }
                        ?>
                        <div>
                            <img class="pull-left" style="margin-top: 10px; margin-left: 10px;" src="uploads/<?php echo $image; ?>" width="70" height="70">
                            <a href="fullpost.php?id=<?php echo $id; ?>">
                                <p id="heading" style="margin-left: 90px; "><?php echo $title; ?></p>
                            </a>
                            <p class="description" style="margin-left: 90px; "><?php echo $datetime; ?></p>
                            <hr>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="panel-footer"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <hr>
                <p class="text-light text-center">Copyright &copy; All rights reserved | 2020</p>
                <hr>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <script src="js/jquery-3.4.1.slim.min.js"></script>
</body>
</html>