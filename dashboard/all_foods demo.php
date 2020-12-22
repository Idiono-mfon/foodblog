<?php  require_once('../private/init.php'); ?>


<?php

    $food = [];

    if(is_post_request()){
               
    }

    $sql = "SELECT * FROM foods ";

    $resultObj = mysqli_query($db, $sql);


?>







<?php require_once('../includes/admin/head.php'); ?>

    <!-- Page Wrapper -->
    <?php require_once('../includes/admin/nav.php'); ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">All Foods<i class="fa fa-pen"></i></h1>
                    
                    <div class="table-responsive">
                        <table class="table table-light" border="2">
                            <thead class="bg-dark table-dark">
                                <tr>
                                        <td>id</td>
                                        <td>Food Title</td>
                                        <td>Food Description</td>
                                        <td>Image</td>
                                        <td>Date Added</td>
                                        <td colspan="3">Actions</td>
                                    
                                </tr>
                            </thead>
                            <tbody>

                            <?php while($food = mysqli_fetch_assoc($resultObj)) {?>
                                <tr>
                                    <td><?php echo $food["id"]?> </td>
                                    <td><?php echo $food["title"]?></td>
                                    <td><?php echo $food["description"]?> </td>
                                    <td><img style="width: 50px; height:50px;" src="../Assets/images/<?php echo $food["img"] ?>" alt=""></td>
                                    <td><?php echo $food["date_created"]?></td>
                                    <td><a class="btn btn-sm btn-primary" href="<?php echo 'show_food.php?id='.$food['id'];?>"><i class="fa fa-eye"></i></a></td>
                                    <td><a class="btn btn-sm  btn-primary" href="<?php echo 'edit_food.php?id='.$food["id"]?>"><i class="fa fa-pen"></i></a></td>
                                    <td><a class="btn btn-sm  btn-danger" href="<?php echo 'delete_food.php?id='.$food["id"];?>"><i class="fa fa-trash"></i></a></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
    <?php require_once('../includes/admin/footer.php'); ?>