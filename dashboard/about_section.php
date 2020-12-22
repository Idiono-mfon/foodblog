<?php  require_once('../private/init.php'); ?>
<?php  confirm_user_login();  ?>
<?php
    $id = $_GET["id"] ?? null;
    if(!is_null($id)){
        $id = h($id);
        $section = find_data('sections', ['section_title','main_title','subtitle','description','path','feature_img','enable_section'],'INNER JOIN files ON files.id = sections.feature_img', 'WHERE sections.id = '.merge_and_escape([$id], $db));
    }else{
        $section = find_data('sections', ['sections.id as section_id', 'section_title','main_title','subtitle','description','path','feature_img','enable_section'],'INNER JOIN files ON files.id = sections.feature_img LIMIT 1');

        $id = $section["section_id"];
    }

    $status = null;
    if(is_post_request()){
        $section = sanitize_html($_POST);
        if(is_null($id)){
            // upload files to the server
            $result = upload_file($_FILES["feature_img"]);
            if($result["mode"]){
                    // insert the files to database
                insert_data('files', $result, 'mode');
                $section["feature_img"] = get_id($db);
                $section["name"] = "About";
                $section["enable_section"] =  isset($section["enable_section"]) ? '1' : '0';
                $status = insert_data('sections', $section);
                $id = get_id($db);
                $section["path"] = $result["path"];
            }
        }else{
            // Update food information here
            if(isset($section["update_file"]) && $section["update_file"] === "yes"){
                if(!empty($_FILES["file"]['size'])){
                    // var_dump($_FILES); exit;
                    $result = upload_file($_FILES['file']);
                    if($result["mode"]){
                        // Find the file to be deleted
                        $section = find_data('sections', ['section_title','main_title','subtitle','description','path','feature_img','files.id as file_id','enable_section'],'INNER JOIN files ON files.id = sections.feature_img', 'WHERE sections.id = '.merge_and_escape([$id], $db));
                        $result["id"] = $section["file_id"];
                        $result["date_updated"] = date('Y-m-d H:i:s');  // specify date updated
                        if(update_data('files',$result, 'mode, id')){
                            // update the file table with new file name
                            if(unlink(full_upload_path($section["path"]))){
                                // delete the file
                                $status = true;
                                // update the previous food path to the updated food path
                                $section["path"] = $result["path"];
                            }
    
                        }
                    }
                }


                // Update the file
            }else{
                //Update the food data only
                $section["id"] =  $id;
                $section["enable_section"] =  isset($section["enable_section"]) ? '1' : '0';
               $status =  update_data('sections', $section, 'id');
                //retrieve the section data to be repopulated on the page  after the updating process
               $section = find_data('sections', ['section_title','main_title','subtitle','description','path','feature_img','enable_section'],'INNER JOIN files ON files.id = sections.feature_img', 'WHERE sections.id = '.merge_and_escape([$id], $db));

            }

        }
     
      
      

      

    
        
    }
    

?>







<?php require_once('../includes/admin/head.php'); ?>

    <!-- Page Wrapper -->
    <?php require_once('../includes/admin/nav.php'); ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Manage About Section<i class="fa fa-cogs"></i></h1>

                    <?php if($status){ ?>
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Succesfull</h4>
                            information submitted successfully
                        </div>
                    <?php } ?>

                    <div class="row">
                        <?php if(isset($section["feature_img"])){?>
                            <div class="col-lg-4">
                        <!-- Default Card Example -->
                            <div class="card mb-4">
                                <div class="card-header">
                                About Featured Image
                                </div>
                                <div class="card-body">
                                    <form action="<?php echo 'about_section.php?id='.$id;?>" method="post" enctype="multipart/form-data">
                                        <div class="food-img">
                                            <img class="img-fluid" src="<?php echo full_upload_url($section['path'])?> " alt="">
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
                        <?php } ?>

                        <div class="<?php echo isset($section["feature_img"])? 'col-lg-8':'col-lg-12' ?>">
                    <!-- Default Card Example -->
                        <div class="card mb-4">
                            <div class="card-header">
                              Manage About Section Information
                            </div>
                            <div class="card-body">
                                <form action="<?php echo isset($id) ? "about_section.php?id={$id}":"about_section.php";?>" method="post" enctype="multipart/form-data">
                                  <div class="form-group">
                                      <label for="section-title">Section Title</label>
                                      <input id="section-title" class="form-control" value="<?php echo $section["section_title"] ?? "" ?>" type="text" name="section_title">
                                  </div>
                                  <div class="form-group">
                                      <label for="main-title">Main Title</label>
                                      <input id="main-title" class="form-control" type="text" name="main_title" value="<?php echo $section["main_title"] ?? "" ?>">
                                  </div>
                                  <div class="form-group">
                                      <label for="subtitle">Main Subtitle</label>
                                      <input id="subtitle" class="form-control" type="text" name="subtitle" value="<?php echo $section["subtitle"] ?? "" ?>">
                                  </div>
                                     <div class="form-group">
                                        <label for="description">Description</label>
                                         <textarea id="description" rows="15" cols="8" class="form-control" name="description" rows="3"><?php echo $section["description"] ?? "" ?></textarea>
                                     </div>

                                     <div class="form-check mb-3">
                                         <input id="enable-section" 
                                         <?php 
                                            if(isset($section["enable_section"])){
                                               echo ($section['enable_section'] ==='1') ? 'checked=checked' : '';
                                            }else{
                                                echo 'checked=checked';
                                            }
                                         ?>  class="form-check-input" type="checkbox" name="enable_section">
                                         <label for="enable-section"  class="form-check-label">enable section</label>
                                     </div>
                                    <?php if(!isset($section["feature_img"])){ ?>
                                     <div class="form-group">
                                         <input id="image" class="form-control-file" type="file" name="feature_img">
                                     </div>
                                     <?php } ?>

                                     <div class="form-group">
                                         <button id="submit" class="btn btn-block btn-primary btn-lg" type="submit" >Submit Information</button>
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