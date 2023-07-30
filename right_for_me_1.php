<?php

    require("connect.php");
    require('functions.php');

    echo $_SESSION['USER']['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPa | Right for Me</title>
    <style>
   .skiptranslate iframe  {
    visibility: hidden !important;
    } 
    body{
    top:0!important;
    }
   </style>
</head>
<body>
    <section>
        <!-- navigation bar with logo -->
        <?php include('header.php') ?>

        <div>
            <h1>Is it right for me?</h1>
            <div class="search-container">
                <form action="/action_page.php">
                <input type="text" placeholder="Search.." name="search">
                </form>
            </div>
        </div>

        <h3>Pick what's important to you</h3>

        <a href="right_for_me_quiz.php">Take the quiz</a>

        <p>Empower yourself with the freedom to choose: use a contraceptive method</p>
        <h2>Contraceptive Methods</h2>

        <section class="js-display-methods">
            <div style="padding:10px;text-align:center;">Loading contraceptive methods....</div>
        </section>
        <br><br>

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
