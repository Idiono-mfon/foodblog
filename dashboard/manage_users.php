<?php  require_once('../private/init.php'); ?>
<?php  

    confirm_user_login();  
    if($_SESSION["admin"] === '1'){
        redirect_to('index.php');
    }


?>
<?php
    $status = false;
    $msg = "";
    $user_count = 1;
    $displayForm = false;
   
    if(is_post_request()){
            // sanitize data
            $user = sanitize_html($_POST);
            $user['id'] = h($_GET["id"]);
            //validate user
            $val_result =  validate_user($user);
            if(!$val_result["error"]){
                // No errors
                 // insert user
                 $user = $val_result;
                 $status = update_data('users',$user, 'id,confirm_pass,error');
                 $msg = 'User updated successfully';
                 $users = find_data('users',['users.*','files.path as profile'],'INNER JOIN files on users.profile_img = files.id ');

            }else{
                // Display errors
            }
        // Update data into database
      
       
    }else{
            if(isset($_GET["id"]) && isset($_GET["mode"]) ){
                $id = h($_GET["id"]);
                // confirm the existence of the user base on the id
                $user = find_data_by_id('users',['id','activated','first_name','surname','username','email'],$id);
                //Retrieve all users to be populated on the page
                    switch($_GET["mode"]){
                        case 'activate':
                            $user['activated'] = 1;
                            $status = update_data('users',$user,'id');
                            $msg = "User activated successfully";
                            //retrieve all users with the activated user included
                            $users = find_data('users',['users.*','files.path as profile'],'INNER JOIN files on users.profile_img = files.id ');
                            break;
                        
                        case 'deactivate':
                            $user['activated'] = NULL;
                            $status = update_data('users',$user,'id');
                            $msg = "User deactivated successfully";
                             //retrieve all users with the deactivated user included
                             $users = find_data('users',['users.*','files.path as profile'],'INNER JOIN files on users.profile_img = files.id ');
                            break;
                        
                        case 'update':
                            $displayForm = true;
                            $users = find_data('users',['users.*','files.path as profile'],'INNER JOIN files on users.profile_img = files.id ');
                            break;

                        case 'delete':
                            $status = delete_data('users', [$user['id']]);
                            $msg = "User is deleted successfully ";
                            $users = find_data('users',['users.*','files.path as profile'],'INNER JOIN files on users.profile_img = files.id ');
                            break;


                    }
               
                // Confirm if user exist
            }else{
                $users = find_data('users',['users.*','files.path as profile'],'INNER JOIN files on users.profile_img = files.id ');
            }
           
      


    }
    

?>







<?php require_once('../includes/admin/head.php'); ?>

    <!-- Page Wrapper -->
    <?php require_once('../includes/admin/nav.php'); ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Manage Users <i class="fa fa-cogs"></i></h1>
                        <?php echo display_message($status, $msg); ?>                  
                        
                    <div class="row">
                        <?php if($displayForm) { ?>
                            <div class="col-lg-4">
                                <!-- Default Card Example -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                    Update User's Information
                                    </div>
                                    <div class="card-body">
                                    <form action="<?php echo 'manage_users.php?id='.$user['id'].'&mode=update';?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="login">first Name</label>
                                            <input type="text" value="<?php echo $user["first_name"] ?? ""; ?>" name="first_name" class="form-control form-control-lg">
                                        </div>
                                        <div class="form-group">
                                            <label for="login">surname</label>
                                            <input type="text"  value="<?php echo $user["surname"] ?? ""; ?>"  name="surname" class="form-control form-control-lg">
                                        </div>
                                        <div class="form-group">
                                            <label for="login">Email</label>
                                            <input type="email"  value="<?php echo $user["email"] ?? ""; ?>" name="email" class="form-control form-control-lg">
                                        </div>
                                        <div class="form-group">
                                            <label for="login">Username</label>
                                            <input type="text"  value="<?php echo $user["username"] ?? ""; ?>" name="username" class="form-control form-control-lg">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input id="password" placeholder="Enter new password"  value="<?php echo $_POST["password"] ?? ""; ?>" name="password" class="form-control form-control-lg" type="password">
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm-pass">Confirm Password</label>
                                            <input id="confirm-pass" placeholder="Confirm new password"  value="<?php echo $_POST["confirm_pass"] ?? ""; ?>" name="confirm_pass" class="form-control form-control-lg" type="password" >
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>

                            </div>
                        <?php } ?>
                        <div class="<?php echo ($displayForm) ? 'col-lg-8': 'col-lg-12'; ?>">
                            <!-- Default Card Example -->
                            <div class="card mb-4">
                                <div class="card-header">
                                   All Users Information
                                </div>
                                <div class="card-body table-responsive">
                                  <table class="table table-light">
                                      <thead class="thead-light">
                                          <tr>
                                              <th>S/N</th>
                                              <th>Name</th>
                                              <th>Username</th>
                                              <th>Email</th>
                                              <th>Profile</th>
                                              <th>Status</th>
                                              <th>Activated</th>
                                              <th>Date added</th>
                                              <th colspan="3">Actions</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php while($user = mysqli_fetch_assoc($users)) {?>
                                            <?php $user = sanitize_html($user); ?>

                                                <?php 
                                                    $mode = $user['activated'] === '1' ? 'deactivate' : 'activate'; 
                                                    $color = $user['activated'] === '1' ? 'bg-warning' : 'bg-success'; 
                                                ?> 
                                                <tr>
                                                    <td><?php echo $user_count?> </td>
                                                    <td><?php echo $user["first_name"].' '. $user["surname"]?> </td>
                                                    <td><?php echo $user["username"]?> </td>
                                                    <td><?php echo $user["email"]?> </td>
                                                    <td><img class="rounded" style="width:60px; height:60px;" src="<?php echo full_upload_url($user['profile'])?>" alt=""></td>
                                                    <td><span class="badge badge-pill badge-primary p-2"><?php echo $user["role"] === '1' ? 'Admin' :'Super Admin' ?></span></td>
                                                    <td> <span class="badge badge-pill <?php echo $user["activated"] === '0' ? 'badge-danger' :'badge-success' ?>"><?php echo $user["activated"] === '0' ? 'No' :'Yes' ?></span></td>
                                                    <td><?php echo $user["date_created"]?> </td>
                                                    <td> <a class="btn btn-danger btn-sm" style="font-size:11px;" href="<?php echo 'manage_users.php?id='.$user['id'].'&mode=delete' ?>">delete</a> </td> 
                                                    <td> <a style="font-size:11px;" class="btn text-white <?php echo $color ;?> btn-sm" href="<?php echo 'manage_users.php?id='.$user['id'].'&mode='.$mode; ?>"><?php echo $mode; ?> </a> </td>
                                                    <td> <a style="font-size:11px;" class="btn btn-primary btn-sm" href="<?php echo 'manage_users.php?id='.$user['id'].'&mode=update'; ?>">update </a> </td> 
                                                   
                                                </tr>
                                                <?php $user_count++?>
                                            <?php } ?> 
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                              <th>S/N</th>
                                              <th>Name</th>
                                              <th>Username</th>
                                              <th>Email</th>
                                              <th>Profile</th>
                                              <th>Status</th>
                                              <th>Activated</th>
                                              <th>Date added</th>
                                              <th colspan="3">Actions</th>
                                          </tr>
                                      </tfoot>
                                  </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
    <?php require_once('../includes/admin/footer.php'); ?>