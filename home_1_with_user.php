<?php 
    include("connect.php"); 
<<<<<<< HEAD
    //Testing 123
=======
    //Testing
>>>>>>> 85a723fa38235a6f59ff026a8c9f7d1ce95f6815

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet' />
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
    <link
        rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css"
        type="text/css"
    />

    <title>SiPa | Contraceptive Decision Support System</title>

    <script>
        function toggleAnswer(element) {
        var answer = element.nextElementSibling;
        answer.style.display = answer.style.display === "none" ? "block" : "none";
        }
    </script>
    <style>
        body {
            margin: 0;
        }

        #map {
            height: 446px;
            width: 832px;
        }
    </style>
    <script src="script.js" defer></script>
</head>
<body>

    <!-- navigation bar with logo -->
    <div class="navigation-bar" id="navigation-container">
        <img src="#">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Projects</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li>
                <div class="dropdown">
                    <button class="dropbtn">Dropdown<i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                        <a href="#">Link 2</a>
                        <a href="#">Link 3</a>
                    </div>
                </div>
            </li>
            <li><a href="#">Sign in</a></li>
            <div class="profile_pic">
                <a href="profile.php" id="avatar_name" href="#name">
                    <img id="avatar" src="<?php //echo $_SESSION["image"]; ?>" alt="avatar">
                </a>
            </div>
        </ul>
    </div>

    <!-- background picture eme -->
    <img src="" alt="">
    <img src="" alt="">

    <h2>Is it right for me?</h2>
    <p>
        Choosing the appropriate contraceptive method is essential for maintaining 
        reproductive health and preventing unwanted pregnancy.
    </p>
    <a href="#" target="_blank">Find out more</a>

    <p>
        There are many types of contraception available and none are perfect. The 
        Contraception Choices website provides honest information to help weigh 
        up the pros and cons.
    </p>

    <h2>Contraceptive Methods</h2>

    <!-- birth controls pagination -->
    <div class="parent">
        <?php 
            $page=0;
            if(isset($_POST["page"])) {
                $page=$_POST["page"];
                $page=($page*4)-4;//counting for 9 image is displayed in one page
            }

            $result1 = mysqli_query($conn,"SELECT * FROM birth_controls LIMIT $page,4");

            while ($row=mysqli_fetch_array($result1)) 
            {
        ?>

        <div class="gal_section">
            <a href="https://example.com" class="button">
                <div class="img_container">
                    <img src="<?php echo $row["birth_control_img"]; ?>" alt="" height="236" width="354">
                </div>
                <span class="button-text"><?php echo $row["birth_control_name"]; ?></span>
                <span class="button-text"><?php echo $row["birth_control_desc"]; ?></span>
            </a>
        </div>
        
        <?php 
            }

            $result2 = mysqli_query($conn,"SELECT * FROM birth_controls");
            $count = mysqli_num_rows($result2);
            $a=$count/4;
            $a=ceil($a);
        ?>
    </div>
    
    <!-- page number -->
    <form method="post">
        <?php for($b=1;$b<=$a;$b++){ ?>
            <div class="pagination">
                <input type="submit" value="<?php echo $b;?>" name="page" class="links">
            </div>
        <?php } ?>
    </form>
    
    <!-- frequently asked questions -->
    <p>Frequently <br> asked questions</p>
    
    <div class="faq-container">
        <div class="faq">
            <div class="question" onclick="toggleAnswer(this)">How can I have less period pain?</div>
            <div class="answer">
                <p>Hormonal contraception is very good at reducing period pain. 
                Many people find that their periods are much less painful when 
                they are using hormonal contraception. 
                </p>
            </div>
        </div>
        <div class="faq">
            <div class="question" onclick="toggleAnswer(this)">How can I have less period pain?</div>
            <div class="answer">
                <p>Hormonal contraception is very good at reducing period pain. 
                Many people find that their periods are much less painful when 
                they are using hormonal contraception. 
                </p>
            </div>
        </div>
        <div class="faq">
            <div class="question" onclick="toggleAnswer(this)">How can I have less period pain?</div>
            <div class="answer">
                <p>Hormonal contraception is very good at reducing period pain. 
                Many people find that their periods are much less painful when 
                they are using hormonal contraception. 
                </p>
            </div>
        </div>
        <div class="faq">
            <div class="question" onclick="toggleAnswer(this)">How can I have less period pain?</div>
            <div class="answer">
                <p>Hormonal contraception is very good at reducing period pain. 
                Many people find that their periods are much less painful when 
                they are using hormonal contraception. 
                </p>
            </div>
        </div>
        <div class="faq">
            <div class="question" onclick="toggleAnswer(this)">How can I have less period pain?</div>
            <div class="answer">
                <p>Hormonal contraception is very good at reducing period pain. 
                Many people find that their periods are much less painful when 
                they are using hormonal contraception. 
                </p>
            </div>
        </div>
        <div class="faq">
            <div class="question" onclick="toggleAnswer(this)">How can I have less period pain?</div>
            <div class="answer">
                <p>Hormonal contraception is very good at reducing period pain. 
                Many people find that their periods are much less painful when 
                they are using hormonal contraception. 
                </p>
            </div>
        </div>
        <div class="faq">
            <div class="question" onclick="toggleAnswer(this)">How can I have less period pain?</div>
            <div class="answer">
                <p>Hormonal contraception is very good at reducing period pain. 
                Many people find that their periods are much less painful when 
                they are using hormonal contraception. 
                </p>
            </div>
        </div>
        <div class="faq">
            <div class="question" onclick="toggleAnswer(this)">How can I have less period pain?</div>
            <div class="answer">
                <p>Hormonal contraception is very good at reducing period pain. 
                Many people find that their periods are much less painful when 
                they are using hormonal contraception. 
                </p>
            </div>
        </div>
    </div>
    
    <!-- community forum -->


    <!-- maps -->
    <div>
        <p>Address</p>
        <h4>Philippines</h4>
        <p>Bustos, Bulacan</p>

        <p>Phone Number</p>
        <h4>+63 912 345 6789</h4>   

        <p>Email</p>
        <h4>sipa@gmail.com</h4>

        <div>
            <p>We are in Social Media</p>
            <!-- icon -->
            <!-- icon -->
        </div>

        <!-- map API -->
        <div id='map'></div>
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
                        function googleTranslateElementInit() {  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');}
                    </script>
                    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            </span>
            <!-- Translation Code End here -->
            <a href="">Privacy Policy</a>
            <a href="">Terms of Use</a>
        </div>
    </footer>
</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 85a723fa38235a6f59ff026a8c9f7d1ce95f6815
