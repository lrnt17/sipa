<?php
    require("connect.php");
    require("functions.php");

    echo $_SESSION['USER']['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Videos | SiPa</title>
</head>
<style>
    .hide{
        display: none;
    }
</style>
<body>
    <!-- navigation bar with logo -->
    <?php //include('header.php') ?>
    <?php include('videos.php') ?>

    <!-- community video content -->
    <section>
        <div class="js-personal-videos ">
            <?php if(logged_in()):?>
                <div onclick="allvideos.open_upload_video()" style="cursor:pointer;">Upload Video</div>
            <?php else:?>
                <div onclick="allvideos.login_alert()" style="cursor:pointer;">Upload Video</div>
            <?php endif;?>
            
            <section class="js-videos">
                    <div style="padding:10px;text-align:center;"></div>
            </section>

            <div id="VideosSection">
                <div id="videoContainer">
                    <!-- Existing videos go here -->
                    <button id="loadMoreBtn" onclick="allvideos.load_more_videos()" class="js-loadmore-btn ">View More</button>
                </div>
            </div>
        </div>
        <br><br>

        <!-- upload video modal -->
        <div class="js-upload-video hide">
            <div class="" style="float:right;cursor:pointer;" onclick="allvideos.open_upload_video()">X</div>
            <form onsubmit="allvideos.upload_video(event)" method="post" enctype="multipart/form-data">
                <div>
                    <div id="drop_zone">Drop & drop video to upload or</div>
                    <input type="file" name="video_to_upload" id="video_to_upload" onchange="allvideos.display_video_to_upload(event)" required>
                    <br>
                    <video class="js-display-video hide" width="200" controls></video>
                </div>
                <div class="">
                    <input type="text" placeholder="Title" name="video_title" id="video_title" class="js-video-title" required>
                </div>
                <div class="">
                    <textarea placeholder="Description" name="post" class="js-video-desc" required></textarea>
                </div>
                <div>
                    <b>Select a Contraceptive Category: </b>
                    <select id="select_contraceptive" required>
                        <!-- The options will be dynamically populated with JavaScript -->
                    </select>
                </div>
                
                
                <div>
                    <label for="anonymous">Upload anonymously:</label>
                    <input type="checkbox" id="anonymous" name="anonymous" class="js-anonymous">
                </div>
                <div class="">
                    <button class="">Post</button>
                </div>
            </form>
        </div>
    </section>

</body>
<script src="community-videos.js?v0"></script>
</html>