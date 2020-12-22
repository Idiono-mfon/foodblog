<?php  require_once('../private/init.php'); ?>


<?php

    $food = [];

    $status = false;

    $id = $_GET["id"];

    // exit($id);

    // if(is_get_request()){
    //     var_dump($_GET);
    // }

    if(is_post_request()){
       
        // $food["title"] = isset($_POST["title"]) ? $_POST["title"] : ""; //ternary operator
        // $food["title"] = $_POST["title"] ??  ""; //noncoaelescing operator

        $food["title"] = $_POST["title"];
        $food["desc"] = $_POST["desc"];

        $food["date_updated"] = date('Y-m-d H:i:s');

        // $food["img"] = "wine.jpg";
        // $food["img"] = "popsicle.jpg";
        // $food["user_id"] = "1";

        $sql = " UPDATE foods SET title = '".$food['title']."', description = '".$food['desc']."', date_updated = '".$food["date_updated"]."' WHERE id = '".$id."' LIMIT 1";

        //INSERT INTO foods (user_id, title, description, img) VALUES ('{$food['user_id']}', '{$food['title']}', '{$food['desc']}', '{$food['img']}')


        $status = mysqli_query($db, $sql);
        // $food["title"] = $_POST["title"] ??  "";;
        // $food["description"] = $_POST["desc"] ?? "";

        // validate Data

        // insert into the database
        
    }else{
          

        $sql = "SELECT * FROM foods WHERE id = ".$id;

        $result = mysqli_query($db, $sql);

        $food = mysqli_fetch_assoc($result);

        // var_dump($food); exit;



    }
    

?>







<?php require_once('../includes/admin/head.php'); ?>

    <!-- Page Wrapper -->
    <?php require_once('../includes/admin/nav.php'); ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Edit Food  <i class="fa fa-pen"></i></h1>
                        
                       <?php if($status){ ?>
                            <div class="alert alert-primary" role="alert">
                                <h4 class="alert-heading">Update Successful</h4>
                                    Food was updated successfully!!!
                            </div>
                        <?php } ?>


                        <form action="<?php echo 'edit_food.php?id='.$id;?>" method="post">
                                <div class="form-group">
                                    <label for="title">Food Title</label>
                                    <input id="title" class="form-control" type="text" name="title" value="<?php echo $food["title"] ?? ""; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="title">Food Description</label>
                                    <textarea class="form-control" name="desc" id="" cols="30" rows="10"><?php echo $food["desc"] ?? ""; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="file">Food Image</label>
                                    <input id="file" class="form-control-file" type="file" name="file">
                                </div>
                            <div class="form-group">
                                <input class="btn btn-lg btn-block btn-primary"  value="Update Food" type="submit" name="submit">
                            </div>
                    </form>
                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
    <?php require_once('../includes/admin/footer.php'); ?>