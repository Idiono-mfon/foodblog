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

    // Dynamic Sql generating Statement
    function generateInsertSql($table, $data=[], $conn, $exclude){
        $columns = array_keys($data);
        $values = array_values($data);
        // Remove Unnecessary Array Values
        if(!is_null($exclude)){
            $values = []; //reset values array
            $excludeArray = explode(",", $exclude);
            $columns = array_diff($columns, $excludeArray); // exclude the specified field
            foreach($data as $key=> $value){
                if(in_array($key, $columns) ){
                    $values[] = $value;
                }
            }
        }
        
        $sql = "INSERT INTO {$table} (";
       
        foreach($columns as $column){
            $sql .="{$column}, ";
        }
        $sql = rtrim($sql, ", ");
        $sql.=")";

        $sql.=" VALUES ( ";
      
        foreach($values as $value){
            $sql .=" '".db_escape($conn, $value)."',  ";
        }
        $sql = rtrim($sql,', ');

        $sql.=") ";
        return $sql;
    }

    function generateDeleteSql($table, $data, $conn){
        $sql = "DELETE FROM {$table} ";
        if(count($data) > 1){
           $sql.=" WHERE id IN (";
           foreach($data as $value){
            $sql.=" '".db_escape($conn, $value)."', "; 
           }
           $sql = rtrim($sql, ', ');

           $sql .=")";
           return $sql;
        }
        $sql.=" WHERE id = ";
        $sql.=" '".db_escape($conn, $data[0])."' ";

        return $sql;
    }

    function generateUpdateSql($table, $data, $conn, $exclude, $limit){
        $columns = array_keys($data);
        $id = $data["id"]; //retrieve the Id
        // Remove Unnecessary Array Values
        if(!is_null($exclude)){
            $newdata = []; //new data array
            $excludeArray = explode(",", $exclude);
            $columns = array_diff($columns, $excludeArray); // exclude the specified field
            foreach($data as $key=> $value){
                if(in_array($key, $columns) ){
                    // Regenerate Data
                    $newdata[$key] = $value;
                }
            }
            // Update the data array
            $data =  $newdata;
        }
        
        $sql = "UPDATE {$table} ";
        $sql.="SET ";

        foreach($columns as $column){
            $sql.="{$column} = '".db_escape($conn, $data[$column])."', ";
        }
        $sql = rtrim($sql, ", ");

        $sql .=" WHERE id = '".db_escape($conn, $id)."' ";

        $sql .="LIMIT {$limit} ";
      
        return $sql;
    }

    function generateSelectById($table, $id, $columns, $conn){
        $columnCount = count($columns);
        $sql = "SELECT ";
        if($columnCount > 1){
          foreach($columns as $column){
            $sql.="{$column}, ";
          } 
          $sql = rtrim($sql, ', ');
        }else{
            $sql.="{$columns[0]}";
        }
        $sql .= " FROM {$table} WHERE id = '".db_escape($conn, $id)."' ";

        return $sql;

    }

    function generateSelectSql($table, $columns, $conn, $joinQuery, $whereQuery){
        $columnCount = count($columns);
        $sql = "SELECT ";
        if($columnCount > 1){
          foreach($columns as $column){
            $sql.="{$column}, ";
          } 
          $sql = rtrim($sql, ', ');
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