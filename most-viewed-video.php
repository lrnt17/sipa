<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<div class="row">
            <div class="d-flex justify-content-start mt-5 mb-3">
                <div style="width: 15%;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 6px;"></div>
            </div>
        </div>
        <div class="row" class="my-1 custom-width-hidden" style="width:300px;">
            <h2 style="color:#383838;">Videos</h2>
        </div>

<section class="my-3">
    <div class="row" style="justify-content: space-evenly;" id="videoContainer">
        
    </div>

    <div class="row">
        <div class="col mt-3 d-flex justify-content-center">
            <a class="js-link" href="community-videos.php" style=" text-decoration: none; color:black;">
                <button class="btn my-3 px-4 py-2 rounded-3 shadow-sm rounded" style="background: #ffff;">View all videos</button>
            </a>
        </div>
    </div>

</section>

<template id="videoCardTemplate" class="js-video-template">
    <div class="col-lg-3 js-video-card m-3 rounded-4 shadow-sm" style="animation: appear 3s ease; background-color:white; width:320px; padding: 0;">
            
            <div class="container js-video-link shadow-sm rounded-4" style="cursor: pointer; position: relative; height:10.5rem; overflow: hidden; border: 8px solid #D2E0F8; padding: 0;">
                <!--<video src="uploads/<?//=$video['video_url']?>" controls></video>-->
                <video src=""class="js-video-display"style="width: 100%;  object-fit: cover;"></video>
            </div>

        <div class="js-video-link" style="pointer-events: none;">
            
            <div>
                <div class="row py-3 px-2">
                    <div class="col-auto">
                        <div class="rounded-circle" style="background: white; width: 3rem; height: 3rem; border: 2px solid #F2F5FF; max-height: auto; position: relative; overflow: hidden; padding: 0;">
                            <img src="assets/images/user.jpg" class="js-image" style="width: 100%; height: auto; object-fit: cover;">
                        </div>
                    </div>
                    <div class="col ps-1">
                        <div class="row">
                            <h5 class="js-video-title-display" style="margin: 0;">
                                Contraception
                            </h5>
                        </div>
                        <div class="row">
                            <p class="js-username" style="font-size:13px; display:inline; margin: 0;" >
                                Jane Name
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <p class="js-views-count" style="font-size:11px; display:inline; margin: 0;">
                                    567 views
                                </p>
                            </div>
                            <div class="col-auto">
                                <p class="js-date" style="font-size:11px; display:inline; margin: 0;">
                                    3rd Jan 23 14:35 pm
                                </p>
                            </div>
                            <div class="col-auto">
                                <div class="js-video-category-link" style="color:green;cursor: pointer;">
                                    <p class="js-video-category" style="font-size:11px; display:inline; margin: 0;">
                                        Mini Pill
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</template>

<script>
    var most_viewed_video = {

        load_most_viewed_video: function(e){

            let form = new FormData();

            form.append('data_type', 'load_most_viewed_video');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        //console.log(ajax.responseText);return;
                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){
                            let videoContainer = document.getElementById("videoContainer");
                            let videoCardTemplate = document.getElementById("videoCardTemplate");

                            for (var i = 0; i < obj.rows.length; i++) {
                                let videoCard = videoCardTemplate.content.cloneNode(true);

                                videoCard.querySelector(".js-video-link").setAttribute('onclick',`most_viewed_video.view_video_post(${obj.rows[i].video_id})`);
                                videoCard.querySelector(".js-image").src = obj.rows[i].user_img;
                                videoCard.querySelector(".js-username").textContent = obj.rows[i].user_fname;

                                videoCard.querySelector(".js-video-title-display").innerHTML = obj.rows[i].video_title;
                                videoCard.querySelector(".js-video-display").src = obj.rows[i].video;
                                videoCard.querySelector(".js-video-category").innerHTML = obj.rows[i].birth_control.name;

                                //counting the number of comments
                                if(obj.rows[i].view_count > 0){
                                    videoCard.querySelector(".js-views-count").innerHTML = `${obj.rows[i].view_count} view${obj.rows[i].view_count > 1 ? 's' : ''}`;
                                }else{
                                    videoCard.querySelector(".js-views-count").innerHTML = `No views`;
                                }

                                //counting the number of likes
                                /*if (obj.rows[i].getlikes['count(*)'] == 0) {
                                    videoCard.querySelector(".js-num-likes").innerHTML = "";
                                } else {
                                    videoCard.querySelector(".js-num-likes").innerHTML = `${obj.rows[i].getlikes['count(*)']} like${obj.rows[i].getlikes['count(*)'] > 1 ? 's' : ''}`;
                                }*/

                                let timestampElement = videoCard.querySelector('.js-date');
                                time.updateTimestamps(timestampElement, obj.rows[i].date);
                                
                                videoContainer.appendChild(videoCard);
                            }

                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        view_video_post: function(id){
            //sessionStorage.setItem('scrollPosition', window.pageYOffset);
            //sessionStorage.setItem('numPosts', allposts.start);
            window.location.href = "video.php?id="+id;
        },
    };

    most_viewed_video.load_most_viewed_video();

</script>