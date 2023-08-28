<?php 
    require("connect.php");
    require('functions.php');
    
    //echo $_SESSION['USER']['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
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
        } // !!!!
    </script>
    <style>
        body {
            margin: 0;
            top:0!important;
        }

        #map {
            min-height: 306px;
            min-width: 330px;
            width:580px;
            object-fit: cover;
        }
        
        .skiptranslate iframe  {
        visibility: hidden !important;
        }
        
        /* Style for women container */
        #women-container {
            display: flex;
            flex-direction: row;
        }

        /* Style for pregnant and non-pregnant women containers */
        #pregnant-women-container,
        #non-pregnant-women-container {
            display: flex;
            flex-direction: row;
        }

        /* Style for images */
        #pregnant-women-container img,
        #non-pregnant-women-container img {
            width: 50px;
            height: 50px;
        }

        .faq-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px; /* Adjust the gap as needed */
            margin: 2rem auto; 
        }

        @keyframes slideDownFadeIn {
            from {
                max-height: 0;
                opacity: 0;
            }
            to {
                max-height: 500px;
                opacity: 1;
            }
        }

        @keyframes slideUpFadeOut {
            from {
                max-height: 500px;
                opacity: 1;
            }
            to {
                max-height: 0;
                opacity: 0;
            }
        }

        .faq-item.slide-up .item-answer {
            animation: slideUpFadeOut 1s ease; 
        }

      .faq-item {
            width: 40vw;
            min-width: 400px;
            height: auto; /* Set a fixed height for the FAQ item */
            max-height: 500px;
            margin-top: 1rem;
            background-color: white;
            border-radius: 10px; 
            overflow: hidden; 
            transition: height 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease,height 0.3s ease;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
            animation: fadeIn 2s ease;
        }
        .item-question {
            background: #fff;
            font-size: 1rem;
            padding: 1.2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .question-text {
            display: inline-block;
        }
        .arrows-container {
            margin: 0.4rem;
            cursor: pointer;
        }

        .item-answer {
            display: none;
            color: whitesmoke;
            padding: 2rem;
            max-height: 0; 
            overflow: hidden; 
            transition: max-height 0.3s ease, background-color 0.3s ease; 
            border-top: 1px solid #AC471A;
        }

        .close {
            display: none;
        }

        .show-answer .item-answer {
            display: block;
            background: #fff;
            color: black;
            cursor:pointer;
            max-height: 500px; 
            padding: 2rem;
            box-shadow: none;
            background-color: #F2C1A7; 
            border-top: 1px solid #AC471A;
            animation: slideDownFadeIn 2s ease;
        }
        .show-answer .item-question {
            background-color: #F2C1A7; 
        }

        .show-answer .close {
            display: inline;
        }

        .show-answer .expand {
            display: none;
        }
        .question-text, .answer-text{
            font-weight:normal;
        }
    </style>
  
    <script src="script.js" defer></script>
</head>
<body style="background: #F2F5FF;">

    <!-- navigation bar with logo -->
    <?php include('header.php') ?>
<div class="container">
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
    <div class="col-auto">
                <a href="faqs.php" style="text-decoration: none; color: black;"><h3>Frequently<br>asked questions</h3></a>
          </div>

          <div class="faq-container" id="FAQs-container"></div>

          <?php // pang kuha ng question and answer sa db
        $faqData = array();
        $query = "SELECT * FROM faqs LIMIT 6"; // Limit the query to 6 rows
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $faqData[] = array(
                    'question' => $row['questions'],
                    'answer' => $row['answers']
                );
            }
        }
        
        ?>
    
    <!-- community forum -->
    <?php include('method-interactive-display.php') ?>

    <!-- maps -->
    <div class="container rounded-5 shadow-sm p-5 my-5" style="background: #B6CCF5;">
        <div class="row">
            <div class="col">
                <div class="row" style="
                display: flex;
                justify-content: space-between;">
                    <div class="col-auto">
                        <p style="color:#383838;">Address</p>
                        <h5>Philippines</h5>
                        <p>Bustos, Bulacan</p>
                    </div>
                    <div class="col-auto">
                        <p style="color:#383838;">Phone Number</p>
                        <h5>+63 912 345 6789</h5>   
                    </div>
                    <div class="col-auto">
                        <p style="color:#383838;">Email</p>
                        <h5>sipa@gmail.com</h5>
                    </div>
                </div>

                <div class="row my-3" style="justify-content: center;">
                    <div class="container px-4 py-2 rounded-pill shadow-sm" style="background:white;">
                        <div class="row">
                            <div class="col me-auto">
                                <p class="my-3 ps-2" style="color:#383838;">Social Media</p>
                            </div>
                            <div class="col-auto" style="display: flex;
                            align-items: center;">
                                <a href="#"><i class="fa-brands fa-facebook my-2" style="font-size:45px; color:#2736A5;"></i></a>
                            </div>
                            <div class="col-auto"style="display: flex;
                            align-items: center;">
                                <a href="#"><i class="fa-brands fa-instagram my-2" style="font-size:45px; color:#6626CC;"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col">
                <!-- map API -->
                <div style="display: flex;
                justify-content: center;">
                    <div id='map' class="rounded-5 shadow-sm"></div>
                </div>
            </div>
            
        </div>
            
            
    </div>

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
</body>
<script>
    // Assuming you have multiple <a> tags with the class "clearSessionStorage"
    let clearSessionStorageLinks = document.querySelectorAll('.js-link');

        // Loop through each <a> tag and attach the event listener
        clearSessionStorageLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            //event.preventDefault(); // Prevent the default hyperlink behavior
            sessionStorage.clear(); // Clear the entire sessionStorage
            // Or you can use sessionStorage.removeItem(key) to remove specific items
            
            // Additional actions or code after clearing sessionStorage, if needed
        });
    });


    //pang lagay ng data sa FAQs-container from faqData(na finetch from db)
    const faqData = <?php echo json_encode($faqData); ?>;
    const faqsContainer = document.getElementById('FAQs-container');
    let lastExpandedItem = null; // Keep track of the last expanded item

            faqData.slice(0, 6).forEach((item) => {
                let faqItem = document.createElement('article');
                faqItem.classList.add('faq-item');

                let markup = `
                    <div class="item-question"> 
                        <span class="question-text">${item.question}</span>
                        <span class="arrows-container">
                            <span class="expand">⮟</span>
                            <span class="close">⮝</span>
                        </span>
                    </div>
                    <div class="item-answer">
                        <span class="answer-text">${item.answer}</span>
                    </div>
                `;

                faqItem.innerHTML = markup;
                faqsContainer.append(faqItem);

                // Add a setTimeout to trigger the fade-in animation
                setTimeout(() => {
                    faqItem.style.display = 'block';
                }, 100); // You can adjust the delay as needed
        });


    // Add ng function para sa arrow pag niclick yun, lalabas ang kasagutan sa katanungan *elyen*
    const toggleButtons = document.querySelectorAll('.arrows-container');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const faqItem = e.currentTarget.parentElement.parentElement;
            const itemAnswer = faqItem.querySelector('.item-answer');
            const allFaqItems = document.querySelectorAll('.faq-item');

                allFaqItems.forEach(item => {
                    if (item !== faqItem) {
                        // Collapse other FAQ items and set their height to the default value
                        item.classList.remove('show-answer');
                        item.style.height = '100px';
                        item.querySelector('.item-answer').style.animation = 'slideUpFadeOut 1s ease';
                    }
                });

                if (faqItem.classList.contains('show-answer')) {
                    // If showing answer, toggle the show-answer class and set slideUpFadeOut animation
                    faqItem.classList.remove('show-answer');
                    faqItem.classList.add('slide-up'); // Add the slide-up class
                    itemAnswer.style.animation = 'slideUpFadeOut 1s ease'; // Adjust the duration as needed
                } else {
                    // If hiding answer, toggle the show-answer class and remove slide-up class
                    faqItem.classList.add('show-answer');
                    faqItem.classList.remove('slide-up'); // Remove the slide-up class
                    itemAnswer.style.animation = 'slideDownFadeIn 1s ease'; // Adjust the duration to match CSS

                    // Expand the height of the clicked FAQ item
                    faqItem.style.height = 'auto';
                }
        });
    });


</script>
</html>
