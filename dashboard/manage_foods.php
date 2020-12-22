<?php  require_once('../private/init.php'); ?>
<?php  confirm_user_login();  ?>

<?php

    $food = [];

    if(is_post_request()){
        
    }

    $foods = find_data('foods','title','date_created','inner join files on foods.file_id = files.id');
    

?>







<?php require_once('../includes/admin/head.php'); ?>

    <!-- Page Wrapper -->
    <?php require_once('../includes/admin/nav.php'); ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Manage Foods <i class="fa fa-pen"></i></h1>
                      <!-- Dropdown Card Example -->
                      <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <div class="top d-flex justify-content-center">
                                        <h6 class="m-0 font-weight-bold text-primary">Tedikom Foods Table </h6>
                                        <span class="btn btn-block btn-primary">Add Food</span>
                                    </div>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                


                                    <div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                       <div class="modal-dialog" role="document">
                                           <div class="modal-content">
                                               <div class="modal-header">
                                                   <h5 class="modal-title" id="my-modal-title">My Title Now again</h5>
                                                   <button class="close" data-dismiss="modal" aria-label="Close">
                                                       <span aria-hidden="true">&times;</span>
                                                   </button>
                                               </div>
                                               <div class="modal-body">
                                                   <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iure quis magnam distinctio, veniam cumque fugiat aliquam, atque rem voluptates ut saepe beatae voluptate? Iusto natus ad similique incidunt. Voluptatem, ipsum.</p>
                                               </div>
                                               <div class="modal-footer">
                                                   Footer
                                               </div>
                                           </div>
                                       </div>
                                   </div>

                                </div>
                            </div>
                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
    <?php require_once('../includes/admin/footer.php'); ?>