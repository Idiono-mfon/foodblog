<?php


    function selectWithJoin($table, $columns, $JoinQuery, $condition, $component=null){


    }

    function find_all_foods(){
        $str = "";
        global $db;
        $sql = "SELECT * FROM foods INNER JOIN files on foods.file_id = files.id ";
        $result = mysqli_query($db, $sql);
        confirm_result($result);
        while($food = mysqli_fetch_assoc($result)){
            // Sanitize data
            $food = sanitize_html($food);
            $str.= "<tr>
            <td>{$food["id"]}</td>
            <td>{$food["title"]}</td>
            <td>{$food["description"]}</td>
            <td><img style=\"width: 50px; height:50px;\" src=\"{$food["path"]}\" alt=\"\"></td>
            <td>{$food["date_created"]}</td>
            <td><a class=\"btn btn-sm btn-primary\" href=\"show_food.php?id={$food['id']}\"><i class=\"fa fa-eye\"></i></a></td>
            <td><a class=\"btn btn-sm  btn-primary\" href=\"edit_food.php?id={$food["id"]}\"><i class=\"fa fa-pen\"></i></a></td>
            <td><a class=\"btn btn-sm  btn-danger\" href=\"delete_food.php?id={$food["id"]}\"><i class=\"fa fa-trash\"></i></a></td>
        </tr>";
        }


            return $str;

    }

    function insert_data($table, $data, $exclude =null){
        global $db;
       $sql =  generateInsertSql($table, $data, $db, $exclude);
        // $sql = "INSERT INTO foods (user_id, title, description, file_id) VALUES ( ";
        // $sql.= " '".db_escape($db, $food["user_id"])."', ";
        // $sql.= " '".db_escape($db, $food["title"])."', ";
        // $sql.=" '".db_escape($db, $food["desc"])."', ";
        // $sql.=" '".db_escape($db, $food["img"])."' ";
        // $sql.=")";
        $result = mysqli_query($db, $sql);
        return exit_db("Error Occurred While Inserting Data",$result, $db); //result is always true here
    
    }

    function delete_food($id){
        global $db;
        $sql = "DELETE FROM foods WHERE id = ";
        $sql.=" '".db_escape($db, $id)."' ";
        $result = mysqli_query($db, $sql);
        return exit_db("Deleting Food failed",$result, $db); //result is always true here
    }

    function find_food_by_id($id){
        global $db;
        $sql = "SELECT * FROM foods ";
        $sql .="WHERE id = '".db_escape($db, $id)."' ";
        $result = mysqli_query($db, $sql);
        confirm_result($result);
        $food = mysqli_fetch_assoc($result); //fetch Food
        // sanitize Food
        return sanitize_html($food);
    }


    function update_food($food){
        global $db;
        $sql = " UPDATE foods SET  ";
        $sql.="title = '".db_escape($db, $food["title"])."',  ";
        $sql.="description = '".db_escape($db, $food["desc"])."',  ";
        $sql.="date_updated = '".db_escape($db, $food["date_updated"])."' ";
        $sql .="WHERE id = '".db_escape($db, $food["id"])."' ";
        $result = mysqli_query($db, $sql);
        return exit_db("Updating Food failed",$result, $db); //result is always true here
    }


    function insert_file($file){
        global $db;
        $sql = "INSERT INTO files (name, path, type) VALUES ( ";
        $sql.= " '".db_escape($db, $file["name"])."', ";
        $sql.= " '".db_escape($db, $file["path"])."', ";
        $sql.=" '".db_escape($db, $file["type"])."' ";
        $sql.=")";
        $result = mysqli_query($db, $sql);
        return exit_db("File Insertion failed",$result, $db ); //result is always true here
    
    }

    // $response["name"] = $result["name"];
	// 			$response["path"] = $file_path;
	// 			$response["type"] = $file_type;
	// 			$response["mode"] = true;
            


?>