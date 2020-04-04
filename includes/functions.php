<?php
    include_once "connection.php";

    function jumbotron(){
        echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                <h1 class="display-4">Fluid jumbotron</h1>
                <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
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