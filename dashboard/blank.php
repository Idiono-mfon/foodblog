<?php  require_once('../private/init.php'); ?>


<?php

    $food = [];

    if(is_post_request()){
       
        // $food["title"] = isset($_POST["title"]) ? $_POST["title"] : ""; //ternary operator
        // $food["title"] = $_POST["title"] ??  ""; //noncoaelescing operator

        $food["title"] = $_POST["title"];
        $food["desc"] = $_POST["desc"];
        // $food["img"] = "wine.jpg";
        $food["img"] = "popsicle.jpg";
        $food["user_id"] = "1";

        $sql = "INSERT INTO foods (user_id, title, description, img) VALUES ('{$food['user_id']}', '{$food['title']}', '{$food['desc']}', '{$food['img']}') ";


        $result = mysqli_query($db, $sql);
        // $food["title"] = $_POST["title"] ??  "";;
        // $food["description"] = $_POST["desc"] ?? "";

        // validate Data

        // insert into the database
        
    }
    

?>







<?php require_once('../includes/admin/head.php'); ?>

    <!-- Page Wrapper -->
    <?php require_once('../includes/admin/nav.php'); ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Add New Food <i class="fa fa-pen"></i></h1>

                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
    <?php require_once('../includes/admin/footer.php'); ?>