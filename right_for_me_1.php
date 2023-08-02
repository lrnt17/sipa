<?php
    include("connect.php");
    include("functions.php");
    session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>SiPa | Right for Me</title>
    <style>
   .skiptranslate iframe  {
    visibility: hidden !important;
    } 
    body{
    top:0!important;
    }

    .form .fa-solid{
    position: absolute;
    top:20px;
    left: 20px;
    color: #9ca3af;
    }

    .form-input:focus{
    box-shadow: none;
    border:none;
    }

    .vl {
        width: 10px;
        background-color: #1F6CB5;
        border-radius: 99px;
        height: 50px;
        display: -webkit-inline-box;
    }

    .vl-v{
        width: 15%;
        background-color: #1F6CB5;
        border-radius: 99px;
        height: 6px;
    }

   </style>
</head>
<body style="background: #F2F5FF;">
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>

    <div class="container rounded-5" style="background: #D2E0F8;">
        <div class="row mx-5 justify-content-center" style="text-align:center; padding: 4%;">
        
            <div class="col-auto"><p style="font-size: 3.5rem;">Is it</p></div>
            <div class="col-auto"><p style="font-size: 3.5rem; font-weight:bolder;" >right for me?</p></div>
        </div>
    </div>

    <div class="container">

            <div class="row height d-flex justify-content-center align-items-center">

              <div class="col-md-6">

                <div class="form" style="position: relative; top: -30px;">
                <i class="fa-solid fa-magnifying-glass"></i>
                  <input type="text" name="search" id="search"  class="js-search-input form-control form-input" placeholder="Search..." style="height: 55px;
                    text-indent: 33px;
                    border-radius: 15px;">
                </div>
                
              </div>
            </div>
     </div>
    

    <!--<div>
        <h1>Is it right for me?</h1>
        <div class="search-container">
            <form action="/action_page.php">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>-->
    <div class="container mt-3">
        <div class="row" style="align-items: center;">
            <div class="col-auto">
                <div class="vl"></div>
            </div>
        
            <div class="col-auto">
                <h3>Pick what's important to you</h3>
            </div>
        </div>

        </br></br></br></br></br>
        <div class="d-flex justify-content-center">
            <a href="right_for_me_quiz.php">Take the quiz</a>
        </div>
        </br></br></br></br></br></br>

        <div class="row">
            <div class="d-flex justify-content-center">
                <div class="vl-v"></div>
            </div>
        </div>
        <div class="row mt-4">
            <p class="text-center" style="color:#525252;">Empower yourself with the freedom to choose: Use a contraceptive method</p>
        </div>
        <div class="row">
            <h2 class="d-flex justify-content-center" style="color:#383838;">Contraceptive Methods</h2>
        </div>
        
    </div>

    

   

<div class="container d-flex justify-content-center">
    <div class="row" style="justify-content: space-evenly;">
        <?php 
            $page = 0;
            if(isset($_POST["page"])) {
                $page = $_POST["page"];
                $page = ($page * 6) - 6; // counting for 6 images displayed in one page
            }

            $result1 = mysqli_query($conn, "SELECT * FROM birth_controls LIMIT $page, 6");

            $cards_per_row = 3;
            $cards_in_current_row = 0;

            while ($row = mysqli_fetch_array($result1)) {
                if ($cards_in_current_row == 0) {
                    echo '<div class="row">';
                }
        ?>
        
        <div class="col-sm-12 col-lg-4">
            <div class="container d-flex justify-content-center">
                <div class="card m-4" style="width: 80%;">
                    <img src="<?php echo $row["birth_control_img"]; ?>" class="card-img-top" alt="...">
                    <div class="card-body" style="background-color:#BDD8F0; min-height:12rem;">
                        <h5 class="card-title"><a href="https://example.com" class="" style="text-decoration:none"><?php echo $row["birth_control_name"]; ?></a></h5>
                        <p class="card-text"><?php echo $row["birth_control_desc"]; ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <?php 
                $cards_in_current_row++;
                if ($cards_in_current_row == $cards_per_row) {
                    echo '</div>'; // Close the row after displaying 3 cards
                    $cards_in_current_row = 0;
                }
            }
            // Close the row if there are remaining cards
            if ($cards_in_current_row > 0) {
                echo '</div>';
            }

            $result2 = mysqli_query($conn,"SELECT * FROM birth_controls");
            $count = mysqli_num_rows($result2);
            $a = $count / 6;
            $a = ceil($a);
        ?>
    </div>
</div>

    
    <!-- page number -->
    <div class="d-flex justify-content-center align-items-center mt-3 mb-5">
        <form method="post" class="d-flex flex-row">
            <?php for($b=1; $b<=$a; $b++) { ?>
                <div class="me-2">
                    <input type="submit" value="<?php echo $b; ?>" name="page" class="btn m-2 px-3" style="background: #D2E0F8;">
                </div>
            <?php } ?>
        </form>
    </div>
    
    <!-- footer -->
    <footer>
        <div>
            <img src="" alt="">

                <a href="#">Home</a>
                <a href="#">FAQs</a>
                <a href="#">Services</a>
                <a href="#">Contraceptive Method</a>
                <a href="#">Videos</a>
                <a href="#">Period Calculator</a>
                <a href="#">Community Forum</a>
                <a href="#">About STDs</a>

                <p>Our Partner</p>
                <img src="" alt="">

                <h3>+63 912 345 6789</h3>
                <!-- icon -->
                <!-- icon -->
            </div>
            
            <div>
                <!-- Translation Code here -->
                <span>
                    <div class="translate" id="google_translate_element"></div>

                    <script type="text/javascript">
                            function googleTranslateElementInit() {
                            new google.translate.TranslateElement({
                                pageLanguage: 'en',
                                includedLanguages: 'en,tl',
                                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                                autoDisplay: false,
                                multilanguagePage: true
                            }, 'google_translate_element');
                            }
                        </script>
                        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                </span>
                <!-- Translation Code End here -->
                <a href="">Privacy Policy</a>
                <a href="">Terms of Use</a>
            </div>
        </footer>
    </section>
    
    <!-- contraceptive method template -->
    <template class="js-method-template">
        <div class="box">
            <a href="" class="js-method-link">
                <img src="assets/images/contraceptive.png" alt="sample" class="js-method-image">
                <h2 class="js-method-name">Pill</h2>
                <div class="js-method-desc"  >
				    is simply dummy text of the printing and typesetting industry. 
                    Lorem Ipsum has been the industry's standard dummy text ever 
                    since the 1500s, when an unknown printer took a galley of 
                    type and scrambled it to make a type specimen book.
			    </div>
            </a>
        </div>  
    </template>
    <!-- end contraceptive method template -->
</body>
<script>
    var contra_method = {
        load_methods: function(e){

            let form = new FormData();
            form.append('data_type', 'load_all_methods');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        //console.log(ajax.responseText);
                        let obj = JSON.parse(ajax.responseText);
                        
                        if(obj.success){
                            let method_holder = document.querySelector(".js-display-methods");
                            method_holder.innerHTML = "";

                            let template = document.querySelector(".js-method-template");

                            if(typeof obj.rows == 'object')
                            {
                                for (var i = 0; i < obj.rows.length; i++) {
                                    let clone_template = template.content.cloneNode(true);

                                    clone_template.querySelector(".js-method-name").innerHTML = obj.rows[i].birth_control_name;
                                    clone_template.querySelector(".js-method-desc").innerHTML = obj.rows[i].birth_control_desc;
                                    clone_template.querySelector(".js-method-link").href = 'about-contraceptive.php?id='+obj.rows[i].birth_control_id;

                                    /*let clone = template.cloneNode(true);
                                    clone.setAttribute('id','post_'+obj.rows[i].id);
                                    let row_data = JSON.stringify(obj.rows[i]);
                                    row_data = row_data.replaceAll('"','\\"');

                                    clone.setAttribute('row',row_data);
                                    clone.classList.remove('hide');*/
                                    
                                    method_holder.appendChild(clone_template);
                                }
                            }else{
                                method_holder.innerHTML = "<div>No posts found</div>";
                            }
                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },
    };

    contra_method.load_methods();
</script>
</html>
