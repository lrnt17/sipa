<?php

    require("connect.php");
    require('functions.php');



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
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

        .rfm_link{
            color: var(--bs-navbar-active-color) !important;
        }

        .vl {
            width: 10px;
            background-color: #1F6CB5;
            border-radius: 99px;
            height: 50px;
            display: -webkit-inline-box;
        }

        .circle {
        padding: 1%;
        background-color: #D2E0F8;
        width: 3.7em;
        height: 3.7em;
        border-radius: 100%;
        text-align: center;
        font-size: 3em;
        line-height: 3em;
        font-weight: 100;
        margin-left: auto;
        margin-right: auto;
        margin-top: 1.5%;
        margin-bottom: 1.5%;
    }

    .newsCard {
        position: relative;
        width: 280px;
        height: 380px;
        margin: 2rem auto;
        background-color: #fff;
        color:#fff;
        overflow: hidden;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    }

    .newsCaption {
        position: absolute;
        top: auto;
        bottom: 0;
        opacity: 100;
        left: 0;
        width: 100%;
        height: 70%;
        background-color: #1F6CB5;
        padding: 15px;
        -webkit-transform: translateY(75%);
                transform: translateY(75%);
        -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
        -webkit-transition: opacity 0.1s 0.3s, -webkit-transform 0.4s;
        transition: opacity 0.1s 0.3s, -webkit-transform 0.4s;
        transition: transform 0.4s, opacity 0.1s 0.3s;
        transition: transform 0.4s, opacity 0.1s 0.3s, -webkit-transform 0.4s;
    }

    .newsCaption-title {
        margin-top: 0px;
    }

    .newsCaption-content {
        margin: 0;
    }

    .read:hover {
        opacity: 0.6;
    }

    .news-Slide-up:hover .newsCaption {
        opacity: 100;
        -webkit-transform: translateY(0px);
                transform: translateY(0px);
        -webkit-transition: opacity 0.1s, -webkit-transform 0.4s;
        transition: opacity 0.1s, -webkit-transform 0.4s;
        transition: transform 0.4s, opacity 0.1s;
        transition: transform 0.4s, opacity 0.1s, -webkit-transform 0.4s;
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

    <!-- Search Bar-->
    <!--<div class="container"> 

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
     </div>-->
    

    <!--<div>
        <h1>Is it right for me?</h1>
        <div class="search-container">
            <form action="/action_page.php">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>-->
    <div class="container mt-5"> <!-- mt-3-->
        <div class="row" style="align-items: center;">
            <div class="col-auto">
                <div class="vl"></div>
            </div>
        
            <div class="col-auto">
                <h3>Pick what's important to you</h3>
            </div>
        </div>

        <div class="center-container" style="text-align: center;position: relative;">
            <div class="circle shadow-sm" id="circle1" style="background-color: #F2C1A7; position: absolute; width: 3.9em; height: 3.9em;
            left: 48.7%; transform: translate(-47%, -6%); z-index: -2;"></div>

            <div class="circle shadow-sm" id="circle2" style="background-color: #CAA4D0; position: absolute; width: 3.9em; height: 3.9em; left: 51%;
            transform: translate(-55%, 5%); z-index: -1;"></div>
        </div>
        
        <?php if(logged_in()):?>
            <div class="circle d-flex justify-content-center">
                <a href="right_for_me_quiz.php" style="
                font-size: 24px;
                text-decoration: none;
                font-weight: 600; color:#383838;">Take the quiz</a>
            </div>
        <?php else:?>
            <div onclick="contra_method.take_quiz_prohibited()" class="circle d-flex justify-content-center">
                <button class="btn" style="
                font-size: 24px;
                text-decoration: none;
                font-weight: 600; color:#383838;">Take the quiz</button>
            </div>
        <?php endif;?>

        </br></br></br>

        <div class="row">
            <div class="d-flex justify-content-center">
                <div style="width: 15%;
            background-color: #1F6CB5;
            border-radius: 99px;
            height: 6px;"></div>
            </div>
        </div>
        <div class="row mt-4">
            <p class="text-center" style="color:#525252;">Empower yourself with the freedom to choose: Use a contraceptive method</p>
        </div>
        <div class="row">
            <h2 class="d-flex justify-content-center" style="color:#383838;">Contraceptive Methods</h2>
        </div>
        
    </div>

    
   <!-- 
    <<div class="container d-flex justify-content-center">
    <div class="row" style="justify-content: space-evenly;">
        <?php /*
        <?php /*
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
                }*/
        ?>
        
        <div class="col-sm-12 col-lg-4">
            <div class="container d-flex justify-content-center">
                <div class="card m-4" style="width: 80%;">
                    <img src="<?php //echo $row["birth_control_img"]; ?>" class="card-img-top" alt="...">
                    <img src="<?php //echo $row["birth_control_img"]; ?>" class="card-img-top" alt="...">
                    <div class="card-body" style="background-color:#BDD8F0; min-height:12rem;">
                        <h5 class="card-title"><a href="https://example.com" class="" style="text-decoration:none"><span translate="no"><?php echo $row["birth_control_name"]; ?></a></h5><span translate="no">
                        <p class="card-text"><?php //echo $row["birth_control_desc"]; ?></p>
                        <p class="card-text"><?php //echo $row["birth_control_desc"]; ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <?php/* 
        <?php/* 
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
            $a = ceil($a);*/
            //$a = ceil($a);*/
        ?>
    </div>
</div>-->

    
    <!-- page number -->
    <!--<div class="d-flex justify-content-center align-items-center mt-3 mb-5">
        <form method="post" class="d-flex flex-row">
            <?php /*for($b=1; $b<=$a; $b++) { ?>
                <div class="me-2">
                    <input type="submit" value="<?php echo $b; ?>" name="page" class="btn m-2 px-3" style="background: #D2E0F8;">
                </div>
            <?php } */?>
        </form>
    </div>-->
    <section class="js-display-methods">
        <div style="padding:10px;text-align:center;">Loading contraceptive methods....</div>
    </section>
    <br><br>
    
    <!-- footer -->
    <?php include('footer.php') ?>

   <!-- <div class='newsCard news-Slide-up rounded-4'>
        <img src="assets/images/contraceptive.png">
        <div class='newsCaption'>
            <h2 class='newsCaption-title'>Title</h2>
            <p class='newsCaption-content'>
            Blurb to get reader hooked.
            </p>
            <p><a class='newsCaption-link' href='#'>READ MORE</a>  ></p>    
        </div>
    </div>-->

    <!-- contraceptive method template -->
    <template class="js-method-template">
        <div class='newsCard news-Slide-up rounded-4'>
                    <img src="assets/images/contraceptive.png" alt="sample" class="js-method-image" style="width:300px;">
                <div class='newsCaption rounded-4 shadow-sm'>
                <span translate="no"><h5 class="js-method-name newsCaption-title py-2" style="text-align:center;">Pill</h5 ></span>
                    <div class="js-method-desc newsCaption-content px-2"  >
                        is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry's standard dummy text ever 
                        since the 1500s, when an unknown printer took a galley of 
                        type and scrambled it to make a type specimen book.
                    </div>
                <p class="read px-2 mt-2"><a class='js-method-link' href='#' style="text-decoration: none; color: white;"><i class="fa-solid fa-circle-info"> </i> READ MORE</a></p>   
                </div>  
        </div>
    </template>
    <!-- end contraceptive method template -->
</body>
<script>
    var contra_method = {
        load_methods: function(e) {
            let form = new FormData();
            form.append('data_type', 'load_all_methods');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange', function() {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        let obj = JSON.parse(ajax.responseText);

                        if (obj.success) {
                            let method_holder = document.querySelector(".js-display-methods");
                            method_holder.innerHTML = ""; // Clear existing content

                            if (typeof obj.rows == 'object') {
                                for (var i = 0; i < obj.rows.length; i++) {
                                    if (i % 3 === 0) {
                                        // Create a new row for every 3rd iteration
                                        var rowDiv = document.createElement('div');
                                        rowDiv.className = "row";
                                        rowDiv.classList.add("mx-5", "my-5");
                                        rowDiv.style.justifyContent = "space-evenly";
                                        method_holder.appendChild(rowDiv);
                                    }

                                    let colDiv = document.createElement('div');
                                    colDiv.className = "col-lg-3"; // Display three columns per row

                                    let clone_template = document.querySelector(".js-method-template").content.cloneNode(true);

                                    clone_template.querySelector(".js-method-name").innerHTML = obj.rows[i].birth_control_name;
                                    clone_template.querySelector(".js-method-desc").innerHTML = obj.rows[i].birth_control_short_desc;
                                    clone_template.querySelector(".js-method-link").href = 'about-contraceptive.php?id=' + obj.rows[i].birth_control_id;

                                    colDiv.appendChild(clone_template); // Append cloned template to the column
                                    rowDiv.appendChild(colDiv); // Append column to the current row
                                }
                            } else {
                                method_holder.innerHTML = "<div>No posts found</div>";
                            }
                        }
                    }
                }
            });

            ajax.open('post', 'ajax.php', true);
            ajax.send(form);
        },

        take_quiz_prohibited: function() {
            alert("You're not yet signed in. Sign in to have access to the Take the Quiz Section.");
        },
    };

    contra_method.load_methods();
</script>


</html>
