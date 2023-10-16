<?php
    require("connect.php");
    require("functions.php");

   // echo $_SESSION['USER']['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Community Videos | SiPa</title>
</head>
<style>
    body {
            overflow-x: hidden;
            margin: 0;
            top:0!important;
        }
        
    .skiptranslate iframe  {
        visibility: hidden !important;
    }

    @keyframes appear{
        0%{
            opacity: 0;
        }
        100%{
            opacity: 1;
        }
    }

    .p{
        text-align:center;
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
        background-color: #D2E0F8;
    }

    /* scroll buttons sa may tabi ni upload video*/
    .scrollmenu {
        overflow: auto;
        white-space: nowrap;
        scrollbar-width: none; /* For Firefox */
        -ms-overflow-style: none;  /* For Internet Explorer and Edge */
    }

    .scrollmenu::-webkit-scrollbar { 
        display: none;  /* For Chrome, Safari and Opera */
    }

    .scrollmenu button {
        display: inline-block;
        text-align: center;
        text-decoration: none;
    }

    .js-method-butttons{
        width: 500px;
    }

    .arrow{
        padding: 0 !important;
    }

    @media (max-width: 992px) {
        .col-lg-10{
            margin-top:-1.5% !important;
        }
    }

</style>
<body style="background: #F2F5FF;">
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>
    <?php include('videos.php') ?>

    <div class="container">
        <div class="row px-5">

            <div class="col">
                    <!-- community video content -->
                <section>
                    <div class="js-personal-videos ">
                        <!--
                        <?php //if(logged_in()):?>
                            <div onclick="allvideos.open_upload_video()" style="cursor:pointer;">Upload Video</div>
                        <?php //else:?>
                            <div onclick="allvideos.login_alert()" style="cursor:pointer;">Upload Video</div>
                        <?php //endif;?>
                        -->
                        
                        <div class="js-method-buttons">
                            <div class="row" style="display: flex; justify-content: center;">
                                <div class="col-auto d-none d-sm-block">
                                    <button class="arrow arrow-left my-3 btn pt-2" id="prevBtn"><i class="fa-solid fa-chevron-left"></i></button>
                                </div>
                                <div class="col col-sm-10">
                                    <div class="scrollmenu my-3" id="scrollmenu">
                                        
                                    </div>
                                </div>
                                <div class="col-auto d-none d-sm-block">
                                    <button class="arrow arrow-right my-3 btn pt-2" id="nextBtn"><i class="fa-solid fa-chevron-right"></i></button>
                                </div>
                            </div>
                        </div>
                        
                        <section class="js-videos">
                                <div style="padding:10px;text-align:center;"></div>
                        </section>

                        <div id="VideosSection">
                            <div class="row" style="justify-content: space-evenly;" id="videoContainer">
                                <!-- Existing videos go here -->
                                <button id="loadMoreBtn" onclick="allvideos.loadMoreVideos()" class="js-loadmore-btn mt-3" style=" color: #424242; border: none; background: transparent; display: none;">View More</button>
                            </div>
                        </div>
                    </div>
                    <br><br>

                    <!-- upload video modal -->
                    <!--<div class="js-upload-video hide">
                        <div class="" style="float:right;cursor:pointer;" onclick="allvideos.open_upload_video()">X</div>
                        <form onsubmit="allvideos.upload_video(event)" method="post" enctype="multipart/form-data">
                            <div>
                                <div id="drop_zone">Drop & drop video to upload or</div>
                                <input type="file" name="video_to_upload" id="video_to_upload" class="hide" onchange="allvideos.display_video_to_upload(event)" required>
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
                                <select id="select_contraceptive" required>
                                    
                                </select>
                            </div>
                            
                            
                            <div>
                                <label for="anonymous">Upload anonymously:</label>
                                <input type="checkbox" id="anonymous" name="anonymous" class="js-anonymous-video">
                            </div>
                            <div class="">
                                <button class="">Post</button>
                            </div>
                        </form>-->
                    <!--</div>-->

                </section>

                <!-- video card template-->
                <template id="videoCardTemplate" class="js-videoCardTemplate">
                    <div class="js-video-card m-3 mb-5 rounded-4 shadow-sm" style="animation: appear 3s ease; background-color:white; width:290px; padding: 0;">
                    
                        <div class="container  js-video-link shadow-sm rounded-4" style="cursor: pointer; position: relative; height:10.5rem; overflow: hidden; border: 8px solid #D2E0F8; padding: 0;">
                            <!--<video src="uploads/<?//=$video['video_url']?>" controls></video>-->
                            <video src=""class="js-video-display"style="width: 100%; height: inherit; object-fit: cover;"></video>
                        </div>

                    <div class="js-video-link-body" style="cursor: pointer;">

                        <div>
                            <div class="row py-3 px-2">
                                <div class="col-auto">
                                    <div class="rounded-circle" style="background: white; width: 3rem; height: auto; border: 2px solid #F2F5FF; max-height: auto; position: relative; overflow: hidden; padding: 0;">
                                        <img src="assets/images/user.jpg" class="js-image" style="width: 100%; height: auto; object-fit: cover;">
                                    </div>
                                </div>
                                <div class="col ps-1">
                                    <div class="row">
                                        <h5 class="js-video-title-display" style="margin: 0; overflow: hidden;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;text-overflow: ellipsis;">
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
                    

                        <!--<div class="" >
                            <div class="js-modification-buttons " >
                                <div class="js-edit-button " style="color:blue;cursor: pointer;"  >
                                    Edit
                                </div>
                                <div class="js-delete-button " style="color:red;cursor: pointer;"  >
                                    Delete
                                </div>
                            </div>
                        </div>-->

                    </div>
                    </div>
                </template>
                <!--end video card template-->

            </div>
        </div>
    </div>


    <?php include('footer.php') ?>

</body>
<script>
	var all_videos_page = true;
    let start = 0;
    let limit = 6;
</script>
<script src="time.js?v1"></script>
<script src="community-videos.js?v17"></script>

<script>

//-----------------------------------------------------------------------------------------------------
    // Check if the page is being loaded as a result of a refresh
    if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
        // Clear any stored search results from sessionStorage
        sessionStorage.removeItem('searchResults');
    }

    // Get a reference to the input field
    let searchInput = document.querySelector('.js-search-videos');

    // Check if there are any stored search results in sessionStorage
    let storedSearchResults = sessionStorage.getItem('searchResults');
    console.log(storedSearchResults);
    // Add an event listener to the input field to handle user input
    searchInput.addEventListener('input', function(event) {
        // Get the user's search query
        let query = event.target.value;

        if (query !== '') {
            document.getElementById("loadMoreBtn").classList.add('hide');
            document.querySelector(".js-method-buttons").classList.add('hide');

            // Call the allvideos.search method with the user's query
            allvideos.search_videos(query);
        } else {
            // Clear any stored search results from sessionStorage
            sessionStorage.removeItem('searchResults');
            document.getElementById("loadMoreBtn").classList.remove('hide');
            document.querySelector(".js-method-buttons").classList.remove('hide');
            // Clear any existing posts and load the first 5 posts from the database
            allvideos.start = 0;
            allvideos.category_id = 0;
            allvideos.loadMoreVideos(null, true);
        }
    });

    if (storedSearchResults) {
        // Parse the stored search results and display them
        let searchResults = JSON.parse(storedSearchResults);
        allvideos.displayVideos(searchResults, true);
        document.getElementById("loadMoreBtn").classList.add('hide');
        document.querySelector(".js-method-buttons").classList.add('hide');
    }

//-----------------------------------------------------------------------------------------------------
    // Assuming you have multiple <a> tags with the class "clearSessionStorage"
    let clearSessionStorageLinks = document.querySelectorAll('.js-link');

    // Loop through each <a> tag and attach the event listener
    clearSessionStorageLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            //event.preventDefault(); // Prevent the default hyperlink behavior
            sessionStorage.clear(); // Clear the entire sessionStorage
            // Or you can use sessionStorage.removeItem(key) to remove specific items
            
            // Additional actions or code after clearing sessionStorage, if needed
        });
    });

//-----------------------------------------------------------------------------------------------------

</script>
</html>