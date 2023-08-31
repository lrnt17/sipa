<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<section>
    <div id="videoContainer">
        
    </div>

    <a class="js-link" href="community-videos.php">View all videos</a>
</section>

<template id="videoCardTemplate" class="js-video-template">
    <div class="js-video-card " style="animation: appear 3s ease;">
        <div class="js-video-link" style="cursor: pointer;">
            <div>
                <!--<video src="uploads/<?//=$video['video_url']?>" controls></video>-->
                <video src="" width="200" class="js-video-display"></video>
            </div>
            <div>
                <h2 class="js-video-title-display">
                    Contraception
                </h2>
                <span>Posted by</span> 
                <img src="assets/images/user.jpg" class="js-image" width="100">
                <!--<a href="#" class="js-profile-link" >-->
                    <h2 class="js-username" style="font-size:16px; display:inline;" >
                        Jane Name
                    </h2>
                <!--</a>-->
                <p class="js-views-count">
                    567 views
                </p>
                <h4 class="js-date">
                    3rd Jan 23 14:35 pm
                </h4>
            </div>
        </div>
        <div class="js-video-category-link" style="color:green;cursor: pointer;">
            <p class="js-video-category">
                Mini Pill
            </p>
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