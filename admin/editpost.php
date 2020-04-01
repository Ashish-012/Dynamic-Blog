<?php
    include_once '../includes/connection.php';
    session_start();

    if(isset($_SESSION['author_id'])){
        if($_SESSION['author_role']=='admin'){
            if(isset($_GET['id'])){
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
    <?php
        if(isset($_GET['message'])){
            $msg= $_GET['message'];
            echo'<div class="alert alert-danger" role="alert">
                 '.$msg.'   
                </div>';
        }
    ?>

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
            <h1 class="h2">Edit Post</h1>
            
        </div>
        <div id='info-form'>
            <?php 
                // grabbing the post id from the url
                $post_id = $_GET['id'];
                $sql_form = "SELECT * FROM `post` where post_id = $post_id;";

                $result_form = mysqli_query($conn, $sql_form);
                while($row_form = mysqli_fetch_assoc($result_form)){
                    $postTitle = $row_form['post_title'];
                    $postContent = $row_form['post_content'];
                    $postImage = $row_form['post_image'];
                    $postKeywords = $row_form['post_keywords'];

            ?>
            <form method='post' enctype='multipart/form-data'>
                <div class="form-group">
                    
                    Post Title : <input type="text" name='post_title' class="form-control"  placeholder='Enter Post Title' value= '<?php echo $postTitle; ?>'>
                </div>
                
                Post content: <textarea class="form-control" id="exampleFormControlTextarea1" name='post_content' rows="3"  placeholder='Enter content here'><?php echo $postContent; ?></textarea><br>
                <img src='../<?php echo $postImage; ?>' width='80px;' height= '80px;' ><br>
                Upload image:
                <div class="form-group">
                    <input type="file" name='file' class="form-control-file"  id="exampleFormControlFile1">
                </div>
                <div class="form-group">
                    
                    Post Keywords : <input type="text" name='post_keywords' value= '<?php echo $postKeywords; ?>' class="form-control"  placeholder='Enter keyword'>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            </form>
            <?php
                }
                if(isset($_POST['update'])){
                    $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
                    $post_content = mysqli_real_escape_string($conn, $_POST['post_content']);
                    $post_keywords = mysqli_real_escape_string($conn, $_POST['post_keywords']);

                    //checking if fields are empty

                    if(empty($post_title) OR empty($post_content)){
                        echo '<script> window.location = "posts.php?message=Empty+Fields!"; </script>';
                        exit();
                    }

                    if(is_uploaded_file($_FILES['file']['tmp_name'])){
                        // user uploaded a file
                        $file = $_FILES['file'];
                        // storing various details in different variables
                        $file_Name= $file['name'];
                        $file_Type= $file['type'];
                        $file_Tmp= $file['tmp_name'];
                        $file_Error= $file['error'];
                        $file_Size= $file['size'];

                        // to check the extension of file

                        $fileExt = explode('.',$file_Name);
                        $file_extension = strtolower(end($fileExt));

                        // accepted file formats

                        $allowedExt = array("jpg","jpeg","png","gif");

                        if(in_array($file_extension,$allowedExt)){
                            if($file_Error === 0 ){
                                if($file_Size<5000000){
                                    $new_file_name = uniqid('',true).'.'.$file_extension;
                                    $destination = "../uploads/$new_file_name";
                                    $db_destination = "uploads/$new_file_name";
                                    move_uploaded_file($file_Tmp,$destination);

                                    $sql = "UPDATE post SET post_title='$post_title',post_content='$post_content',
                                    post_keywords='$post_keywords,post_image='$db_destination' WHERE post_id = '$post_id";
                                    
                                    if(mysqli_query($conn, $sql)){
                                        echo '<script> window.location = "posts.php?message=Post+Updated"; </script>';
                                        exit();
                                    }
                                    else{
                                        echo '<script> window.location = "posts.php?message=Error!"; </script>';
                                        exit();
                                    }
                                }
                                else{
                                    echo "File too big to upload";
                                }
                            }
                            else{
                                echo "Error uploading your file!";
                            }
                        }
                        else{
                            echo "You have uploaded wrong file!";
                        }
                    }
                    else{
                        //user didnot uploaded any file
                        $sql = "UPDATE post SET post_title='$post_title',post_content='$post_content',
                            post_keywords='$post_keywords' WHERE post_id = '$post_id'";
                        if(mysqli_query($conn, $sql)){
                            echo '<script> window.location = "posts.php?message=Post+Updated"; </script>';
                            exit();
                        }
                        else{
                            echo '<script> window.location = "posts.php?message=Error!"; </script>';
                            exit();
                        }
                    }

                }
            ?>
            
        </div>
        </main>
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
<?php
        }else{
            header('Location: index.php');
        }
    }
    else{
            header('Location: index.php');
        }
}else{
    header("Location: login.php?message=Please+Login+first!");
}
?>
