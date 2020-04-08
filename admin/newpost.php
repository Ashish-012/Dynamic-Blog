<?php
    include_once '../includes/connection.php';
    session_start();

    if(isset($_SESSION['author_id'])){
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
            <h1 class="h2">Add Post</h1>
            
        </div>
        <div id='info-form'>
            <form method='post' enctype='multipart/form-data'>
                <div class="form-group">
                    
                    Post Title : <input type="text" name='post_title' class="form-control"  placeholder='Enter Post Title'>
                </div>
                Post Category:
                <div class="form-group">
                    <select class="form-control" name='post_category' id="exampleFormControlSelect2">
                    <?php 
                        $sql = "SELECT * FROM `category`";
                        $result= mysqli_query($conn, $sql);
                        while($row=mysqli_fetch_assoc($result)){
                            $category_id=$row['category_id'];
                            $category_name=$row['category_name'];
                        
                    ?>
                    <option value='$category_id'><?php echo "$category_name"?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>
                Post content: <textarea class="form-control" id="exampleFormControlTextarea1" name='post_content' rows="3"  placeholder='Enter content here'></textarea><br>
                Upload image:
                <div class="form-group">
                    <input type="file" name='file' class="form-control-file" id="exampleFormControlFile1">
                </div>
                <div class="form-group">
                    
                    Post Keywords : <input type="text" name='post_keywords' class="form-control"  placeholder='Enter keyword'>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Create Post</button>
            </form>
            <?php
                if(isset($_POST['update'])){
                    $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
                    $post_category = mysqli_real_escape_string($conn, $_POST['post_category']);
                    $post_content = mysqli_real_escape_string($conn, $_POST['post_content']);
                    $post_keywords = mysqli_real_escape_string($conn, $_POST['post_keywords']);
                    $post_author = $_SESSION['author_id'];
                    $post_date= date("d/m/y");

                    //checking if fields are empty

                    if(empty($post_title) OR empty($post_category) OR empty($post_content)){
                        header("Location: newpost.php?message=Empty+Fields!");
                        exit();
                    }
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

                                $sql = "INSERT INTO `post` (`post_author`,`post_image`,`post_title`,`post_content`,`post_category`,`post_keywords`,`post_date`) VALUES ('$post_author','$db_destination','$post_title','$post_content','$post_category','$post_keywords','$post_date');";
                                if(mysqli_query($conn, $sql)){
                                    header("Location: posts.php?message=Post+Added");
                                    exit();
                                }
                                else{
                                    header("Location: newposts.php?message=Error!");
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
            ?>
            
        </div>
        </main>
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/b7ifonmi3q0pcuylkj33essu2ip05cax7b30b0i77th9k3jc/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
        selector: 'textarea',
        plugins: 'casechange lists checklist pageembed table',
        toolbar: 'casechange checklist pageembed table',
        });
    </script>
</body>
</html>
<?php

}else{
    header("Location: login.php?message=Please+Login+first!");
}
?>
