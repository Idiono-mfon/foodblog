<?php
    require_once(dirname(__FILE__).'/private/init.php');
    $page_title = "Food Blog1";
    if(is_post_request()){
        $data = sanitize_html($_POST);
        // validate here
        if(!empty($data["username"]) && !empty($data["password"])){
              // Login the here
            $user = find_data('users',['users.*, files.path'],'INNER JOIN files on files.id = users.profile_img','WHERE users.username = '.merge_and_escape([$data['username']], $db));
            if(password_verify($data["password"], $user["password"] )){
                if($user["activated"] !== '0'){
                    login_user($user);
                }else{
                    $status = false;
                  
                }
               
               
            }
            
            
            

         
        }

      



    }

    $str = "";

    // Count of all foods
    $total_count = find_data('foods', ['COUNT(*) as count'],'INNER JOIN files on files.id = foods.file_id')['count'];
 
    $current_page = $_GET["page"]  ?? 1;

    $offset = offset($current_page);

    // Find paginated Food
    $foods = find_data('foods', ['title', 'description', 'files.path as file_path'],'INNER JOIN files on files.id = foods.file_id LIMIT '.$per_page.' OFFSET '.$offset);
    
    $pagination = paginated_str($current_page,  $total_count, 'index.php');

    // exit($str);

    $section = find_data('sections', ['section_title','main_title','subtitle','description','path','enable_section'],'INNER JOIN files ON files.id = sections.feature_img LIMIT 1');

    $tags = ["New York", "Dinner", "Salmon", "France", "Drinks", "Ideas", "Flavours", "Cuisine", "Chicken", "Dressing", "Fried", "Fish", "Duck", "Tension"];

    $blogs = [
            ["img" => "workshop.jpg",
            "content" => "Lorem<br>Sed mattis nunc"
        ],

        [   "img" => "gondol.jpg",
            "content" => "Lorem AM BLOG 2<br>Sed mattis nunc"
        ],

        [   "img" => "gondol.jpg",
            "content" => "Lorem AM BLOG 2<br>Sed mattis nunc"
        ]

        
    ];

    foreach($blogs as $blog){ 
       
        $str.= " <div class=\"footer-images\">
        <img src=\"Assets/Images/{$blog['img']}\" alt=\"image\">
        <div><span style=\"display: block;\">{$blog['content']}</span></div>
    </div>";

    }




?>

<?php include('includes/nav.php'); ?>

        <div class="body">
            <?php //echo display_message($status, "Your account is yet to be activated");?>
        <div class="container gallery mt-5" id="the-food">
                <div class="row gallery-container">
                   <?php echo food_column($foods); ?> 
                </div>
               
            </div>

            <div class="container">

                <?php echo $pagination; ?>
                <!-- <nav aria-label="Page navigation" class="item">
                    <ul class="pagination d-flex justify-content-center">
                        <li class="page-item active" aria-current="page">
                            <a href="#">&laquo;<span class="sr-only">(Previous)</span></a>
                        </li>
                        <li class="page-item">
                            <a href="#" tabindex="-1" aria-disabled="true" class="one">1</a>
                        </li>
                        <li class="page-item">
                            <a href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a href="#">4</a>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <a href="#">&raquo;<span class="sr-only">(Next)</span></a>
                        </li>
                    </ul>
                </nav> -->
            </div>
            <?php if($section["enable_section"] === '1') { ?> 
                <div class="container passion">
                    <h3 class="display-5 text-center" id="my-passion"><?php echo $section['section_title']?></h3>
                    <div class="container-fluid mt-5 text-center description">
                        <img class="img col-xs-3" src="<?php echo full_upload_url($section['path'])?>" style="width: 80%;" alt="img">
                        <h4 class="mt-5"><?php echo $section['main_title']?></h4>
                        <i><?php echo $section['subtitle']?></i>
                    </div>
                    <p class="mt-3"><?php echo $section['description']?></p>
                </div>
            <?php } ?>
    <?php include('includes/footer.php'); ?>