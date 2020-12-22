<?php
    session_start(); //start a session
    define('PRIVATE_PATH', dirname(__FILE__));
    define("PROJECT_PATH", dirname(PRIVATE_PATH));
    define('INCLUDES_PATH', PROJECT_PATH.'/includes');
    define('UPLOAD_PATH', PROJECT_PATH.'/uploads');
    define('UPLOAD_URL','/foodblog/uploads');
    require_once('db_functions.php');
    require_once('functions.php');
    require_once('query_functions.php');
    require_once('file_upload_functions.php');
    require_once('validation_functions.php');
    require_once('authentication.php');
    require_once('components.php');
    require_once('pagination.php');
    
    $db = db_connect();

    // $GLOBALS["path"] = "/";
    

?>