<?php  require_once('../private/init.php'); ?>

<?php
    // if(isset($_POST["submit"])){
    //     echo "This is a post request to the server";
    // }else{
    //     echo "This is a get request";
    // }

    // if($_SERVER["REQUEST_METHOD"] === "POST"){
    //     echo $_SERVER["REQUEST_METHOD"]."<br>";
    //      echo "This is  post request";
    // }
    // else{
    //     echo $_SERVER["REQUEST_METHOD"]."<br>";
    //     echo "This is a get request";
    // }

    if(is_post_request()){
        echo $_SERVER["REQUEST_METHOD"]."<br>";
         echo "This is  post request";
    }else{
        echo $_SERVER["REQUEST_METHOD"]."<br>";
        echo "This is a get request";
    }


    


?>