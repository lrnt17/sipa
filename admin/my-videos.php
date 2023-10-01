<?php
    require('../connect.php');
    require('../functions.php');
    require('fetch_user_and_partner_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Videos | SiPa</title>
    <style>
        body {
        font-family: "Lato", sans-serif;
        }

        /* Fixed sidenav, full height */
        .sidenav {
        height: 100%;
        width: 200px;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        padding-top: 20px;
        }

        /* Style the sidenav links and the dropdown button */
        .sidenav a, .dropdown-btn {
        padding: 6px 8px 6px 16px;
        text-decoration: none;
        font-size: 20px;
        color: #818181;
        display: block;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        outline: none;
        }

        /* On mouse-over */
        .sidenav a:hover, .dropdown-btn:hover {
        color: #f1f1f1;
        }

        /* Main content */


        /* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
        .dropdown-container {
        display: none;
        background-color: #262626;
        padding-left: 8px;
        }

        /* Optional: Style the caret down icon */
        .fa-caret-down {
        float: right;
        padding-right: 8px;
        }

        /* Some media queries for responsiveness */
        @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
        }
        td{
            font-size:14px;
        }
    </style>
</head>
<style>
    /*@keyframes appear{
        0%{
            opacity: 0;
        }
        100%{
            opacity: 1;
        }
    }*/
    
    .hide{
        display:none;
    }

    /*.btn{
        background-color: blue;
    }

    .btn_selected{
        background-color: red;
    }

    .highlight {
        background-color: yellow;
    }*/

    tr {
    border-bottom: 1px solid black !important;
    }
</style>

<style>
            .js-upload-video, .js-edit-video {
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 35px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }

            /* Modal Content */
            .upload-container, .edit-container {
                background-color: #fefefe;
                margin: auto;
                width: 70%;
                border-radius: 25px;
                box-shadow: 0 0 5px rgba(0,0,0,.3);
                padding: 3%;
                max-height: 89vh; /* Set a maximum height for the container (adjust as needed) */
                overflow-y: auto; 
            }

            /* The Close Button */
            .close-btn {
            color: black;
            float: right;
            font-size: 28px;
            font-weight: bold;
            }

            @media (max-width: 850px){
                .upload-container, .edit-container {
                width: 90% !important;
                
                }
            }

            input:focus, textarea:focus{
                outline: none;
            }
</style>
<body style="background: #F2F5FF;">

<?php include('admin-header.php') ?>

    <!-- community video content -->
    <section class="main">
            <div class="topbar">
                <div class="toggle">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
        <!-- navigation bar with logo -->
        <div class="js-personal-videos ">
            <?php //if(logged_in()):?>
                <!--<div onclick="manage_my_videos.open_upload_video()" style="cursor:pointer;">Upload Video</div>-->
            <?php //else:?>
                <!--<div onclick="manage_my_videos.login_alert()" style="cursor:pointer;">Upload Video</div>-->
            <?php //endif;?>
            
        </div>
        <br>

        <!-- List of videos -->
        <div class="container">

            <div class="row flex-nowrap" style="align-items: center; margin-top:61px;">
                <div class="col-auto">
                    <div class="vl" style="width: 10px;
                    background-color: #1F6CB5;
                    border-radius: 99px;
                    height: 60px;
                    display: -webkit-inline-box;"></div>
                </div>
                
                <div class="col-auto mt-1">
                    <div class="row">
                        <div class="col-auto">
                            <h2 style="font-weight: 400;"><b>Your</b> Videos</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-4 py-2 my-4 rounded-4 shadow-sm" onclick="manage_my_videos.open_upload_video()" style="cursor:pointer; background-color:white; width: max-content;"> <i class="fa-solid fa-video me-2"></i> Upload Video</div>
            
            <table border ="0" cellspacing="0" cellpadding="10" id="video_table">
                <thead style="text-align: center; height:40px;">
                    <tr>
                        <th><input type="checkbox" id="select-all-videos" onclick="manage_my_videos.select_all_videos(this);" /></th>
                        <th title="Videos"><i class="fa-solid fa-video"></i></th>
                        <th title="Date"><i class="fa-solid fa-calendar-days"></i></th>
                        <th title="Views"><i class="fa-solid fa-eye"></i></th>
                        <th title="Comments"><i class="fa-solid fa-comment"></i></th>
                        <th title="Likes"><i class="fa-solid fa-heart"></i></th>
                        <th title="Categories"><i class="fa-solid fa-grip"></i></th>
                        <th title="Action"><i class="fa-solid fa-pencil"></i></th>
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
            <div class="upload-container">
                <div class="close-btn" style="float:right;cursor:pointer;" onclick="manage_my_videos.open_upload_video()">&times;</div>
                <form onsubmit="manage_my_videos.upload_video(event)" method="post" enctype="multipart/form-data">
                    <div class="rounded-4 container my-4 p-4 shadow-sm" style="background: #F0F0F0;display: flex;justify-content: center; flex-wrap: wrap;">
                        <div class="row">
                            <div class="col-12">
                                <center><i class="fa-brands fa-dropbox mt-4 mb-2" style="font-size: 2.3rem;"></i></center>
                                <center><div id="drop_zone">Drop & drop video to upload</div></center>
                            </div>
                            <div class="col">
                                <input type="file" name="video_to_upload" id="video_to_upload" class="hide" onchange="manage_my_videos.display_video_to_upload(event)" required>
                                <center><label for="video_to_upload" class="px-3 py-2 mb-4 mt-2 rounded-pill shadow-sm" style="cursor:pointer; background-color:#5887DE; color:white;">Select File</label></center>
                            </div>
                        </div>
                        <div class="row">
                            <video class="js-display-video hide" width="200" controls></video>
                        </div>
                        <div class="row mt-4">
                            <span id="file-name"></span>
                        </div>
                    </div>
                    <div class="">
                        <input type="text" placeholder="Title" name="video_title" id="video_title" class="js-video-title-input fs-5 m-2" style="border: none; border-bottom: 1px solid gray;width: 98%;" maxlength="100" required>
                    </div>
                    <div class="">
                        <textarea placeholder="Description" name="post" class="js-video-desc-input mx-2" rows="4" style="border: none; border-bottom: 1px solid gray;resize: none; width: 98%;" maxlength="500" required></textarea>
                    </div>
                    <div class="ms-2 mt-3">
                        <div class="row">
                            <div class="col-auto">
                                <p style="font-size: 16px;color: #1F6CB5;">Select a Contraceptive Category: </p>
                            </div>
                            <div class="col">
                                <select class="js-select-contraceptive" required>
                                    <!-- The options will be dynamically populated with JavaScript -->
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    
                    <!--<div>
                        <label for="anonymous">Upload anonymously:</label>
                        <input type="checkbox" id="anonymous" name="anonymous" class="js-anonymous-video">
                    </div>-->
                    <div class="class_45 d-flex flex-row-reverse">
                        <button class="btn"><b>Post</b></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Editing admin modal -->
        <div class="js-edit-video hide">
            <div class="edit-container">
            <div class="close-btn" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="manage_my_videos.hide_edit_modal()">&times;</div>
                <div class="row flex-nowrap mt-4" style="align-items: center;">
                    <div class="col-auto">
                        <div class="vl" style="width: 10px;
                        background-color: #1F6CB5;
                        border-radius: 99px;
                        height: 60px;
                        display: -webkit-inline-box;"></div>
                    </div>
                
                    <div class="col-auto mt-1">
                        <div class="row">
                            <div class="col-auto">
                                <h2 style="font-weight: 400;">Edit Title & Description</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <form onsubmit="manage_my_videos.save_edited_details(event)" method="post" class="px-5 mt-4">
                    <div class="form">
                        <label for="edit_video_title" style="font-size: 17px;color: #1F6CB5;">Video Title</label></br>
                        <input type="text" name="edit_video_title" class="js-edit-title edit-video fs-5" style="border: none; border-bottom: 1px solid gray;width: 98%;" maxlength="100" required>
                    </div>
                    <div class="form mt-4">
                        <label for="edit_video_desc" style="font-size: 17px;color: #1F6CB5;">Video Description</label><br>
                        <!--<input type="text" name="edit_video_desc" class="js-edit-desc edit-video" required>-->
                        <textarea name="edit_video_desc" id="edit_video_desc" class="js-edit-desc edit-video" cols="30" rows="5" style="border: none; border-bottom: 1px solid gray;resize: none; width: 98%;" maxlength="500" required></textarea>
                    </div>
                    <div class="form mt-3">
                        <div class="row">
                            <div class="col-auto">
                                <label for="edit_category" style="font-size: 16px;color: #1F6CB5;">Contraceptive Category</label>
                            </div>
                            <div class="col">
                                <select name="edit_category" id="edit_category" class="js-edit-category edit-video" required>
                                    <!-- The options will be dynamically populated with JavaScript -->
                                </select>
                            </div>
                        </div>
                            
                    </div>

                    <div class="class_45 d-flex flex-row-reverse" >
                        <button class="btn px-5 mt-3 me-3" style="background-color: #F2C1A7; color:#ffff;">
                            Save
                        </button>
                    </div>
                </form>
            </div>
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
            <td style="width: 40%;">
            <div class="row" style="align-items: center;">
                <div class="col-auto" style="width:120px;">
                    <div class="rounded-3" style="cursor: pointer; position: relative; height:3.5rem; overflow: hidden; border: 4px solid #D2E0F8; padding: 0;">
                        <video src="" class="js-video-display" style="width: 100%;  object-fit: cover;"></video>
                    </div>
                </div>
                <div class="col">
                    <h6 class="js-video-title pt-2">Video Title</h6>
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
            </div>

            </td>
            <td class="js-video-date" style="text-align: center; width: 10%;"></td>
            <td class="js-video-views" style="text-align: center; width: 10%;"></td>
            <td class="js-video-comments" style="text-align: center; width: 10%;"></td>
            <td class="js-video-likes" style="text-align: center; width: 10%;"></td>
            <td class="js-video-category" style="text-align: center; width: 10%;"></td>
            <td style="text-align: center;">
                <div class="js-video-edit-btn" style="cursor:pointer;color:blue; width: 10%; padding: 20px;">Edit</div>
            </td>
        </tr>
    </template>
    
</body>
<script>
    let partner_facility_id = '<?=$partner_facility_id?>';
</script>
<script src="my-videos.js?v7"></script>
</html>

<script>
    let toggle = document.querySelector(".toggle");
    let navigation = document.querySelector(".navigation");
    let main = document.querySelector(".main");

    toggle.onclick = function () {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
    };
</script>