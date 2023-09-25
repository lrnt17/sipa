<?php
    require("connect.php");
    require("functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Community Forum | SiPa</title>
</head>
<body style="background: #F2F5FF;">
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
        
		/* tinatago si sign up, naka hide sya */
		.hide{
			display:none;
		}


        .btn_selected{
            background: transparent;
            border: none;
            outline: none;
            color: red;
        }

        .highlight {
            background-color: #D2E0F8;
        }

        input:focus, textarea:focus{
            outline: none;
        }

        input[type=checkbox]{
            height: 0;
            width: 0;
            visibility: hidden;
        }

        label {
            cursor: pointer;
            text-indent: -9999px;
            width: 34px;
            height: 20px;
            top: 3px;
            left: 2px;
            background: grey;
            display: block;
            border-radius: 100px;
            position: relative;
        }

        label:after {
            content: '';
            position: absolute;
            top: 2.5px;
            left: 2.5px;
            width: 15px;
            height: 15px;
            background: #fff;
            border-radius: 90px;
            transition: 0.3s;
        }

        input:checked + label {
            background: #5582da;
        }

        input:checked + label:after {
            left: calc(50% - 1px);
            transform: translateX(- 80%);
        }

        label:active:after {
            width: 20px;
        }

        .js-like-button{
            cursor: pointer; 
            padding: 0px; 
            outline: none; 
            border: none; 
            margin-right: 4px; 
            font-size: 14px;
            background-color: transparent;
        }

	</style>

    <!-- navigation bar with logo -->
    <?php include('header.php') ?>
    <?php include('community-forum.php') ?>

    <div class="container">
        <div class="row px-5">
            <div class="col-2 d-none d-lg-block">
                <!-- sa column 'tong div --> 
            </div>

            <div class="col">
                <!-- community forum content -->
                <section>
                    <div class="js-personal-post ">
                        <?php if(logged_in()):?>
                            <div class="d-grid">
                                <button onclick="allposts.new_topic()" class="btn text-start p-3 rounded-4" style="background: #F2C1A7;" id="btn"> <i class="fa-solid fa-plus js-toggle-icon"></i> &nbsp; Start New Topic</button>
                            </div>

                            <form onsubmit="allposts.submit(event)" method="post" class="js-start-topic class_42 hide p-4 rounded-5 shadow-sm" style="background: #fff;" >
                                <div class="d-grid">
                                    <input type="text" placeholder="Title" name="post_title" id="post_title" class="js-post-title fs-5 m-2" style="border: none; border-bottom: 1px solid gray;" maxlength="30">
                                </div>
                                <div class="class_43 d-grid" >
                                    <textarea placeholder="Whats on your mind?" rows="5" name="post" class="js-post-input class_44 mx-2" style="border: none; border-bottom: 1px solid gray;resize: none;" maxlength="500"></textarea>
                                </div>
                            
                            <div class="row mx-1 my-2">
                                <div class="col-auto me-auto">
                                    <p for="anonymous" class="" style="display:inline; color:#5582da;">Post anonymously:</p>
                                    <input type="checkbox" id="anonymous" name="anonymous" class="js-anonymous"><label for="anonymous">anonymous</label>
                                </div>
                                <div class="class_45 col-auto" >
                                    <button class="class_46 btn fs-5" style="font-weight:600;">
                                        Post
                                    </button>
                                </div>
                            </div>
                            </form>

                        <?php else:?>
                            <div class="d-grid" >
                                <p class="text-start p-3 rounded-4" style="background: #F2C1A7;" > <i class="fa-solid fa-circle-exclamation"> </i> You're not signed in. 
                                <a href="login_1.php" class="js-link" style="text-decoration:none;">Click here to sign in and post</a></p>
                            </div>
                        <?php endif;?>

                        <section class="js-posts">
                                <div style="padding:10px;text-align:center;"></div>
                        </section>

                        <div id="postsSection">
                            <div id="postContainer">
                                <!-- Existing posts go here -->
                                <button id="loadMoreBtn" onclick="allposts.loadMorePosts()" class="js-loadmore-btn mb-3" style="position: absolute;
                                left: 50%; transform: translateX(-50%); color: #424242; border: none; background: transparent">View More</button>
                            </div>
                        </div>

                        <div class="class_37" style="display: flex;justify-content: space-between;" >
                        </div>
                    </div>

                    <!-- modal ito na mag-aappear pag pinindot ni user yung edit button -->
                    <?php include'community_forum_3_edit_my_post.php'?> 
                </section>
                <!-- end community forum content -->

                <!-- post card template-->
                <template id="postCardTemplate" class="js-postCardTemplate">
                    <div class="js-post-card class_42 ps-5 pe-5 pt-5 pb-4 mb-5 mt-3 rounded-5 shadow-sm" style="animation: appear 3s ease; background-color:white;">
                        
                        <div class="class_49" >
                            <div class="row mb-2">
                                <div class="col">
                                    <h2 class="js-title">
                                        Contraception
                                    </h2>
                                </div>
                                <div class="col-1">
                                    <!--edit, delete btn-->
                                    <div class="js-modification-buttons class_51" >
                                    <a data-toggle="dropdown" class="btn"><i class="fa-solid fa-ellipsis fs-4"></i></a>
                                        <div class="container">
                                            <ul class="dropdown-menu">
                                                <div class="js-edit-button class_53 dropdown-item" style="color:blue;cursor: pointer;"  >
                                                    Edit
                                                </div>
                                                <div class="js-delete-button class_53 dropdown-item" style="color:red;cursor: pointer;"  >
                                                    Delete
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--end edit, delete btn-->
                                </div>

                            </div>
                            <!-- post -->
                            <div class="js-post class_15"  >
                                is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets c
                            </div>

                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-auto" style="padding-right:0px; display: flex; align-items: center;">
                                        <div class="img-con" style="width:40px; height:40px; border-radius:50%; border-style: solid; position: relative; overflow: hidden; padding: 0;"> 
                                            <img src="assets/images/user.jpg" class="js-image class_47" style=" width: 100%; height: 100%; object-fit: cover;" >
                                        </div>
                                    </div>
                                    <div class="col py-2">
                                        <span style="font-size:14px; color:gray;"> Posted by </span> 
                                        <!--<a href="#" class="js-profile-link class_45 py-2" style="text-decoration:none;">-->
                                            <h2 class="js-username class_48" style="font-size:14px; display:inline;" >
                                                Jane Name
                                            </h2>
                                        <!--</a>-->
                                    </div>
                                </div>
                            </div>

                            <div class="col-3 py-2">
                                <p class="js-date class_41" style="font-size:14px; color: gray;">
                                    3rd Jan 23 14:35 pm
                                </p>
                            </div>

                            <div class="class_51 js-comment-link-count col-3 py-2" >
                                <div class="js-comment-link class_53" style="color:#2268e2; cursor: pointer;">
                                    Comment 
                                </div>
                            </div>

                            <div class="col-2 py-2">
                                <button class="js-like-button class_53 " style="cursor: pointer; padding:0px; margin-right:2px;outline:none; border: none;"  >
                                <i class="fa-solid fa-heart" style="pointer-events: none;"></i>
                                </button>
                                
                                <span class="js-num-likes"></span>
                            </div>
                        </div>

                        </div>
                    </div>
                </template>
                <!--end post card template-->
        
            </div>
        </div>
    </div>

<br><br><br>
<?php include('footer.php') ?>

</body>

<script>
	var all_topics_page = true;
    let start = 0;
    let limit = 5;
</script>
<script src="like-rating.js?v4"></script>
<script src="time.js?v1"></script>
<script src="community-topics.js?v13"></script>


<script>
//-----------------------------------------------------------------------------------------------------
    //FOR MIKA:
    /* yung sa may start new topic yung + magiging - pag open yung forum then yung 
    "click here to sign in and reply" masyadong nakadikit sa reply */
    // hide start new topic button
    /*const btn = document.getElementById('btn');
        btn.addEventListener('click', () => {
        btn.style.display = 'none';
    });*/

    // Check if the page is being loaded as a result of a refresh
    if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
        // Clear any stored search results from sessionStorage
        sessionStorage.removeItem('searchResults');
    }

    // Get a reference to the input field
    let searchInput = document.querySelector('.js-search-input');

    // Check if there are any stored search results in sessionStorage
    let storedSearchResults = sessionStorage.getItem('searchResults');
    //console.log(storedSearchResults);
    // Add an event listener to the input field to handle user input
    searchInput.addEventListener('input', function(event) {
        // Get the user's search query
        let query = event.target.value;

        if (query !== '') {
            document.getElementById("loadMoreBtn").style.display = "none";
            //console.log(query);
            // Call the allposts.search method with the user's query
            allposts.search(query);
        } else {
            // Clear any stored search results from sessionStorage
            sessionStorage.removeItem('searchResults');
            //console.log('test');
            // Clear any existing posts and load the first 5 posts from the database
            allposts.start = 0;
            allposts.loadMorePosts(null, true);
        }
    });

    if (storedSearchResults) {
        // Parse the stored search results and display them
        let searchResults = JSON.parse(storedSearchResults);
        allposts.displayPosts(searchResults, true);
        document.getElementById("loadMoreBtn").style.display = "none";
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
<!--script src="like-rating.js?v3"></!--script>-->
</html>