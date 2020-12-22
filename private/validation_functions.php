<?php

    function validate_user($user = []){
        $errors = []; 
        if($user["password"] === $user["confirm_pass"]){
            $user['password'] = password_hash($user["password"], PASSWORD_BCRYPT);
        }else{
            $errors[] = "Password is not similar";
        }
        if(empty($errors)){
            //no errors
            $user["error"] = false; 
            return $user;
        }else{
            $errors["error"] = true;
            return $errors;
        }
    }



?>