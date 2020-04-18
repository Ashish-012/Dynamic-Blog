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
    <title>Admin Panel</title>
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
            <h1 class="h2">Dashboard</h1>
            
        </div>
        <div id='info-form'>
            <form method='post'>
                <div class="form-group">
                    
                    Name: <input type="name" name='author_name' class="form-control" id="email " value='<?php echo $_SESSION['author_name'];?>' placeholder='Enter Name'>
                </div>
                <div class="form-group">
                    
                    Email: <input type="email" name='author_email' class="form-control" id="exampleInputEmail1" placeholder='Enter Email' value='<?php echo $_SESSION['author_email'];?>' aria-describedby="emailHelp">
        
                </div>
                <div class="form-group">
                    
                    Password: <input type="password" name='author_password' class="form-control" id="exampleInputPassword1 "  placeholder='Password'>
                </div>
                
                Your Bio: <textarea class="form-control" id="exampleFormControlTextarea1" name='author_bio' rows="3"  placeholder='Enter your bio here'><?php echo $_SESSION['author_bio'];?></textarea><br>
                <button type="submit" name="update" class="btn btn-primary">Update</button>

            </form>
            <?php
                // if update button is clicked update the information
                if(isset($_POST['update'])){
                    $author_name= mysqli_real_escape_string($conn,$_POST['author_name']);
                    $author_email= mysqli_real_escape_string($conn,$_POST['author_email']);
                    $author_password= mysqli_real_escape_string($conn,$_POST['author_password']);
                    $author_bio= mysqli_real_escape_string($conn,$_POST['author_bio']);

                    if(empty($author_name) OR empty($author_email) OR empty($author_bio)){
                        echo "Empty Fields!"; 
                        echo "<script>window.location='index.php?message=Empty+Fields!'</script>";
                    }
                    else{
                        // checking if new email entered is valid or not
                        if(!filter_var($author_email,FILTER_VALIDATE_EMAIL)){
                            
                            echo "<script>window.location='index.php?message=Please+enter+valid+email'</script>";
                        }
                        else{
                            // if user wants to change the password
                            if(empty($author_password)){
                                $author_id=$_SESSION['author_id'];
                                $sql = "UPDATE `author` SET `author_name`='$author_name', `author_email`='$author_email', `author_bio`='$author_bio' WHERE `author_id`='$author_id'";

                                if(mysqli_query($conn,$sql)){
                                    $_SESSION['author_name']=$author_name;
                                    $_SESSION['author_email']=$author_email;
                                    $_SESSION['author_bio']=$author_bio;

                                    
                                    echo "<script>window.location='index.php?message=Changes+Updated'</script>";
                                }
                                else{
                                    
                                    echo "<script>window.location='index.php?Error'</script>";
                                }
                            }
                            else{
                                // if user doesnt want to change the password hash his new password

                                $hash= password_hash($author_password,PASSWORD_DEFAULT);
                                $author_id = $_SESSION['author_id'];
                                $sql = "UPDATE `author` SET author_name='$author_name', author_email='$author_email', author_bio='$author_bio', author_password='$hash' WHERE author_id='$author_id';";

                                if(mysqli_query($conn,$sql)){
                                    session_unset();
                                    session_destroy();
                                    
                                    echo "<script>window.location='login.php?message=Changes+Updated+Login+Again+Please!'</script>";
                                }
                                else{
                                    echo "Some error occured";
                                }

                            }
                        }
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
</body>
</html>
<?php

}else{
    header("Location: login.php?message=Please+Login+first!");
}
?>
