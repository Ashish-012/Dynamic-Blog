<?php
    include_once "connection.php";

    function jumbotron(){
        echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                <h1 class="display-4">My Blog</h1>
                <p class="lead">Welcome to my website! Here are some posts. If you wish to add a post go to Dashboard.</p>
                </div>
              </div>';
    }

    function getAuthorName($id){
        global $conn;
        $sql = "SELECT * FROM author where author_id = '$id'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $author_name = $row['author_name'];
        }
        echo $author_name;
    }

    function getCategory($id){
        global $conn;
        $sql = "SELECT * FROM category where category_id = '$id'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $name = $row['category_name'];
            echo $name;
        }
        
    }
?>