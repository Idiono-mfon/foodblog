<?php

    $valErrors = [
        "name" => [],
        
        "title"=> [
            'Title cannot be empty',
            'Title cannot be less than 5 characters',
            'Title cannot be numeric'
        ],

    ];
    
    $errorArray = [];//Defaultly No errors is recorded

    function is_blank($value) {
        return !isset($value) || trim($value) === '';
    }

    function has_presence($value) {
        return !is_blank($value);
    }

    function has_length_greater_than($value, $min) {
        $length = strlen($value);
        return $length > $min;
    }

    function has_length_less_than($value, $max) {
        $length = strlen($value);
        return $length < $max;
    }

    function has_length_exactly($value, $exact) {
        $length = strlen($value);
        return $length == $exact;
    }

    function isNumeric($data){
        return is_numeric(trim($data));
    }

    function string_contain_specific_character($haystack,$neddle,$expectedpos){
        $pos = strpos($haystack,$neddle);
        return (int)$pos === $expectedpos ? true : false;
    }


    function errorsFunc($rule, $unvalidatedData){
        global $valErrors; $errorResult = [];
        $unvalidatedDataKey = array_keys($unvalidatedData)[0];
        $unvalidatedDataValue = array_values($unvalidatedData)[0];
        switch ($rule) {
            case 'title':
                if(is_blank($unvalidatedDataValue)){
                    $errorResult[$unvalidatedDataKey] =  $valErrors[$rule][0];
                }elseif(has_length_less_than($unvalidatedDataValue, 5)){
                    $errorResult[$unvalidatedDataKey] =  $valErrors[$rule][1];
                }elseif(isNumeric($unvalidatedDataValue)){
                    $errorResult[$unvalidatedDataKey] =  $valErrors[$rule][1];
                }
                break;
            
            default:
                # code...
                break;
        }

        return $errorResult;


    }


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

    function validate_data($data=[], $SpecifiedRules=[], $excludedData = null){
        global $valErrors, $errorArray;
        // regenerate and exclude data specified in the excludeData parameter 
        $data = exclude_and_regenerate($data, $excludedData);
        $defaultRuleKeys = array_keys($valErrors);
        $SpecifiedRulesValues = array_values($SpecifiedRules);
        $rulesCount = count($SpecifiedRulesValues);
        $dataKey = array_keys($data);
        $dataValue = array_values($data);
        for($i = 0;  $i <= $rulesCount-1; $i++){
            if(in_array($SpecifiedRulesValues[$i], $defaultRuleKeys)){
                $unvalidatedData[$dataKey[$i]] = $dataValue[$i];
                $returnedErrorResult = errorsFunc($SpecifiedRulesValues[$i], $unvalidatedData);
                if(!empty($returnedErrorResult)){
                    $errorArray[$dataKey[$i]] = $returnedErrorResult[$dataKey[$i]];
                }

            }else{
                throw new Exception("Invalid Error Rule", 1);
            }

        }

        return !empty($errorArray) ? $errorArray : false;

    }



?>