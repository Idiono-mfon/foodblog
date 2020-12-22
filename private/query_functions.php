<?php
    function find_data($table, $columns, $joinQuery=null, $whereQuery=null){
        global $db;
        $sql = generateSelectSql($table, $columns, $db, $joinQuery, $whereQuery);
        // $sql = "SELECT * FROM foods INNER JOIN files on foods.file_id = files.id ";
        $result = mysqli_query($db, $sql);
        confirm_result($result);
        if($result->num_rows === 1){
            return sanitize_html(mysqli_fetch_assoc($result));
        }
        return $result; //result object
        
    }

    function insert_data($table, $data, $exclude =null){
        global $db;
       $sql =  generateInsertSql($table, $data, $db, $exclude);
        $result = mysqli_query($db, $sql);
        return exit_db("Error Occurred While Inserting Data",$result, $db); //result is always true here
    
    }

    function delete_data($table, $data){
        global $db;
        $sql = generateDeleteSql($table, $data, $db);
        $result = mysqli_query($db, $sql);
        return exit_db("Error Occurred While Deleting Data",$result, $db); //result is always true here
    }

    function find_data_by_id($table, $columns, $id){
        global $db;
        $sql = generateSelectById($table, $id, $columns, $db);
        $result = mysqli_query($db, $sql);
        confirm_result($result);
        $data = mysqli_fetch_assoc($result); //fetch Food
        // sanitize Food
        return sanitize_html($data);
    }

   
    function update_data($table, $data, $exclude, $limit=1){
        global $db;
        $sql = generateUpdateSql($table, $data, $db, $exclude, $limit);
        $result = mysqli_query($db, $sql);
        return exit_db("Error Occurred While Updating Data",$result, $db); //result is always true here
    }



?>