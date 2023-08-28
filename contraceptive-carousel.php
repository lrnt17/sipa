<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<section>
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
</section>

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