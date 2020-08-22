<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirmlogin() ?>

<?php
    if (isset($_POST['submit']))
    {
        $title = mysqli_real_escape_string($connection, $_POST['title']);
        $category = mysqli_real_escape_string($connection, $_POST['category']);
        $post = mysqli_real_escape_string($connection, $_POST['post']);
        date_default_timezone_set("Asia/Dhaka");
        $curr_time = time();
        $datetime =strftime("%B-%d-%Y %H:%M:%S", $curr_time);
        $admin = "ratul";
        $image = $_FILES["image"]["name"];
        $target = "uploads/".basename($_FILES["image"]["name"]);
        if (empty($title)) 
        {
            $_SESSION["ErrorMessage"] = "Title can't be empty";
            redirect_to("addnewpost.php");
        }
        else if (strlen($title) < 2) 
        {
            $_SESSION["ErrorMessage"] = "Title should be at least 2 characters.";
            redirect_to("addnewpost.php");
        }
        else
        {
            $id = $_GET['id'];
            $query = "UPDATE admin_panel SET datetime='$datetime', title='$title', category='$category', author='$admin', image='$image', post='$post' WHERE id='$id'";
            $execute = mysqli_query($connection, $query);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target);
            if ($execute) 
            {
                $_SESSION["SuccessMessage"] = "Post Updated Successfully.";
                redirect_to("dashboard.php");
            }
            else
            {
                $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!!";
                redirect_to("dashboard.php");
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
                    <li class="active"><a href="addnewpost.php"><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp; Add New Post</a></li>
                    <li><a href="categories.php"><i class="fa fa-tag" aria-hidden="true"></i>&nbsp; Categories</a></li>
                    <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Manage Admins</a></li>
                    <li><a href="#"><i class="fa fa-comments" aria-hidden="true"></i>&nbsp; Comments</a></li>
                    <li><a href="#"><i class="fa fa-list" aria-hidden="true"></i>&nbsp; Live Blog</a></li>
                    <li><a href="#"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp; Logout</a></li>
                </ul>
            </div>
            <div class="col-sm-10">
                <h1>Edit Post</h1>
                <?php
                    echo message();
                    echo successmessage();

                    $id = $_GET['id'];
                    $query = "SELECT * FROM admin_panel WHERE id='$id'";
                    $execute = mysqli_query($connection, $query);
                    while($datarows = mysqli_fetch_array($execute))
                    {
                        $titleToEdit = $datarows['title'];
                        $categoryToEdit = $datarows['category'];
                        $imageToEdit = $datarows['image'];
                        $postToEdit = $datarows['post'];
                    }
                ?>
                <div style="padding: 20px;">
                    <form action="editpost.php?id=<?php echo $id?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input value="<?php echo $titleToEdit; ?>" type="text" name="title" id="title" class="form-control" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <p class="bg-info" style="padding: 5px 10px;"><b>Existing Category:</b> <?php echo $categoryToEdit; ?></p>
                            <label for="category">Select Category</label>
                            <select class="form-control" id="category" name="category">
                                <?php
                                    $query = "SELECT * FROM categories ORDER BY datetime DESC";
                                    $execute = mysqli_query($connection, $query);
                                    while ($datarows = mysqli_fetch_array($execute)) 
                                    {
                                        $id = $datarows["id"];
                                        $categoryname = $datarows["name"];
                                ?>
                                <option value="<?php echo $categoryname; ?>"><?php echo $categoryname?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <p class="bg-info" style="padding: 5px 10px;"><b>Existing Image: </b><img src="uploads/<?php echo $imageToEdit?>" alt="" width="100"></p>
                            <label for="image">Select Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="postarea">Post</label>
                            <textarea class="form-control" id="postarea" name="post"><?php echo $postToEdit; ?></textarea>
                        </div>
                        <input type="submit" name="submit" value="Update Post" class="btn btn-success">
                    </form>
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