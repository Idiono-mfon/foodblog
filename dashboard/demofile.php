<?php  require_once('../private/init.php'); ?>


<?php

    $food = [];

    if(is_post_request()){
        $uploadOk = 1;
         //SANITIZE $_POST array

        //  echo basename('http://devclass.test:8081/foodblog/dashboard/add_food.php');

        //  exit;

        $file = $_FILES['file'];

         $target_dir = "../uploads/";

         $path_info = pathinfo($file["name"]); //Returns array of  information about the file path
         $target_file = $target_dir . $path_info["basename"];
         $imageType = strtolower($path_info["extension"]);
         $check = getimagesize($file["tmp_name"]);
         if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($file["size"] > 1000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageType !== "jpg" && $imageType !== "png" && $imageType !== "jpeg"
        && $imageType !== "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            exit;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                echo "The file ". basename( $file["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        exit;

         

        //  echo $target_file; exit;

         $uploadOk = 1;

    //  var_dump();

         exit;


        $_POST = sanitize_html($_POST);
        $food["title"] =  $_POST["title"];
        $food["desc"] =  $_POST["desc"];
        // $food["img"] = "wine.jpg";
        // $food["img"] = "popsicle.jpg";
        $food["img"] = "salmon.jpg";
        $food["user_id"] = "1";
        // insert Here
        $result = insert_food($food);
        
    }
    

?>







<?php require_once('../includes/admin/head.php'); ?>

    <!-- Page Wrapper -->
    <?php require_once('../includes/admin/nav.php'); ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Add New Food <i class="fa fa-pen"></i></h1>

                    <?php if(isset($result)) :?>
                        <div class="alert alert-success" role="alert">
                            New Food is added succesfully                       
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body ">
                            <form action="add_food.php" method="post" enctype="multipart/form-data">
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
                                <input class="btn btn-lg btn-block btn-primary"  value="Upload Food" type="submit" name="submit">
                            </div>
                        </form>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
    <?php require_once('../includes/admin/footer.php'); ?>