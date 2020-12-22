<?php

    function is_post_request(){
        return $_SERVER["REQUEST_METHOD"] === "POST";
    }

    function is_get_request(){
        return $_SERVER["REQUEST_METHOD"] === "GET";
    }

    function h($str){
        return htmlspecialchars($str);
    }

function sanitize_html($data = []){
    $sanitize_array = [];
    foreach($data as $key => $value){
        $sanitize_array[$key] = h($value);
    }
    return $sanitize_array;
}

function redirect_to($location){
    return header('Location: '.$location);
}

function u($data){
    return urlencode($data);
}

function full_upload_url($path){
    return UPLOAD_URL.'/'.$path;
}

function full_upload_path($path){
    return UPLOAD_PATH.'/'.$path;
}



?>