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
        padding: 14px;
        text-decoration: none;
    }

    .arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 2em;
        color: #000;
    }

    .arrow-left {
        left: 10px;
    }

    .arrow-right {
        right: 10px;
    }

    .js-method-butttons{
        width: 500px;
    }
</style>
<body>
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>
    <?php include('videos.php') ?>

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
                <button class="arrow arrow-left" id="prevBtn"><</button>
                <div class="scrollmenu" id="scrollmenu"></div>
                <button class="arrow arrow-right" id="nextBtn">></button>
            </div>
            
            <br><br><br><br><br><br><br><br><br>
            <section class="js-videos">
                    <div style="padding:10px;text-align:center;"></div>
            </section>

            <div id="VideosSection">
                <div id="videoContainer">
                    <!-- Existing videos go here -->
                    <button id="loadMoreBtn" onclick="allvideos.loadMoreVideos()" class="js-loadmore-btn ">View More</button>
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
        </div>

    </section>

    <!-- video card template-->
    <template id="videoCardTemplate" class="js-videoCardTemplate">
        <div class="js-video-card" style="animation: appear 3s ease;">
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
    </template>
	<!--end video card template-->

</body>
<script>
	var all_videos_page = true;
    let start = 0;
    let limit = 4;
</script>
<script src="time.js?v1"></script>
<script src="community-videos.js?v11"></script>

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