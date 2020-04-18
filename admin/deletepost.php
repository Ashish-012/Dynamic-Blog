<?php
    include_once '../includes/connection.php';
    session_start();
    if(!isset($_GET['id'])){
        
        echo '<script> window.location = "index.php"; </script>';
        exit();
    }
    else{
        if(!isset($_SESSION['author_role'])){
            
            echo '<script> window.location = "login.php?message=Please+Login+First"; </script>';
            exit();
        }
        else{
            if($_SESSION['author_role']!='admin'){
                echo "You cannot access this page!";
                exit();
            }
            else if($_SESSION['author_role']=='admin'){
                $id = $_GET['id'];
                $sqlCheck = "SELECT * FROM post WHERE post_id ='$id' ";
                $result = mysqli_query($conn, $sqlCheck);
                if(mysqli_num_rows($result)<=0){
                    
                    echo '<script> window.location = "posts.php?message=No+Such+Post+Exist"; </script>';
                    exit();
                }
                $sql = "DELETE FROM post WHERE post_id ='$id'";
                if(mysqli_query($conn, $sql)){
                    
                    echo '<script> window.location = "posts.php?message=Successfully+Deleted+Post"; </script>';
                    exit();
                }
                else{
                    
                    echo '<script> window.location = "posts.php?message=Could+Not+Delete+Your+Post"; </script>';
                    exit();
                }

            }
        }
    }
?>