<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<head>
    <!-- Add the slick-theme.css if you want default styling -->
    <link
      rel="stylesheet"
      type="text/css"
      href="http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"
    />
    <!-- Add the slick-theme.css if you want default styling -->
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"
    />
    <style>
        @import url('https://fonts.googleapis.com/css?family=Lato:400,700,900|Open+Sans:300,400|Oswald:400,700');

        /***************/

        .slick-slide {
            transform: scale(0.8);
            transition: all 0.4s ease-in-out;
            padding: 40px 0;
        }


        .slick-slide img {
            max-width: 100%;
            transition: all 0.4s ease-in-out;
        }

        .slick-center {
            transform: scale(1.1);
        }

        .js-forum-link{
            cursor: pointer;
        }
    </style>
</head>
        <div class="row mt-5">
            <div class="d-flex justify-content-center mt-5">
                <div style="width: 15%;
            background-color: #1F6CB5;
            border-radius: 99px;
            height: 6px;"></div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="d-flex justify-content-center mt-2" style="text-align: center;">
                <p tyle="color:#525252;">Share your own experiences and ask questions on</p>
            </div>
        </div>
        <div class="row">
            <h2 class="d-flex justify-content-center" style="color:#383838;">Community Forum</h2>
        </div>
        
<section>
    <div class="slider my-4 mx-4" id="carouselContainer">
        
    </div>

</section>

<template id="carouselCardTemplate" class="js-carousel-template">
    <div class="js-carousel-card " style="animation: appear 3s ease;">
        <div class="js-forum-link container p-4 rounded-4 shadow-sm hover" style="background-color:white; min-height:350px; max-width:330px;">
            <div class="con d-flex justify-content-center ">
                <div class="rounded-circle" style="background: white; width: 25%; border: 2px solid #F2F5FF; max-height: auto; position: relative; overflow: hidden; padding: 0;">
                    <img src="assets/images/user.jpg" class="js-image" style="width: 100%; height: auto; object-fit: cover;">
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                    <h4 class="js-username" style="display:inline; color:#383838;" >
                        Jane Name
                    </h4>
            </div>

            <div class="row">
                <div class="d-flex justify-content-center mt-1 mb-3">
                    <div style="width: 100%;
                    background-color: #F2C1A7;
                    border-radius: 99px;
                    height: 4px;"></div>
                </div>
            </div>
            
            <div class="container">
                    <div class="d-flex justify-content-center ">
                        <h4 class="row js-title" style="color:#383838;" >
                            Contraception
                        </h4>

                    </div>
                    
                    <div class="row js-post" style="text-align: justify; font-size:14px; color:#383838;">
                        <p>is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry's standard dummy text ever 
                        since the 1500s, when an unknown printer took a galley of 
                        type and scrambled it to make a type specimen book.</p>
                    </div>

                    <div class="row js-etc" style="position: absolute; bottom: 40px; display: flex; align-items: flex-end;">
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-1">
                                    <p class="js-num-comments" style="font-size:14px; margin-top:2.5px; color:#383838;"></p>
                                </div>
                                <div class="col-1">
                                    <i class="fa-solid fa-comment" style="font-size:12px; color: #2268e2;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto me-auto">
                            <div class="row">
                                <div class="col-1">
                                    <p class="js-num-likes" style="font-size:14px; margin-top:2.5px; color:#383838;"></p>
                                </div>
                                <div class="col-1 me-col">
                                    <i class="fa-solid fa-heart" style="font-size:12px; color: red;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <p class="js-date" style="font-size:12px; color:gray;">
                                3rd Jan 23 14:35 pm
                            </p>
                        </div>
                    </div>
            </div>
                
            </div>
        </div>
    </div>
</template>

<script src="time.js?v0"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    $(document).ready(function () {
        $(".slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            speed: 500,
            autoplaySpeed: 5000,
            infinite: true,
            autoplay: true,
            centerMode: true,
            centerPadding: "0",
            responsive: [
                {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    infinite: true,
                }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    });
</script>
<script>
    var forum_carousel = {

        load_forum_carousel: function(e){

            let form = new FormData();

            form.append('data_type', 'load_forum_carousel');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        //console.log(ajax.responseText);return;
                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){
                            let carouselContainer = document.getElementById("carouselContainer");
                            let carouselCardTemplate = document.getElementById("carouselCardTemplate");

                            for (var i = 0; i < obj.rows.length; i++) {
                                let forumCard = carouselCardTemplate.content.cloneNode(true);

                                forumCard.querySelector(".js-forum-link").setAttribute('onclick',`forum_carousel.view_forum_post(${obj.rows[i].forum_id})`);
                                //forumCard.querySelector(".js-image").src = obj.rows[i].user_img;
                                if(typeof obj.rows[i].user == 'object'){
                                    forumCard.querySelector(".js-image").src = obj.rows[i].user.image;
                                }
                                //forumCard.querySelector(".js-username").textContent = obj.rows[i].user_fname;
                                forumCard.querySelector(".js-username").textContent = (typeof obj.rows[i].user == 'object') ? obj.rows[i].user.name : 'User';
                                forumCard.querySelector(".js-title").innerHTML = obj.rows[i].forum_title;
                                //forumCard.querySelector(".js-post").innerHTML = `${obj.rows[i].forum_desc}`;
                                // Truncate the post text
                                let postText = obj.rows[i].forum_desc;
                                let maxLength = 5; // Maximum number of characters to display
                                if (postText.length > maxLength) {
                                    postText = postText.substring(0, maxLength) + '... <p>see more</p>';
                                }
                                
                                forumCard.querySelector(".js-post").innerHTML = postText;

                                //counting the number of comments
                                if(obj.rows[i].comment_count > 0){
                                    forumCard.querySelector(".js-num-comments").innerHTML = `${obj.rows[i].comment_count}`;
                                }else{
                                    forumCard.querySelector(".js-num-comments").innerHTML = `0`;
                                }

                                //counting the number of likes
                                if (obj.rows[i].getlikes['count(*)'] == 0) {
                                    forumCard.querySelector(".js-num-likes").innerHTML = "";
                                } else {
                                    forumCard.querySelector(".js-num-likes").innerHTML = `${obj.rows[i].getlikes['count(*)']} ${obj.rows[i].getlikes['count(*)'] > 1 ? '' : ''}`;
                                }

                                let timestampElement = forumCard.querySelector('.js-date');
                                time.updateTimestamps(timestampElement, obj.rows[i].date);
                                
                                carouselContainer.appendChild(forumCard);
                            }

                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        view_forum_post: function(id){
            //sessionStorage.setItem('scrollPosition', window.pageYOffset);
            //sessionStorage.setItem('numPosts', allposts.start);
            window.location.href = "post.php?id="+id;
        },
    };

    forum_carousel.load_forum_carousel();


</script>