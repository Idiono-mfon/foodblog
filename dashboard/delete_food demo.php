<?php  require_once('../private/init.php'); ?>


<?php

    $food = [];

    $status = false;

    $id = $_GET["id"];

    if(is_post_request()){
       
        // $food["title"] = isset($_POST["title"]) ? $_POST["title"] : ""; //ternary operator
        // $food["title"] = $_POST["title"] ??  ""; //noncoaelescing operator

        $sql = "DELETE FROM foods WHERE id = ".$id;


        $status = mysqli_query($db, $sql);
        // $food["title"] = $_POST["title"] ??  "";;
        // $food["description"] = $_POST["desc"] ?? "";

        // Redirect to the page specified
        header('Location: all_foods.php');



        // insert into the database
        
    }else{
        
        $sql = "SELECT title as food_title from foods WHERE id =".$id;

        $result = mysqli_query($db, $sql);

        $title = mysqli_fetch_assoc($result);


    }
    

?>







<?php require_once('../includes/admin/head.php'); ?>

    <!-- Page Wrapper -->
    <?php require_once('../includes/admin/nav.php'); ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Delete Food <i class="fa fa-pen"></i></h1>
                    
                        <?php if($status): ?>
                            <div class="alert alert-primary" role="alert">
                                <h4 class="alert-heading">Food Delete</h4>
                               Food deleted successfully
                            </div>
                        <?php endif; ?>


                    <form action="<?php echo 'delete_food.php?id='.$id?>" method="post">

                        <div class=" border rounded p-3 border-2 text-center display-4 form-group font-50 text-white bg-danger" style="font-size:30px;">
                                Do you want to delete the food: <span class="font-weight-bolder"><?php echo $title["food_title"]; ?> </span>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-lg btn-primary" value="Delete Foods">
                        </div>

                
                    </form>
                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
    <?php require_once('../includes/admin/footer.php'); ?>