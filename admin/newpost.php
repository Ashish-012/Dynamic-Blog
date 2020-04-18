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
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../index.php">MyDynamicSite</a>
    
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
            <form method="post" enctype="multipart/form-data">
					Post Title
					 <input type="text" name="post_title" class="form-control" placeholder="Post Title"><br>
					 
					Post Category
					<select name="post_category" class="form-control" id="exampleFormControlSelect1">
					<?php
						$sql = "SELECT * FROM `category`";
						$result = mysqli_query($conn, $sql);
						while($row=mysqli_fetch_assoc($result)){
							$category_id = $row['category_id'];
							$category_name = $row['category_name'];
							?>
							<option value="<?php echo $category_id; ?>"><?php echo $category_name; ?></option>
							<?php
						}
					?>
					</select><br>
					
					Post Content
					<textarea name="post_content" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea><br>
					
					Post Image
					<input type="file" name="file" class="form-control-file" id="exampleFormControlFile1"><br>
					
					Post Keywords
					 <input type="text" name="post_keywords" class="form-control" placeholder="Enter Keywords"><br>
					 
					 
					 <button name="submit" type="submit" class="btn btn-primary">Submit</button>
				</form>
				<?php
					if(isset($_POST['submit'])){
						$post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
						$post_category = mysqli_real_escape_string($conn, $_POST['post_category']);
						$post_content = mysqli_real_escape_string($conn, $_POST['post_content']);
						$post_keywords = mysqli_real_escape_string($conn, $_POST['post_keywords']);
						$post_author = $_SESSION['author_id'];
						$post_date = date("d/m/y");
						
						//checking if above fields are empty
						if(empty($post_title) OR empty($post_category) OR empty($post_content)){
							
							echo "<script>window.location='newpost.php?message=Empty+Fields'</script>";
							exit();
						}
                        
                        // file handling
						$file = $_FILES['file'];
				
						$fileName = $file['name'];
						$fileType = $file['type'];
						$fileTmp = $file['tmp_name'];
						$fileErr = $file['error'];
						$fileSize = $file['size'];
						
						$fileEXT = explode('.',$fileName);
                        $fileExtension = strtolower(end($fileEXT));
                        
						//supported extensions
						$allowedExt = array("jpg", "jpeg", "png", "gif");
						
						if(in_array($fileExtension, $allowedExt)){
							if($fileErr === 0){
								if($fileSize < 3000000){
                                    // if the file meet all the requirements upload it
									$newFileName = uniqid('',true).'.'.$fileExtension;
									$destination = "../uploads/$newFileName";
									$dbdestination = "uploads/$newFileName";
									move_uploaded_file($fileTmp, $destination);
									$sql = "INSERT INTO post (`post_title`,`post_content`,`post_category`, `post_author`, `post_date`, `post_keywords`, `post_image`) VALUES ('$post_title', '$post_content', '$post_category', '$post_author', '$post_date', '$post_keywords', '$dbdestination');";
									if(mysqli_query($conn, $sql)){
									
										echo "<script>window.location='posts.php?message=Post+Published!'</script>";
									}else{
										
										echo "<script>window.location='newpost.php?message=Error'</script>";
									}
								} else {
									
									echo "<script>window.location='newpost.php?message=YOUR FILE IS TOO BIG TO UPLOAD!!'</script>";
									exit();
								}
							}else{
								
								echo "<script>window.location='newpost.php?message=Oops Error Uploading your file. Supported formats are jpeg, png, jpg, gif'</script>";
								exit();
							}
						}else{
							echo "<script>window.location='newpost.php?message=Oops Error Uploading your file. File is too big to upload'</script>";
							exit();
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
    <script src="https://cdn.tiny.cloud/1/TOKENGOESHERE/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
        selector: 'textarea',
        plugins: 'casechange lists checklist'
        });
    </script>
</body>
</html>
<?php

}else{
    header("Location: login.php?message=Please+Login+first!");
}
?>
