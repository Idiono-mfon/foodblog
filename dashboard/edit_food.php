<?php  require_once('../private/init.php'); ?>
<?php  confirm_user_login();  ?>

<?php

    $food = [];

    $status = false;

    if(!isset($_GET["id"])){
        redirect_to('all_foods.php');
    }

    $id = h($_GET["id"]);

    $status = false;

    if(is_post_request()){
       $_POST = sanitize_html($_POST);
        if(isset($_POST["update_file"]) && $_POST["update_file"] === "yes"){
            // Update the previous file
            // upload the file to the server
            if(!empty($_FILES["file"]['size'])){
                // var_dump($_FILES); exit;
                $result = upload_file($_FILES['file']);
                if($result["mode"]){
                    // Find the file to be deleted
                    $food = find_data('files',['path','files.id as file_id','title','description'],'INNER JOIN foods ON files.id = foods.file_id', 'WHERE foods.id = '.merge_and_escape([$id], $db)); 
                    $result["id"] = $food["file_id"];
                    $result["date_updated"] = date('Y-m-d H:i:s');  // specify date updated
                    if(update_data('files',$result, 'mode, id')){
                        // update the file table with new file name
                        if(unlink(UPLOAD_PATH.'/'.$food["path"])){
                            // delete the file
                            $status = true;
                            // update the previous food path to the updated food path
                            $food["path"] = $result["path"];
                        }

                    }
                }
            }

        }else{
                $food["title"] = $_POST["title"];
                $food["description"] = $_POST["desc"];
                $food["date_updated"] = date('Y-m-d H:i:s');
                $food["id"] = $id;
                $food["user_id"] = 1;
                $status = update_data("foods", $food, "id");
        }


    }else{
        $food = find_data('foods', ['title', 'description', 'path'], 'INNER JOIN files on foods.file_id = files.id', 'WHERE foods.id = '.merge_and_escape([$id], $db));
        
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

                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                 <!-- Dropdown Card Example -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Food Image</h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <form action="<?php echo 'edit_food.php?id='.$id;?>" method="post" enctype="multipart/form-data">
                                            <div class="food-img">
                                                <img class="img-fluid" src="<?php echo UPLOAD_URL.'/'.$food["path"]; ?> " alt="">
                                                <span title="Update image" data-toggle="tooltip" class="update-icon"><i class="fa fa-pen"></i></span>
                                            </div>
                                            <div class="form-group d-none " id="fileBox">
                                                <label for="file">Food Image</label>
                                                <input id="file" class="form-control-file mb-2" type="file" name="file">
                                                <div class="control d-flex justify-content-between">
                                                    <button type="button" class="btn btn-warning btn-xs">Cancel</button>
                                                    <button type="submit" class="btn btn-primary btn-xs">Update Picture</button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" value="yes" name="update_file">
                                            </div>
                                        </form>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-lg-8 col-md-8">
                                 <!-- Dropdown Card Example -->
                                <div class="card shadow mb-4">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Edit Food's Information</h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <form action="<?php echo 'edit_food.php?id='.$id;?>" method="post">
                                            <div class="form-group">
                                                <label for="title">Food Title</label>
                                                <input id="title" class="form-control" type="text" name="title" value="<?php echo $food["title"] ?? ""; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="title">Food Description</label>
                                                <textarea class="form-control" name="desc" id="" cols="30" rows="10"><?php echo $food["description"] ?? ""; ?></textarea>
                                            </div>
                                          
                                            <div class="form-group">
                                                <input class="btn btn-lg btn-block btn-primary"  value="Update Food" type="submit" name="submit">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        
                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
    <?php require_once('../includes/admin/footer.php'); ?>