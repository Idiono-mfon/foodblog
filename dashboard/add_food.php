<?php  require_once(dirname(dirname(__FILE__)).'/private/init.php'); ?>
<?php  confirm_user_login();  ?>
<?php
    $food = []; $errors = []; $status = false;
    if(is_post_request()){
        $_POST = sanitize_html($_POST);
        $food["title"] =  $_POST["title"];
        $food["description"] =  $_POST["desc"];
         // validated the data
         $valResult  = validate_data($food, ['title'=>'title'], 'description');
        if(!$valResult){
            // No validation Error Continue Processing
            $file = $_FILES["file"];
            //  There is no error here
            $result = upload_file($file);
            if($result["mode"]){
                // File is uploaded Successfully
                $status = insert_data('files', $result,"mode");
                $file_id = get_id($db);
                // insert Here
                $food["file_id"] =  $file_id;
                $food["user_id"] = $_SESSION["user_id"];
                $result = insert_data('foods', $food);
                $status = true;
            }else{ $errors = $result; /*Error that occured while uplaoding files */}
        }else{
            // There are errors during validation
            $errors = $valResult;
        }
        
        
    }
    

?>

<?php require_once(INCLUDES_PATH.'/admin/head.php'); ?>

    <!-- Page Wrapper -->
    <?php require_once(INCLUDES_PATH.'/admin/nav.php'); ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Add New Food <i class="fa fa-pen"></i></h1>

                    <?php if($status) :?>
                        <div class="alert alert-success" role="alert">
                            New Food is added succesfully                       
                        </div>
                    <?php endif; ?>
                      
                    <?php
                        //echo all error that occured while uploading files
                       echo display_multiple_errors($errors);
                    ?>

                    <div class="card">
                        <div class="card-body ">
                            <form action="add_food.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="title">Food Title</label>
                                    <input id="title" class="form-control" type="text" name="title" value="<?php echo $food["title"] ?? ""; ?>">
                                    <?php echo form_error_component($errors, 'title'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="title">Food Description</label>
                                    <textarea class="form-control" name="desc" id="" cols="30" rows="10"><?php echo $food["desc"] ?? ""; ?></textarea>
                                    <?php echo form_error_component($errors, 'description'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="file">Food Image</label>
                                    <input id="file" class="form-control-file" type="file" name="file">
                                </div>
                            <div class="form-group">
                                <input class="btn btn-lg btn-block btn-primary"  value="Upload Food" type="submit" name="submit">
                            </div>
                        </form>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
    <?php require_once(INCLUDES_PATH.'/admin/footer.php'); ?>