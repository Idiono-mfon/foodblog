<?php

    require_once('db_credentials.php');


    function db_connect(){
        $conn = mysqli_connect(DB_HOST,DB_USER, DB_PASS, DB_NAME);
        confirm_connection($conn);
        return $conn;
    }

    function confirm_connection($db){
        if(mysqli_connect_errno()){
            $str = "Error occured during connnection ";
            $str.mysqli_connect_error();
            $str." ( ".mysqli_connect_errno()." )";
            exit($str);
        }
       
    }

    function db_disconnect($db){
        return mysqli_close($db);
    }

    function db_escape($db, $str){
        return mysqli_real_escape_string($db, $str);
    }

    function confirm_result($result){
        if(empty($result->num_rows)){
            exit("Data does not exists");
        }
    }

    function exit_db ($msg, $result, $db){
        if($result){
            return $result;        
        }else{
            exit($msg." (". mysqli_error($db).")");
        }
    }

    function get_id($db){
        return mysqli_insert_id($db);
    }

    function exclude_and_regenerate($data, $exclude_param){
        $columns = array_keys($data);
        // $values = array_values($data);
        if(!is_null($exclude_param)){
            $newData = []; //redeclare a new data array
            $excludeArray = explode(",", $exclude_param);
            $columns = array_diff($columns, $excludeArray); // exclude the specified field
            foreach($data as $key=> $value){
                if(in_array($key, $columns)){
                    $newData[$key] = $value;
                }
            }
            // reassign the new data array to the previous data array
            $data = $newData;
        }

        return $data;

    }

    function merge_columns_to_str($columns){
        $str = "";
        foreach($columns as $column){
            $str .="{$column}, ";
        }
        $str = rtrim($str, ", ");

        return $str;

    }

    function merge_and_escape($values, $conn){
        $str= "";
        $valueCount = count($values);
        if($valueCount > 1){
            foreach($values as $value){
                $str .=" '".db_escape($conn, $value)."',  ";
            }
            $str = rtrim($str,', ');
    
            return $str;
        }else{
            $str.=" '".db_escape($conn, $values[0])."' ";
            return $str;
        }
        
    }

    function merge_columns_and_values($data, $conn){
        $str = "";
        $columns = array_keys($data);
        foreach($columns as $column){
            $str.="{$column} = '".db_escape($conn, $data[$column])."', ";
        }
        $str = rtrim($str, ", ");

        return $str;
    }

    // Dynamic Sql generating Statement
    function generateInsertSql($table, $data=[], $conn, $exclude){
        $data = exclude_and_regenerate($data, $exclude);
        $columns = array_keys($data);
        $values = array_values($data);
        $sql = "INSERT INTO {$table} (";
        $sql.= merge_columns_to_str($columns); //convert columns to string
        $sql.=")";
        $sql.=" VALUES ( ";
        $sql.= merge_and_escape($values, $conn); //convert values to string and escape special characters
        $sql.=") ";
        return $sql;
    }

    function generateDeleteSql($table, $data, $conn){
        $sql = "DELETE FROM {$table} ";
        if(count($data) > 1){
           $sql.=" WHERE id IN (";
           $sql.= merge_and_escape($data, $conn); //convert data to string and escape special characters
           $sql .=")";
           return $sql;
        }
        $sql.=" WHERE id = ";
        $sql.= merge_and_escape($data, $conn); //escpae single data and return data str
        return $sql;
    }

    function generateUpdateSql($table, $data, $conn, $exclude, $limit){
        $id = $data["id"]; //retrieve the Id
        // exit($id);
        $data = exclude_and_regenerate($data, $exclude);
        $columns = array_keys($data);
        $sql = "UPDATE {$table} ";
        $sql.="SET ";
        $sql.= merge_columns_and_values($data, $conn);
        $sql.=" WHERE id = ";
        $sql.= merge_and_escape([$id], $conn); //escape single data and return data str
        $sql .="LIMIT {$limit} ";
        return $sql;
    }

    function generateSelectById($table, $id, $columns, $conn){
        $columnCount = count($columns);
        $sql = "SELECT ";
        if($columnCount > 1){
         $sql.= merge_columns_to_str($columns);
        }else{
            $sql.="{$columns[0]}";
        }
        $sql .= " FROM {$table} WHERE id = ";
        $sql .= merge_and_escape([$id], $conn);
        return $sql;

        //merge_and_escape([$id], $conn) // '".db_escape($conn, $id)."' ";

    }

    function generateSelectSql($table, $columns, $conn, $joinQuery, $whereQuery){
        $columnCount = count($columns);
        $sql = "SELECT ";
        if($columnCount > 1){
            $sql.= merge_columns_to_str($columns);
        }else{
            $sql.="{$columns[0]}";
        }
        $sql .= " FROM {$table} ";

        if(!is_null($joinQuery)){
            $sql.=" ".$joinQuery;
        }

        if(!is_null($whereQuery)){
            $sql .= " ".$whereQuery; //Always Escape Where query
        }

        

        return $sql;

    }





?>