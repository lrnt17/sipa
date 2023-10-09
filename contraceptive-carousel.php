<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<head>
    <style>

        .newsCard {
            position: relative;
            max-width: 300px;
            max-height: 340px;
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
    <!-- Add the slick-theme.css if you want default styling -->
    <link
      rel="stylesheet"
      type="text/css"
      href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"
    />
    <!-- Add the slick-theme.css if you want default styling -->
    <link
      rel="stylesheet"
      type="text/css"
      href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"
    />
    <style>
        @import url('https://fonts.googleapis.com/css?family=Lato:400,700,900|Open+Sans:300,400|Oswald:400,700');

        /***************/

        .slick-slide {
            transform: scale(0.8);
            transition: all 0.4s ease-in-out;
            padding: 40px 0;
        }

        .slick-center {
            transform: scale(1.1);
        }

        .js-forum-link{
            cursor: pointer;
        }

    </style>   
</head>

<div class="container">
    <section>
        <div>
            <!--<div class="carousel" id="carousel">
                <div class="slide" id="slide">
                    Slide divs will be added here by JavaScript 
                </div>
            </div>-->

            <!--<div class="container mt-5">
                <div class="row">
                    <div class="col justify-content-start">
                        <button class="btn" id="prevBtn" style="border:none;"><i class="fa-solid fa-angle-left" style="font-size:25px;"></i></button>
                    </div>
                    <div class="col justify-content-center">
                        <div class="indicators" id="indicators">
                            Indicators will be added here by JavaScript
                        </div>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <button class="btn" id="nextBtn" style="border:none;"><i class="fa-solid fa-angle-right" style="font-size:25px;"></i></button>
                    </div>
                </div>
            </div>-->

        </div>
        <div class="slider-method-1" id="methodCarouselContainer">
            
        </div>
        <br><br><br>
    </section>
</div>

    <!-- contraceptive method template -->
    <template class="js-method-template" id="methodCarouselTemplate">
        <div class='newsCard news-Slide-up rounded-4 m-4' style="width: 232px;height: 300px;padding: 0px;">
                <div class="img-container" style="width:auto; height:100%;">
                    <img src="assets/images/contraceptive.png" alt="sample" class="js-method-image" style="width:100%; height:100%; width:100%;height:100%;object-fit: cover;">
                </div>
                <div class='newsCaption rounded-4 shadow-sm'>
                    <div style="display: flow;">
                        <span translate="no"><p class="js-method-name newsCaption-title pt-1 pb-2" style="text-align:center; font-size: 1rem; font-weight:600;">Pill</p></span>
                        <div class="js-method-desc newsCaption-content px-1" style="font-size:1rem; overflow: hidden;margin-top: -3%;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 4;text-overflow: ellipsis;" >
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    $(document).ready(function () {
        setTimeout(function() {
            $(".slider-method-1").slick({
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [
                    {
                    breakpoint: 1330,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        infinite: true,
                        dots: true
                    }
                    },
                    {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                    },
                    {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: true
                    }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });
        }, 1000);
    });
</script>
<script>
    var method_carousel = {

        /*contraceptive_selections: function(){
        
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
            
        },*/

        load_contraceptive_selections: function(e){

            let form = new FormData();

            form.append('data_type', 'load_all_methods');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        //console.log(ajax.responseText);return;
                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){
                            let carouselContainer = document.getElementById("methodCarouselContainer");
                            let carouselCardTemplate = document.getElementById("methodCarouselTemplate");

                            for (var i = 0; i < obj.rows.length; i++) {
                                let forumCard = carouselCardTemplate.content.cloneNode(true);
                                forumCard.querySelector(".js-method-image").src = obj.rows[i].birth_control_img;
                                forumCard.querySelector(".js-method-name").innerHTML = obj.rows[i].birth_control_name;
                                forumCard.querySelector(".js-method-desc").innerHTML = `${obj.rows[i].birth_control_short_desc}`;
                                forumCard.querySelector(".js-method-link").href = 'about-contraceptive.php?id=' + obj.rows[i].birth_control_id;
                                
                                carouselContainer.appendChild(forumCard);
                            }

                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },
    };

    //method_carousel.contraceptive_selections();
    method_carousel.load_contraceptive_selections();
</script>
