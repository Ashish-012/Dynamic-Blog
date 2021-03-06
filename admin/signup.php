<?php include_once '../includes/connection.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
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

    <!----  Signup Form  ---->    
    <div style='width:25%; margin:auto auto; margin-top:150px;'>
        <form class="form-signup" method='post'>
            <center><h1 class="h2 mb-3 font-weight-normal">Sign Up!</h1></center>
            
            <input type="name" name='author_name' id="inputName" class="form-control" placeholder="Enter Name" required autofocus>

            <input type="email" name='author_email' id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

            <input type="password" name='author_password' id="inputPassword" class="form-control" placeholder="Enter Password" required autofocus>
            
            <button class="btn btn-lg btn-primary btn-block" name='submit' type="submit" style='margin-top:20px; margin-bottom:20px;'>Sign up</button>
        </form>
        <center><h1 class="h3 mb-3 font-weight-normal">OR</h1></center>
        <a href='login.php'><button class="btn btn-lg btn-warning btn-block">Login</button></a>
    </div>

    <?php 
        if(isset($_POST['submit'])){
            $author_name = mysqli_real_escape_string($conn,$_POST['author_name']);
            $author_email = mysqli_real_escape_string($conn,$_POST['author_email']);
            $author_password = mysqli_real_escape_string($conn,$_POST['author_password']);
            
            // checking for empty fields
            if(empty($author_name) OR empty($author_email) OR empty($author_password)){
                
                echo "<script>window.location='signup.php?message=Empty+Fields'</script>";
                exit();
            }


            if(!filter_var($author_email,FILTER_VALIDATE_EMAIL)){
               
                echo "<script>window.location='signup.php?message=Pleas+Enter+Valid+Email'</script>";
                exit();
            }
            else{
                $sql2="SELECT * FROM `author` WHERE `author_email`='$author_email'";

                $result= mysqli_query($conn,$sql2);
                if(mysqli_num_rows($result)>0){
                    
                    echo "<script>window.location='signup.php?message=Email+Already+Exists'</script>";
                    exit();
                }
                else{
                    // password hashing
                    $hash=password_hash($author_password,PASSWORD_DEFAULT);    

                    //Signing in
                    $sql = "INSERT INTO `author` (`author_name`,`author_email`,`author_password`,`author_bio`,`author_role`) VALUES ('$author_name','$author_email','$hash','Enter Bio','author')";

                    if(mysqli_query($conn,$sql)){
                        
                        echo "<script>window.location='signup.php?message=SuccessFully+Registered'</script>";
                        exit();
                    }
                    else{
                        
                        echo "<script>window.location='signup.php?message=Registration+Failed'</script>";
                        exit();
                    }
                }
            }
        }

    ?>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>