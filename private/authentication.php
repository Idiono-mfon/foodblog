<?php
    define('MAX_LOGIN_TIME', 3600);
    
    function login_user($user = []){
        // regenerate a new session id and delete the old session
        session_regenerate_id(true);
        $_SESSION["username"] = $user["username"];
        $_SESSION["first_name"] = $user["first_name"];
        $_SESSION["surname"] = $user["surname"];
        $_SESSION["login_time"] = time();
        $_SESSION["dp"] = $user["path"];
        $_SESSION["admin"] = $user["role"];
        $_SESSION["user_id"] = $user["id"];
        // redirect to the dashboard
        redirect_to('dashboard/index.php');

    }

    function is_logged_In(){
        // authenticate the user
        return (isset($_SESSION["username"]) && recent_login_time());
    }

    function recent_login_time(){
        // Confirm if the specified maximum login time has elapsed
        if(isset($_SESSION["login_time"])){
           if( ($_SESSION['login_time'] + MAX_LOGIN_TIME) < time() ){
               return false;
           }else{
               return true;
           }
        }else{
            return false;
        }
    }

    function logout_user(){
        unset($_SESSION["username"]);
        unset($_SESSION["login_time"]);
        unset($_SESSION["first_name"]);
        unset($_SESSION["surname"]);
        unset($_SESSION["dp"]);
        unset($_SESSION["user_id"]);
        session_destroy();

        return true;
    }

    function confirm_user_login(){
        if(!is_logged_In()){
            redirect_to('../index.php');
        }
    }

  function confirm_logout(){
    if(logout_user()){
        redirect_to('index.php');
    }
  }


?>