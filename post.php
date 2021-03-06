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
            $sql = "SELECT * FROM post WHERE post_id = '$id'";
            $result = mysqli_query($conn, $sql);
            // if no such post exists
            if(mysqli_num_rows($result)<=0){
                
                echo "<script>window.location='index.php?noresult'</script>";
                exit();
            }
            else if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    $post_author = $row['post_author'];
                    $post_image = $row['post_image'];
                    $post_title = $row['post_title'];
                    $post_content = $row['post_content'];
                    $post_category = $row['post_category'];
                    $post_keywords = $row['post_keywords'];
                    $post_date = $row['post_date'];
                    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post_title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

    <!----  Navigation Bar  ---->    
    <?php include_once 'includes/nav.php'; ?>

    <div class='container'>
        <center>
            <img style="width:300px; height:300px;" src="<?php echo $post_image; ?>">
            <h1><?php echo $post_title; ?></h1>
            <hr>
            <h6>Posted On: <?php echo $post_date; ?> | By: <?php getAuthorName($post_author); ?></h6>
            <h4>Category: <a href="category.php?id=<?php echo $post_category ; ?>"><?php getCategory($post_category); ?></a></h4>
            <p><?php echo $post_content; ?></p>
        </center>
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

    }
?>