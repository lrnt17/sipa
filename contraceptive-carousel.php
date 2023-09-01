<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<style>
        .carousel {
            display: flex;
            overflow: hidden;
            max-width:80%;
            width: 100%; /* Adjust based on your layout */
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

    .newsCard {
        position: relative;
        max-width: 180px;
        max-height: 300px;
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
        height: 80%;
        margin:0px;
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
        text-align:left;
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
<div class="container">
<section>
    <div>
        <div class="carousel" id="carousel">
            <div class="slide" id="slide">
                <!-- Slide divs will be added here by JavaScript -->
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <div class="col justify-content-start">
                    <button class="btn" id="prevBtn" style="border:none;"><i class="fa-solid fa-angle-left" style="font-size:25px;"></i></button>
                </div>
                <div class="col justify-content-center">
                    <div class="indicators" id="indicators">
                        <!-- Indicators will be added here by JavaScript -->
                    </div>
                </div>
                <div class="col d-flex justify-content-end">
                    <button class="btn" id="nextBtn" style="border:none;"><i class="fa-solid fa-angle-right" style="font-size:25px;"></i></button>
                </div>
            </div>
        </div>

    </div>
    <br><br><br>
</section>
</div>

    <!-- contraceptive method template -->
    <template class="js-method-template">
        <div class='newsCard news-Slide-up rounded-4 m-4'>
                    <img src="assets/images/contraceptive.png" alt="sample" class="js-method-image" style="width:300px;">
                <div class='newsCaption rounded-4 shadow-sm'>
                    <div style="display: flow;">
                        <p class="js-method-name newsCaption-title pt-1 pb-2" style="text-align:center; font-size:13.5px; font-weight:600;">Pill</p>
                        <div class="js-method-desc newsCaption-content px-1" style="font-size:13px;" >
                            is simply dummy text of the printing and typesetting industry. 
                            Lorem Ipsum has been the industry's standard dummy text ever 
                            since the 1500s, when an unknown printer took a galley of 
                            type and scrambled it to make a type specimen book.
                        </div>
                        <p class="read px-2 mt-2"><a class='js-method-link' href='#' style="text-decoration: none; color: white; font-size:13px;"><i class="fa-solid fa-circle-info"> </i> READ MORE</a></p>   
                    
                    </div>
                </div>  
        </div>
    </template>

<script>
    var method_carousel = {

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
                                slideDiv.classList.add("slideDiv");

                                for (var j = 0; j < buttonsPerSlide; j++) {
                                    let buttonIndex = i * buttonsPerSlide + j;

                                    if (buttonIndex >= totalButtons) {
                                        break;
                                    }

                                    let clone_template = document.querySelector(".js-method-template").content.cloneNode(true);

                                    clone_template.querySelector(".js-method-name").innerHTML = obj.rows[buttonIndex].birth_control_name;
                                    clone_template.querySelector(".js-method-desc").innerHTML = obj.rows[buttonIndex].birth_control_desc;
                                    clone_template.querySelector(".js-method-link").href = 'about-contraceptive.php?id=' + obj.rows[buttonIndex].birth_control_id;

                                    slideDiv.appendChild(clone_template); // Append cloned template to the column

                                    
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

                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
            
        },
    };

    method_carousel.contraceptive_selections();
</script>