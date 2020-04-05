<?php
    include_once '../includes/connection.php';
    session_start();

    if(isset($_SESSION['author_role'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    
    <!--For any type of error message-->
    

    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
    
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
        <a class="nav-link" href="logout.php">Sign out</a>
        </li>
    </ul>
    </nav>

    <div class="container-fluid">
    <div class="row">
        <?php include_once "nav.php"; ?>
        

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Posts</h1>
            
        </div>
        <?php
            if(isset($_GET['message'])){
                $msg= $_GET['message'];
                echo'<div class="alert alert-danger" role="alert">
                     '.$msg.'   
                     </div>';
            }
        ?>
        <h1>All Posts</h1>
        <a href='newpost.php'><button class='btn btn-info'>Add post</button></a>
        
        <hr>
            <table class='table'>
                <thead>
                    <tr>
                    <th scope="col">Post Id</th>
                    <th scope="col">Post Image</th>
                    <th scope="col">Post Author</th>
                    <th scope="col">Post Title</th>
                    
                    <?php if($_SESSION['author_role']=='admin'){?>
                    <th scope="col">Action</th>
                    <?php }?>
                    </tr>
                </thead>
                <?php
                    $sql = 'SELECT * FROM `post` ORDER BY post_id DESC';
                    $result = mysqli_query($conn, $sql);

                    while($row = mysqli_fetch_assoc($result)){
                        $post_author= $row['post_author'];
                        $post_image= $row['post_image'];
                        $post_id= $row['post_id'];
                        $post_content= $row['post_content'];
                        $post_title= $row['post_title'];
                        
                        $sql_author = "SELECT * FROM `author` WHERE author_id='$post_author'";
                        $result_name = mysqli_query($conn, $sql_author);
                        while($row_auth= mysqli_fetch_assoc($result_name)){
                            $post_author_name = $row_auth['author_name'];
                        
                ?>
                <tbody>
                    <tr>
                    <th scope="row"><?php echo $post_id?></th>   
                    <td><img src='../<?php echo $post_image?> ' width ='60px' height ='60px'; ></td>
                    <td><?php echo $post_author_name?></td>
                    <td><?php echo $post_title?></td>
                    
                    <?php if($_SESSION['author_role']=="admin"){?>
                    <td>
                        <a href='editpost.php?id=<?php echo $post_id;?>'><button type="button" class="btn btn-secondary">Edit</button></a>
                        <a href='deletepost.php?id=<?php echo $post_id?>'><button type="button" onclick=" return confirm('Are you sure?');" class="btn btn-danger">Delete</button></a>
                    </td>
                    <?php }?>
                    </tr>
                <?php }}?>
                </tbody>
            </table>
        </main>
        
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
<?php

}else{
    header("Location: login.php?message=Please+Login+first!");
}
?>
