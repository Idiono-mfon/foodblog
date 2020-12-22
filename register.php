<?php
    require_once(dirname(__FILE__).'/private/init.php');
    $status = false;

    // echo 'http://devclass.test:8081/foodblog/register.php?user='.u('Adam@').'&password='.u(1234);

    // exit;
    
    // echo $_GET["user"];
    
    // echo '</br>';

    // echo '';

    // echo $_GET["password"];

    // exit;
    
    if(is_post_request()){
        $user = sanitize_html($_POST);
        // Uploads files
        $result = upload_file($_FILES["profile_img"]);
        if($result["mode"]){
            //file uploaded sucessfully
           insert_data('files',$result, 'mode');
           $user["profile_img"] = get_id($db);
            //validate User
           $val_result =  validate_user($user);
            if(!$val_result["error"]){
                // No errors
                 // insert user
                 $user = $val_result;
                $status =  insert_data('users',$user,'confirm_pass,error');
            }else{
                // Display errors
            }
           

        }else{
            //TODO: print out the errors
        }
        
    }





?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?='TediFoods - Registration'; ?></title>
    <link rel="stylesheet" href="Assets/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="Assets/CSS/food.css">
</head>

<body style="margin: 100px 0 100px 0 ;">
    <div class="container-fluid">
        <div class="sidenav" id="mySidenav">
            <p id="close-button">Close Menu</p>
            <a href="#the-food" id="food-link">Foodie</a>
            <a href="#my-passion" id="passion-link">Aboutie</a>
        </div>
        <nav class="text-white pb-3 nav justify-content-between fixed-top" style="background:hsl(312, 31%, 45%); padding-left:70px;">
        <h3 class="nav-item food" style="font-weight:bolder; font-size:30px;">
               <a style="text-decoration:none; color:#fff;" href="index.php"> TediFoods</a>
            </h3>
            <div class="top-nav d-flex justify-content-end align-items-center">
                <li class="nav-item item-1" id="open-nav">
                    <i class="fa fa-bars"></i>
                </li>
                <li class="nav-item">
                    <a class="pr-5 welcome-text">Welcome <?php echo (is_logged_In()) ? $_SESSION["first_name"].' '.$_SESSION["surname"]:''; ?>  </a>
                </li>
                <?php if(!is_logged_In()) {?>
                    <li class="nav-item">
                        <a href="register.php" class="pr-5">Register</a>
                    </li>
                    <li class="nav-item">
                    <a data-toggle="modal" data-target="#login" style="cursor:pointer;" class="pr-5">Login</a>
                </li>
                <?php } ?>
                <?php if(is_logged_In()) {?>
                    <li class="nav-item">
                        <a style="cursor:pointer;" href="logout.php" class="pr-5">logout</a>
                    </li>
                <?php } ?>
            </div>
        </nav>
   <div class="container">
       <h2 class="text-center mb-5 mt-3">Register and become a Member</h2>
       
       <?php if($status){ ?>
            <div class="alert alert-primary" role="alert">
                <h4 class="alert-heading">Registration Succesfully</h4>
                Registration Succesful. Login now
            </div>

        <?php } ?>
       
       <div class="row content-wrapper">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="system-media">
                    <img src="Assets/images/cherries.jpg" class="img-fluid  rounded" alt="">
                </div>
            </div>
            <div class="form-box col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <form action="register.php" method="post" enctype="multipart/form-data">
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
                        <input id="password"  value="<?php echo $_POST["password"] ?? ""; ?>" name="password" class="form-control form-control-lg" type="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_pass">Confirm Password</label>
                        <input id="confirm_pass"  value="<?php echo $_POST["confirm_pass"] ?? ""; ?>" name="confirm_pass" class="form-control form-control-lg" type="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="file">Profile Picture</label>
                        <input id="file" type="file" name="profile_img" class="form-control form-control-file-lg">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </form>
            </div>
        </div>
   </div>

    <div id="login" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="login-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="login-modal">Login Now</h5>
                            <button class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="index.php">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input id="username" class="form-control" type="text" name="username">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" class="form-control" type="password" name="password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm _pass">Confirm Password</label>
                                    <input id="confirm_pass" class="form-control" type="password" name="confirm_pass">
                                </div>
                                <div class="form-group">
                                  <button type="submit" class="btn btn-primary btn-block btn-lg"> Login</button>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            Not Registered ? <a href="register.php">Register Here</a>
                        </div>
                    </div>
        </div>
    </div>

    <script src="Assets/javascript/jquery.js"></script>
    <script src="Assets/javascript/popper.js"></script>
    <script src="Assets/javascript/bootstrap.min.js"></script>
</body>
</html>