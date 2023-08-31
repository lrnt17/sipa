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

<section>
    <div class="slider" id="carouselContainer">
        
    </div>

</section>

<template id="carouselCardTemplate" class="js-carousel-template">
    <div class="js-carousel-card " style="animation: appear 3s ease;">
        <div class="js-forum-link">
            <img src="assets/images/user.jpg" class="js-image" width="100">
            <div>
                <!--<a href="#" class="js-profile-link class_45" >-->
                    <h2 class="js-username " style="font-size:16px; display:inline; color: blue;" >
                        Jane Name
                    </h2>
                <!--</a>-->
            </div>
            <div class="">
                <h4 class="js-date">
                    3rd Jan 23 14:35 pm
                </h4>
                <h2 class="js-title">
                    Contraception
                </h2>
                <div class="js-post">
                    is simply dummy text of the printing and typesetting industry. 
                    Lorem Ipsum has been the industry's standard dummy text ever 
                    since the 1500s, when an unknown printer took a galley of 
                    type and scrambled it to make a type specimen book.
                </div>
                <span class="js-num-comments"></span>
                <span class="js-num-likes"></span>
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
                                forumCard.querySelector(".js-image").src = obj.rows[i].user_img;
                                forumCard.querySelector(".js-username").textContent = obj.rows[i].user_fname;

                                forumCard.querySelector(".js-title").innerHTML = obj.rows[i].forum_title;
                                forumCard.querySelector(".js-post").innerHTML = obj.rows[i].forum_desc;

                                //counting the number of comments
                                if(obj.rows[i].comment_count > 0){
                                    forumCard.querySelector(".js-num-comments").innerHTML = `${obj.rows[i].comment_count}+ Comments`;
                                }else{
                                    forumCard.querySelector(".js-num-comments").innerHTML = `0`;
                                }

                                //counting the number of likes
                                if (obj.rows[i].getlikes['count(*)'] == 0) {
                                    forumCard.querySelector(".js-num-likes").innerHTML = "";
                                } else {
                                    forumCard.querySelector(".js-num-likes").innerHTML = `${obj.rows[i].getlikes['count(*)']} like${obj.rows[i].getlikes['count(*)'] > 1 ? 's' : ''}`;
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