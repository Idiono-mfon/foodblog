
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="Assets/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="Assets/CSS/food.css">
</head>

<body>
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