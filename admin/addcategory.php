<?php
    include_once "../includes/functions.php";
    session_start();

    // checking if the submit button is not clicked with some category name
    if(!isset($_POST['submit'])){
        
        echo '<script> window.location = "category.php?message=Please+Enter+Category+Name"; </script>';
        exit();
    }
    // checking if the user is logged in
    else{
        if(!isset($_SESSION['author_role'])){
            
            echo '<script> window.location = "login.php"; </script>';
            exit();
        }
        // checking if user is admin
        else{
            if($_SESSION['author_role']!='admin'){
                echo "You cannot access this page";
                exit();
            }
            //only give access if the user is admin
            else if($_SESSION['author_role']=='admin'){
                $category_name = $_POST['category_name'];
                $sql = "INSERT INTO `category` (category_name) VALUES ('$category_name');";
                if(mysqli_query($conn, $sql)){
                    
                    echo '<script> window.location = "category.php?message=Category+Added+Successfully!"; </script>';
                }
                else{
                    
                    echo '<script> window.location = "category.php?Some+Error+Occured"; </script>';
                }
            }
        }
    }
?>