<?php
    require("connect.php");
    require("functions.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Videos | SiPa</title>
</head>
<style>
    @keyframes appear{
        0%{
            opacity: 0;
        }
        100%{
            opacity: 1;
        }
    }
    
    .hide{
        display:none;
    }

    .btn{
        background-color: blue;
    }

    .btn_selected{
        background-color: red;
    }

    .highlight {
        background-color: yellow;
    }
</style>
<body>
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>
    <?php include('videos.php') ?>

    <!-- community video content -->
    <section>
        <div class="js-personal-videos ">
            <?php if(logged_in()):?>
                <div onclick="manage_my_videos.open_upload_video()" style="cursor:pointer;">Upload Video</div>
            <?php else:?>
                <div onclick="manage_my_videos.login_alert()" style="cursor:pointer;">Upload Video</div>
            <?php endif;?>
            
        </div>
        <br>

        <!-- List of videos -->
        <div>
            <h1>Your Videos</h1>
            <table border ="1" cellspacing="0" cellpadding="10" id="video_table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all-videos" onclick="manage_my_videos.select_all_videos(this);" /></th>
                        <th>Videos</th>
                        <th>Date</th>
                        <th>Views</th>
                        <th>Comments</th>
                        <th>Likes</th>
                        <th>Categories</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <br>
            <div onclick="manage_my_videos.delete_video()" style="cursor:pointer;color:red;" id="delete-admin">Delete</div>
        </div>
        <br><br>

        <!-- upload video modal -->
        <div class="js-upload-video hide">
            <div class="" style="float:right;cursor:pointer;" onclick="manage_my_videos.open_upload_video()">X</div>
            <form onsubmit="manage_my_videos.upload_video(event)" method="post" enctype="multipart/form-data">
                <div>
                    <div id="drop_zone">Drop & drop video to upload or</div>
                    <input type="file" name="video_to_upload" id="video_to_upload" class="hide" onchange="manage_my_videos.display_video_to_upload(event)" required>
                    <label for="video_to_upload" style="cursor:pointer;">Select File</label>
                    <br>
                    <video class="js-display-video hide" width="200" controls></video>
                    <span id="file-name"></span>
                </div>
                <div class="">
                    <input type="text" placeholder="Title" name="video_title" id="video_title" class="js-video-title" required>
                </div>
                <div class="">
                    <textarea placeholder="Description" name="post" class="js-video-desc" required></textarea>
                </div>
                <div>
                    <b>Select a Contraceptive Category: </b>
                    <select class="js-select-contraceptive" required>
                        <!-- The options will be dynamically populated with JavaScript -->
                    </select>
                </div>
                
                
                <div>
                    <label for="anonymous">Upload anonymously:</label>
                    <input type="checkbox" id="anonymous" name="anonymous" class="js-anonymous-video">
                </div>
                <div class="">
                    <button class="">Post</button>
                </div>
            </form>
        </div>

        <!-- Editing admin modal -->
        <div class="js-edit-video hide">
            <div class="" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="manage_my_videos.hide_edit_modal()">X</div>
            <h1>Edit Title & Description</h1>
            <form onsubmit="manage_my_videos.save_edited_details(event)" method="post">
                <div class="form">
                    <label for="edit_video_title">Video Title</label>
                    <input type="text" name="edit_video_title" class="js-edit-title edit-video" required>
                </div>
                <div class="form">
                    <label for="edit_video_desc">Video Description</label>
                    <!--<input type="text" name="edit_video_desc" class="js-edit-desc edit-video" required>-->
                    <textarea name="edit_video_desc" id="edit_video_desc" class="js-edit-desc edit-video" cols="30" rows="10" required></textarea>
                </div>
                <div class="form">
                    <label for="edit_category">Contraceptive Category</label>
                    <select name="edit_category" id="edit_category" class="js-edit-category edit-video" required>
                        
                    </select>
                </div>

                <div class="" >
                    <button class="">
                        Save
                    </button>
                </div>
            </form>
        </div>

    </section>

    <template id="row-template">
        <tr>
            <td align="center" id="checkbox">
                <label class="container">
                    <input type="checkbox" class="js-select-video" name="all_videos[]">
                    <span class="checkmark"></span>
                </label>
            </td>
            <td>
                <video src="" width="200" class="js-video-display"></video>
                <div>
                    <h3 class="js-video-title">Video Title</h3>
                    <p class="js-video-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                        sed do eiusmod tempor incididunt ut labore et dolore magna 
                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
                        ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                        Duis aute irure dolor in reprehenderit in voluptate velit 
                        esse cillum dolore eu fugiat nulla pariatur. Excepteur sint 
                        occaecat cupidatat non proident, sunt in culpa qui officia d
                        eserunt mollit anim id est laborum
                    </p>
                </div>
            </td>
            <td class="js-video-date"></td>
            <td class="js-video-views"></td>
            <td class="js-video-comments"></td>
            <td class="js-video-likes"></td>
            <td class="js-video-category"></td>
            <td>
                <div class="js-video-edit-btn" style="cursor:pointer;color:blue;">Edit Details</div>
            </td>
        </tr>
    </template>

</body>
<script src="my-videos.js?v3"></script>
</html>