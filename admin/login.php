<?php
    include_once '../includes/connection.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            <center><h1 class="h2 mb-3 font-weight-normal">Log In!</h1></center>

            <input type="email" name='author_email' id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

            <input type="password" name='author_password' id="inputPassword" class="form-control" placeholder="Enter Password" required autofocus>
            
            <button class="btn btn-lg btn-primary btn-block" name='submit' type="submit" style='margin-top:20px; margin-bottom:10px;'>Log In</button>
        </form>
        <center><h1 class="h3 mb-3 font-weight-normal">OR</h1></center>
        <a href='signup.php'><button class="btn btn-lg btn-warning btn-block">Sign up</button></a>
    </div>

    <?php 
        if(isset($_POST['submit'])){
            $author_name = mysqli_real_escape_string($conn,$_POST['author_name']);
            $author_email = mysqli_real_escape_string($conn,$_POST['author_email']);
            $author_password = mysqli_real_escape_string($conn,$_POST['author_password']);
            
            // checking for empty fields
            if(empty($author_email) OR empty($author_password)){
                header("Location: login.php?message=Empty+Fields");
                exit();
            }

            if(!filter_var($author_email,FILTER_VALIDATE_EMAIL)){
                header("Location: login.php?message=Please+Enter+Valid+Email");
                exit();
            }
            else{
                $sql2 = "SELECT * FROM `author` WHERE `author_email`='$author_email'";

                $result = mysqli_query($conn,$sql2);
                
                // if email does not exist

                if(mysqli_num_rows($result)<=0){
                    header("Location: login.php?message=Email+or+Password+is+incorrect");
                    exit();
                }

                // if email exists check for password
                else{
                    while($row = mysqli_fetch_assoc($result)){
                        if(!password_verify($author_password,$row['author_password'])){
                            header("Location: login.php?message=Incorrect+Password");
                            exit();
                        }
                        // if email and password is correct send him to the main page
                        else if(password_verify($author_password,$row['author_password'])){
                            $_SESSION['author_id'] = $row['author_id']; 
                            $_SESSION['author_email'] = $row['author_email']; 
                            $_SESSION['author_name'] = $row['author_name']; 
                            $_SESSION['author_bio'] = $row['author_bio']; 
                            $_SESSION['author_role'] = $row['author_role'];
                            header("Location: index.php"); 
                            exit();
                        }
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