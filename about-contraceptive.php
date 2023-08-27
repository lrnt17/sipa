<?php 
    require("connect.php");
    require('functions.php');

    if(!logged_in()){
		header("Location: home_1_with_user.php");
		die;
	}

    //echo $_SESSION['USER']['user_id']."<br>";

    $birth_control_id = $_GET['id'];
    
    $query = "select * from birth_controls where birth_control_id = '$birth_control_id' limit 1";
	$row = query($query);

	if($row)
	{
		$row = $row[0];
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title><?=$row['birth_control_name']?> | SiPa</title>
    <style>
        .method-pic{
            width: 100px;
            height: 100px;
        }
        /* ---------------------------------------------------------------------- sa baba neto bago*/
        .carousel {
            display: flex;
            overflow: hidden;
            width: 100%;
            max-width: 500px; /* Adjust based on your layout */
            margin: 0 auto; /* Center the carousel */
        }

        .slide {
            display: flex;
            width: 100%;
            transition: transform 0.5s ease-in-out;
        }

        .slide div {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .slide button {
            flex: 1;
            margin: 0 10px;
            width: 200px; /* Adjust based on your layout */
        }

        .indicators {
            display: flex;
            justify-content: center;
        }

        .indicator {
            height: 10px;
            width: 10px;
            background-color: #bbb;
            border-radius: 50%;
            margin: 5px;
        }

        .indicator.active {
            background-color: #717171;
        }
    </style>
</head>
<body style="background: #F2F5FF;">
    <section>
        <!-- navigation bar with logo -->
        <?php include('header.php') ?>

        <div class="container">
            <?php if(!empty($row)):?>
                <div class="container rounded-4 justify-content-center" style="text-align: center; background: white; width: 85%; max-height: 300px; position: relative; overflow: hidden; border: 10px solid #F2F5FF; z-index: 1; padding: 0;">
                    <img src="<?=get_image($row['birth_control_img'])?>" class="method-pic " style="width: 100%; height: auto; object-fit: cover;">
                    <!--<h1 style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size:3.5rem; padding: 10px; text-shadow: -1px -1px 0 #ffff, 1px -1px 0 #ffff, -1px 1px 0 #ffff, 1px 1px 0 #ffff;"><?=$row['birth_control_name']?></h1>-->
                </div>


                <div class="container rounded-4 p-5 shadow-sm" style="background: #D2E0F8;position: relative;top: -104px;">
                    <div class="row mx-3 mt-5">
                        <div class="row mt-5 flex-nowrap" style="align-items: center;">
                                    <div class="col-auto">
                                        <div class="vl" style="width: 10px;
                                        background-color: #1F6CB5;
                                        border-radius: 99px;
                                        height: 75px;
                                        display: -webkit-inline-box;
                                        white-space: nowrap;"></div>
                                    </div>
                                
                                    <div class="col">
                                        <h3>About</h3>
                                    </div>
                        </div>
                    <div>

                    <div class="row mx-3 mt-5 mb-4">
                        <div class="container rounded-4 shadow-sm p-4" style="background:#ffff;">
                            <h4>What is <span><?=$row['birth_control_name']?></span>?</h4>
                            <p class="mt-3" style="color:#383838;"><?=$row['birth_control_desc']?></p>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row mx-3">
                            <div class="col-md-6 mt-4">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="fa-regular fa-circle-check" style="font-size: 24px; color: #618858;"></i>
                                    </div>
                                    <div class="col">
                                        <h5 style="font-weight: bold;">Positive</h5>
                                        <section class="js-contraceptive-positive-info">
                                            <div style="padding: 10px; text-align: center;">Loading Positive info....</div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="fa-regular fa-circle-xmark" style="font-size: 24px; color: #9D3737;"></i>
                                    </div>
                                    <div class="col">
                                        <h5 style="font-weight: bold;">Negative</h5>
                                        <section class="js-contraceptive-negative-info">
                                            <div style="padding: 10px; text-align: center;">Loading Negative info....</div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row py-5">
                        <div class="d-flex justify-content-center">
                            <div style="width: 100%;
                            background-color: #1F6CB5;
                            border-radius: 99px;
                            height: 5px;"></div>
                        </div>
                    </div>
                    
                    <div class="row mx-3">
                        <div class="col-auto">
                            <i class="fa-regular fa-lightbulb" style="font-size:24px; color:#AFA966;"></i>
                        </div>
                        <div class="col">
                            <h5 style="font-weight:bold;">Did you know?</h5>
                            <section class="js-contraceptive-fyi-info">
                                <div style="padding:10px;text-align:center;">Loading Did you know info....</div>
                            </section>
                        </div>
                    </div>

                    <div class="row" >
                        <div class="col d-flex justify-content-center align-items-center">
                            <div class="mt-5">
                                <a href="comparison-chart.php" class="btn my-3 px-5 py-3 rounded-4 shadow-sm rounded" style="background: #ffff;">Compare contraceptive methods</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else:?>
                <div>
                    <div>
                        Contraceptive method details not found!
                    </div>
                </div>
            <?php endif;?>
        </div>
        
    </section>
    
    <div>
        <div class="carousel" id="carousel">
            <div class="slide" id="slide">
                <!-- Slide divs will be added here by JavaScript -->
            </div>
        </div>

        <button id="prevBtn">Prev</button>
        <button id="nextBtn">Next</button>

        <div class="indicators" id="indicators">
            <!-- Indicators will be added here by JavaScript -->
        </div>
    </div>
    <br><br><br>
    <!-- template for contraceptive positive effects -->
    <template id="positive-info-template">
        <div class="js-positive-info-list py-2" style="color:#383838;">
            is simply dummy text of the printing and typesetting industry.
        </div>
    </template>

    <!-- template for contraceptive negative effects -->
    <template id="negative-info-template">
        <div class="js-negative-info-list py-2" style="color:#383838;">
            is simply dummy text of the printing and typesetting industry.
        </div>
    </template>

    <!-- template for contraceptive did you know info -->
    <template id="fyi-info-template">
        <div class="js-fyi-info-list py-2" style="color:#383838;">
            is simply dummy text of the printing and typesetting industry.
        </div>
    </template>
</body>
<script>

    var birth_control_id = <?php echo json_encode($birth_control_id); ?>;
    
    var load_method_info = {

        loadData: function(id){
            console.log(id);

            let form = new FormData();
            form.append('birth_control_id', id);
            form.append('data_type', 'load_method_info');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let data = JSON.parse(ajax.responseText);
                        //console.log(ajax.responseText);
                        let positive_table_list = document.querySelector(".js-contraceptive-positive-info");
                        positive_table_list.innerHTML = "";

                        let negative_table_list = document.querySelector(".js-contraceptive-negative-info");
                        negative_table_list.innerHTML = "";

                        let fyi_table_list = document.querySelector(".js-contraceptive-fyi-info");
                        fyi_table_list.innerHTML = "";

                        if(data.positive_rows_success){
                            
                            let template = document.querySelector("#positive-info-template");

                            for (let i = 0; i < data.positive_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-positive-info-list").textContent = data.positive_rows[i].positive_effect_desc;
                                
                                positive_table_list.appendChild(row);
                            }
                        } else {
                            positive_table_list.innerHTML = "No data found";
                        }
                        //--------------------------------------------------------------------------
                        if(data.negative_rows_success){
                            
                            let template = document.querySelector("#negative-info-template");

                            for (let i = 0; i < data.negative_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-negative-info-list").textContent = data.negative_rows[i].negative_effect_desc;

                                negative_table_list.appendChild(row);
                            }
                        } else {
                            negative_table_list.innerHTML = "No data found";
                        }
                        //--------------------------------------------------------------------------
                        if(data.fyi_rows_success){
                            
                            let template = document.querySelector("#fyi-info-template");

                            for (let i = 0; i < data.fyi_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-fyi-info-list").textContent = data.fyi_rows[i].fyi_desc;

                                fyi_table_list.appendChild(row);
                            }
                        } else {
                            fyi_table_list.innerHTML = "No data found";
                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        contraceptive_selections: function(){
        
            let carousel = document.getElementById('carousel');
            let slide = document.getElementById('slide');
            let prevBtn = document.getElementById('prevBtn');
            let nextBtn = document.getElementById('nextBtn');
            let indicators = document.getElementById('indicators');
            
            let form = new FormData();

            form.append('data_type', 'load_all_methods');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){
                            
                            let totalButtons = obj.rows.length; // Total number of buttons
                            let buttonsPerSlide = 4; // Number of buttons per slide
                            let totalSlides = Math.ceil(totalButtons / buttonsPerSlide);
                            let currentSlide = 0;

                            // Create buttons
                            for (var i = 0; i < totalSlides; i++) {
                                let slideDiv = document.createElement('div');

                                for (var j = 0; j < buttonsPerSlide; j++) {
                                    let buttonIndex = i * buttonsPerSlide + j;

                                    if (buttonIndex >= totalButtons) {
                                        break;
                                    }

                                    let button = document.createElement('button');
                                    button.textContent = obj.rows[buttonIndex].birth_control_name;
                                    button.onclick = function() {
                                        window.location.href = 'about-contraceptive.php?id=' + obj.rows[buttonIndex].birth_control_id;
                                    };
                                    slideDiv.appendChild(button);
                                }

                                slide.appendChild(slideDiv);
                            }

                            // Create indicators
                            for (var i = 0; i < totalSlides; i++) {
                                let indicator = document.createElement('div');
                                indicator.classList.add('indicator');
                                if (i === currentSlide) {
                                    indicator.classList.add('active');
                                }
                                indicators.appendChild(indicator);
                            }

                            function updateCarousel() {
                                slide.style.transform = 'translateX(-' + (currentSlide * carousel.offsetWidth) + 'px)';
                                
                                let indicatorElements = indicators.getElementsByClassName('indicator');
                                for (var i = 0; i < indicatorElements.length; i++) {
                                    indicatorElements[i].classList.remove('active');
                                }
                                indicatorElements[currentSlide].classList.add('active');
                                
                                prevBtn.disabled = currentSlide === 0;
                                nextBtn.disabled = currentSlide === totalSlides - 1;
                            }

                            prevBtn.addEventListener('click', function() {
                                currentSlide--;
                                updateCarousel();
                            });

                            nextBtn.addEventListener('click', function() {
                                currentSlide++;
                                updateCarousel();
                            });

                            window.addEventListener('resize', updateCarousel);

                            updateCarousel();
                            //console.log(obj.rows.length);

                            /*let all_button = document.createElement('button');
                            all_button.textContent = 'All';
                            all_button.setAttribute('onclick',`allvideos.sort_birth_control_id(0)`);
                            scrollMenu.appendChild(all_button);

                            obj.rows.forEach(function(contraceptive) {
                                let button = document.createElement('button');
                                button.textContent = contraceptive.birth_control_name;
                                button.setAttribute('onclick',`allvideos.sort_birth_control_id('${contraceptive.birth_control_id}')`);
                                scrollMenu.appendChild(button);
                            });*/

                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
            
        },
    };

    load_method_info.contraceptive_selections();
    load_method_info.loadData(birth_control_id);
</script>
</html>