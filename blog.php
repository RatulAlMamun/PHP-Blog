<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Page</title>
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
                    if (isset($_GET["searchbutton"])) 
                    {
                        $search = $_GET["search"];
                        $query = "SELECT * FROM admin_panel WHERE datetime LIKE '%$search%' OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%'";
                    }
                    else if(isset($_GET['category']))
                    {
                        $category = $_GET['category'];
                        $query = "SELECT * FROM admin_panel WHERE category='$category' ORDER BY datetime DESC";
                    }
                    else if(isset($_GET['page']))
                    {
                        $page = $_GET['page'];
                        if($page <= 0)
                        {
                            $showpostfrom = 0;
                        }
                        else
                        {
                            $showpostfrom = ($page*5)-5;
                        }
                        $query = "SELECT * FROM admin_panel ORDER BY datetime DESC LIMIT $showpostfrom, 5";
                    }
                    else
                    {
                        $query = "SELECT * FROM admin_panel ORDER BY datetime DESC LIMIT 0, 5";
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
                        <p class="post">
                            <?php
                                if (strlen($post) > 150) {
                                    $post = substr($post, 0, 150)."...";
                                }    
                                echo htmlentities($post); 
                            ?>
                        </p>
                        <a href="fullpost.php?id=<?php echo $id; ?>">
                            <span class="btn btn-info">Read More &rsaquo;&rsaquo;</span>
                        </a>
                    </div>
                </div>
                <?php
                    }
                ?>
                <nav>
                    <ul class="pagination pagination-lg pull-left">
                        <?php
                            if(isset($page))
                            {
                                if($page > 1)
                                {
                        ?>
                        <li>
                            <a href="blog.php?page=<?php echo $page-1; ?>"> &laquo; </a>
                        </li>
                        <?php
                                }
                            }
                        ?>      
                        <?php
                            $paginationquery = "SELECT COUNT(*) FROM admin_panel";
                            $paginationexecute = mysqli_query($connection, $paginationquery);
                            $paginationrow = mysqli_fetch_array($paginationexecute);
                            $totalpost = array_shift($paginationrow);
                            $postpagination = ceil($totalpost/5);
                            for($i = 1; $i <= $postpagination; $i++)
                            {
                                if(isset($page))
                                {
                                    if($i == $page)
                                    {
                        ?>
                        <li class="active">
                            <a href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php
                                    }
                                    else
                                    {
                        ?>
                        <li>
                            <a href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php
                                    }
                                }
                            }
                        ?>
                        <?php
                            if(isset($page))
                            {
                                if($page < $postpagination)
                                {
                        ?>
                        <li>
                            <a href="blog.php?page=<?php echo $page+1; ?>"> &raquo; </a>
                        </li>
                        <?php
                                }
                            }
                        ?> 
                    </ul>
                </nav>
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