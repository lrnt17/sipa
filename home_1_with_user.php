<?php 
    require("connect.php");
    require('functions.php');
    
    //echo $_SESSION['USER']['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link
        href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css"
        rel="stylesheet"
    />
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet' />
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
    <link
        rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css"
        type="text/css"


    />
    <link rel="stylesheet" href="carousel.css">
    <title>SiPa | Contraceptive Decision Support System</title>
    <script>
        function toggleAnswer(element) {
        var answer = element.nextElementSibling;
        answer.style.display = answer.style.display === "none" ? "block" : "none";
        } // !!!!
    </script>
    <style>
        body {
            overflow-x: hidden;
            margin: 0;
            top:0!important;
        }

        .con-nav{
            background-color: #1F6CB5;
        }

        .con-nav.py-3 a.nav-link,
        .con-nav.py-3 .navbar-toggler-icon {
            color: white !important; 
        }

        .user-fname {
            color: white !important; 
        }

        .sign-in{
            color: white !important; 
        }

        .main {
        width: 100%;
        max-height: 300px;
        background-color: #1F6CB5;
        /*background-image: linear-gradient(to right, #1F6CB5, #70AFED);*/
        display: flex;
        justify-content: center;
        flex-direction: column;
        color: #fff;
        padding: 0 20px;
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
            width: 100%;
            min-width: 200px;
            min-height: 90px; /* Set a fixed height for the FAQ item */
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

        .doctor{
            transform: scaleX(-1);
            position: absolute;
            z-index: 1;
            right: 0;
            top: 4.6%;
        }
        
        @media (max-width: 1200px) {
            .doctor {
            top: 4.05%; 
            }
        }
        @media (max-width: 992px) {
            .doctor {
            display: none; 
            }
        }
    </style>
  
    <script src="script.js?v1" defer></script>
</head>
<body style="background: #F2F5FF;">
 
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>

    <div class="main">
        <div class="container">
            <div class="row mt-5">
                <div class="col-12 col-lg-5 me-auto">
                    <br>
                <h1 class="mt-3 mb-3"style="font-weight:500;"><span translate="no" style="font-weight:normal;">Siguradong Pagpaplano</span></h1>
                <p style="font-size:1rem; font-weight:300;">
                    Choosing the appropriate contraceptive method is essential for maintaining 
                    reproductive health and preventing unwanted pregnancy.
                </p>
                <a href="right_for_me_1.php" style="color:black;"><button class="btn rounded-pill shadow-sm mt-3 px-3 py-2" style="background-color:#ffff;">Find out more</button></a>
                </div>
                <div class="col-auto">
                    <img class="doctor" src="doctor.png" alt="" width="500px" style="">
                </div>
            </div>
        </div>
    </div>
    <svg viewBox="0 0 500 100">
        <path d="M 0 65 C 235 160 240 0 500 100 L 500 0 L 0 0" fill="#BBD3EA" opacity="0.5"></path>
        <path d="M 0 50 C 150 150 300 0 500 80 L 500 0 L 0 0" fill="#1F6CB5"></path>
    </svg>
    


<div class="container">
        <div class="d-flex justify-content-center mt-5" style="text-align: center;">  
            <p class="mt-4"style="font-size:14px; color:#5A5A5A; width: 400px;">
                There are many types of contraception available and none are perfect. The 
                Siguradong Pagpaplano website provides honest information to help weigh 
                up the pros and cons.
            </p>
        </div>

    

        <div class="row">
            <div class="d-flex justify-content-center mt-2 mb-3">
                <div style="width: 10%;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 6px;"></div>
            </div>
        </div>


        <h1 class="d-flex justify-content-center" style="color:#383838;">Other Contraceptive Methods</h1>

    </div>

    <?php include('contraceptive-carousel.php') ?>

    <div class="container">

    <!-- birth controls pagination -->
   <!-- <div class="parent">
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
    </div> -->
    
    <!-- page number -->
    <!--<form method="post">
        <?php for($b=1;$b<=$a;$b++){ ?>
            <div class="pagination">
                <input type="submit" value="<?php echo $b;?>" name="page" class="links">
            </div>
        <?php } ?>
    </form>-->
    
    <!-- frequently asked questions -->
    <div class="row">
            <div class="d-flex justify-content-start mb-3">
                <div style="width: 15%;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 6px;"></div>
            </div>
    </div>
        <div class="row my-1 mb-3 custom-width-hidden" >
            <h2 style="color:#383838;">Frequently<br>asked questions</h2>
        </div>

        <div class="faq-container row" id="FAQs-container">

                <div class="col">
                    <div class="faq-row"></div>
                </div>

                <div class="col">
                    <div class="faq-row"></div>
                </div>
        </div>

        <div class="row">
        <div class="col mt-3 d-flex justify-content-center">
            <a class="js-link" href="faqs.php" style=" text-decoration: none; color:black;">
                <button class="btn my-3 px-4 py-2 rounded-3 shadow-sm rounded" style="background: #ffff;">View all FAQs</button>
            </a>
        </div>
    </div>


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
    
    <?php include('forum-carousel.php') ?>
    <?php include('most-viewed-video.php') ?>
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
                        <h5>siguradongpagpaplano@gmail.com</h5>
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
                                <a href="https://www.facebook.com/profile.php?id=61551116383814"><i class="fa-brands fa-facebook my-2" style="font-size:45px; color:#2736A5;"></i></a>
                            </div>
                            <div class="col-auto"style="display: flex;
                            align-items: center;">
                                <a href="https://www.instagram.com/siguradongpagpaplano/"><i class="fa-brands fa-instagram my-2" style="font-size:45px; color:#6626CC;"></i></a>
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

<?php include('footer.php') ?>

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

    let currentRow = 0;
    faqData.slice(0, 6).forEach((item, index) => {
    let faqItem = document.createElement('article');
    faqItem.classList.add('faq-item');

        let markup = `
            <div class="item-question"> 
            <span class="question-text">${item.question}</span>
            <span class="arrows-container">
                <span class="expand"><i class="fa-solid fa-chevron-down" style="font-size:20px;"></i></span>
                <span class="close"><i class="fa-solid fa-xmark" style="font-size:20px;"></i></span>
            </span>
            </div>
            <div class="item-answer">
            <span class="answer-text">${item.answer}</span>
            </div>
        `;

        faqItem.innerHTML = markup;

        // Determine the FAQ row to append to (every 3 items)
        const faqRow = faqsContainer.querySelectorAll('.faq-row')[currentRow];
        faqRow.appendChild(faqItem);

        // Add a setTimeout to trigger the fade-in animation
        setTimeout(() => {
            faqItem.style.display = 'block';
        }, 100); // You can adjust the delay as needed

    // Move to the next row after every 3 items
        if ((index + 1) % 3 === 0) {
            currentRow++;
        }
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
                        item.style.height = '90px';
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
