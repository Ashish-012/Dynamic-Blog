<?php
    include_once "includes/connection.php";
    include_once "includes/functions.php";
    if(!isset($_GET['id'])){
        
        echo "<script>window.location='index.php'</script>";
        exit();
    }
    else{   
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        if(!is_numeric($id)){
            
            echo "<script>window.location='index.php'</script>";
            exit();
        }
        else if(is_numeric($id)){
            $sql = "SELECT * FROM category WHERE category_id = '$id'";
            $result = mysqli_query($conn, $sql);
            // if no such post exists
            if(mysqli_num_rows($result)<=0){
                
                echo "<script>window.location='index.php?noresult'</script>";
                exit();
            }
            else {
            ?>

<?php include_once "includes/connection.php";
      include_once "includes/functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

    <!----  Navigation Bar  ---->    
    <?php include_once 'includes/nav.php';
    ?>

    <div class='container'>
        <center><h1 style='background-color:grey; padding-top: 2%; padding-bottom:2%;'> Showing all posts with category: <?php getCategory($id); ?></h1></center>
        <div class='card-columns'>
            <?php
                // get the data from post table and show it here

                $sql = "SELECT * FROM `post` WHERE post_category='$id' ORDER BY post_id DESC";
                $result = mysqli_query($conn, $sql);

                while($row = mysqli_fetch_assoc($result)){
                    $post_title = $row['post_title'];
                    $post_image = $row['post_image'];
                    $post_author = $row['post_author'];
                    $post_content = $row['post_content'];
                    $post_id = $row['post_id'];

                    $sql_author = "SELECT * FROM `author` WHERE author_id = '$post_author';";
                    $result_author = mysqli_query($conn, $sql_author);
                    while($row_author = mysqli_fetch_assoc($result_author)){
                        $post_author_name = $row_author['author_name'];
                                    
            ?>
            <div class="card" style="width: 18rem;">
                <img src="<?php echo $post_image?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $post_title?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $post_author_name?></h6>
                    <p class="card-text"><?php echo substr(strip_tags($post_content),0,80)."...";?></p>
                </div>
                   <center> <a href="post.php?id=<?php echo $post_id;?>" class="btn btn-primary">Read More</a></center>
            </div>
            <?php }}?>
        </div>
    </div>
    


    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

            <?php    
            }
        }
    }
?>