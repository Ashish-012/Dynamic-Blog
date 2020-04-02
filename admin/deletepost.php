<?php
    include_once '../includes/connection.php';
    session_start();
    if(!isset($_GET['id'])){
        header("Location: index.php");
        exit();
    }
    else{
        if(!isset($_SESSION['author_role'])){
            header('Location: login.php?message=Please+Login+First');
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
                    header("Location: posts.php?message=No+Such+Post+Exist");
                    exit();
                }
                $sql = "DELETE FROM post WHERE post_id ='$id'";
                if(mysqli_query($conn, $sql)){
                    header("Location: posts.php?message=Successfully+Deleted+Post");
                    exit();
                }
                else{
                    header("Location: posts.php?message=Could+Not+Delete+Your+Post");
                    exit();
                }

            }
        }
    }
?>