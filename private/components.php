<?php

    function food_table($result){
        $str = "";
        while($food = mysqli_fetch_assoc($result)){
            // Sanitize data
            $file_path = UPLOAD_URL.'/'.$food['file_path'];
            $food = sanitize_html($food);
            $str.= "<tr>
            <td>{$food["id"]}</td>
            <td>{$food["title"]}</td>
            <td>{$food["description"]}</td>
            <td><img style=\"width: 50px; height:50px;\" src=\"{$file_path}\" alt=\"\"></td>
            <td>{$food["date_created"]}</td>
            <td><a class=\"btn btn-sm btn-primary\" href=\"show_food.php?id={$food['id']}\"><i class=\"fa fa-eye\"></i></a></td>
            <td><a class=\"btn btn-sm  btn-primary\" href=\"edit_food.php?id={$food["id"]}\"><i class=\"fa fa-pen\"></i></a></td>
            <td><a class=\"btn btn-sm  btn-danger\" href=\"delete_food.php?id={$food["id"]}\"><i class=\"fa fa-trash\"></i></a></td>
        </tr>";

        }

        return $str;
    }

    function food_column($result){
        $str = '';
        if(is_array($result)){
            $file_path = UPLOAD_URL.'/'.$result['file_path'];
            $str.='<div class="col-lg-3 col-sm-3 gallery-image">
            <img src="'.$file_path.' " alt="food">
            <p>'.$result["title"].'</p>
            <p class="describe">'.$result["description"].'</p>
        </div>';
        }else{
            while($food = mysqli_fetch_assoc($result)){
                $food = sanitize_html($food);
                $file_path = UPLOAD_URL.'/'.$food['file_path'];
                $str.='<div class="col-lg-3 col-sm-3 gallery-image">
                <img src="'.$file_path.' " alt="food">
                <p>'.$food["title"].'</p>
                <p class="describe">'.$food["description"].'</p>
            </div>';
    
            }
        }
       
        return $str;

    }

    function display_message($status, $msg){
        $str = '';
        if(strlen($msg) !== 0){
            if($status){
                $str.='<div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Success</h4>
               '.$msg.'
            </div>';
                return $str;
            }else{
                $str.='<div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Failure</h4>
               '.$msg.'
             </div>';
             return $str;
            }
        }else{
            return $str;
        }

        
    }

    function form_error_component($data, $key){
        $str = "";
        if(isset($data[$key])){
            $str.= '<div class="text-danger"> '.$data[$key].' </div>';
        }
        return $str;

    }

    function display_multiple_errors($errors){
        $str = "";
        if(isset($errors["mode"])){
            $errors = exclude_and_regenerate($errors, 'mode');
          $str .= ' <ul class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Ooops! Failure</strong> Please fix the following Errors.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>';
          foreach($errors as $error){
            $str.='<li>'.$error.'</li>';
          }
          $str.=" </ul>";
        }
        
        return $str;

    }

?>