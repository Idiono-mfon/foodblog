<?php  require_once(dirname(dirname(__FILE__)).'/private/init.php'); ?>
<?php  confirm_user_login();  ?>

<?php
    $foods = find_data('foods',['foods.id','title', 'description', 'files.path as file_path', 'foods.date_created'], 'INNER JOIN files on foods.file_id = files.id');
?>

<?php require_once(INCLUDES_PATH.'/admin/head.php'); ?>

    <!-- Page Wrapper -->
    <?php require_once(INCLUDES_PATH.'/admin/nav.php'); ?>
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

                                <?php echo food_table($foods); ?>
                                                                                        
                            </tbody>
                        </table>
                    </div>
                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
    <?php require_once(INCLUDES_PATH.'/admin/footer.php'); ?>