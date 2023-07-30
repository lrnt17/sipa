<?php 
// DO NOT INCLUDE ALL OF THIS!!!
    require("connect.php");
    require("functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Forum | SiPa</title>
</head>
<body>
    <style>
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

		.btn{
            background-color: blue;
        }

        .btn_selected{
            background-color: red;
        }

        .disabled {
            pointer-events: none;
            color: #ccc;
        }

        .highlight {
            background-color: yellow;
        }
	</style>

    <!-- navigation bar with logo -->
    <?php include('header.php') ?>
    <?php include('community-forum.php') ?>
    
    <div id="search-results" class="hide"></div>
    <!-- community forum content -->
    <section>
        <div class="js-personal-post ">
            <button onclick="allposts.new_topic()">+ Start New Topic</button>
            <form onsubmit="allposts.submit(event)" method="post" class="js-start-topic class_42 hide " >
                <div class="">
                    <input type="text" placeholder="Title" name="post_title" id="post_title" class="js-post-title">
                </div>
                <div class="class_43" >
                    <textarea placeholder="Whats on your mind?" name="post" class="js-post-input class_44" ></textarea>
                </div>
                
                <div>
                    <label for="anonymous">Post anonymously:</label>
                    <input type="checkbox" id="anonymous" name="anonymous" class="js-anonymous">
                </div>
                <div class="class_45" >
                    <button class="class_46">
                        Post
                    </button>
                    
                </div>
            </form>

            <section class="js-posts">
                    <div style="padding:10px;text-align:center;"></div>
            </section>

            <div id="postsSection">
                <div id="postContainer">
                    <!-- Existing posts go here -->
                    <button id="loadMoreBtn" onclick="allposts.loadMorePosts()" class="js-loadmore-btn ">View More</button>
                </div>
            </div>

            <div class="class_37" style="display: flex;justify-content: space-between;" >
            </div>
        </div>

        <!-- modal ito na mag-aappear pag pinindot ni user yung edit button -->
        <?php include'community_forum_3_edit_my_post.php' ?>        
    </section>
   
    <!-- post card template-->
    <template id="postCardTemplate" class="js-postCardTemplate">
        <div class="js-post-card class_42" style="animation: appear 3s ease;">
            <img src="assets/images/user.jpg" class="js-image class_47" >
            <div>
                <span>Posted by</span> 
                <a href="#" class="js-profile-link class_45" >
                    <h2 class="js-username class_48" style="font-size:16px; display:inline;" >
                        Jane Name
                    </h2>
                </a>
            </div>
            <div class="class_49" >
                <h4 class="js-date class_41"  >
                    3rd Jan 23 14:35 pm
                </h4>
                <h2 class="js-title ">
                    Contraception
                </h2>
                <div class="js-post class_15"  >
                    is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets c
                </div>
                <div class="class_51 js-comment-link-count" >
                    <i class="bi bi-chat-left-dots class_52">
                    </i>
                    <div class="js-comment-link class_53" style="color:blue;cursor: pointer;"  >
                        Comment
                    </div>
                </div>

                <button class="js-like-button class_53" style="cursor: pointer;"  >
                    Like
                </button>
                <span class="js-num-likes"></span>
                
                <div class="js-modification-buttons class_51" >
                    <div class="js-edit-button class_53" style="color:blue;cursor: pointer;"  >
                        Edit
                    </div>
                    <div class="js-delete-button class_53" style="color:red;cursor: pointer;"  >
                        Delete
                    </div>
                </div>
            </div>
        </div>
    </template>
	<!--end post card template-->

</body>

<script>
	var all_topics_page = true;
    let start = 0;
    let limit = 5;
    
    //----------------------------------------------------------------------------------
    

</script>
<script src="sms_testing.js?v33"></script>
<script>
    // Get a reference to the input field
    let searchInput = document.querySelector('.js-search-input');

    // Check if the page is being loaded as a result of a refresh
    if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
        // Clear any stored search results from sessionStorage
        sessionStorage.removeItem('searchResults');
        sessionStorage.clear();
    }

    // Check if there are any stored search results in sessionStorage
    let storedSearchResults = sessionStorage.getItem('searchResults');
    console.log(storedSearchResults);
    // Add an event listener to the input field to handle user input
    searchInput.addEventListener('input', function(event) {
        // Get the user's search query
        let query = event.target.value;
        
        if (query !== '') {
            //console.log(query);
            document.getElementById("loadMoreBtn").style.display = "none";

            // Call the allposts.search method with the user's query
            allposts.search(query);
        } else {
            
            //document.querySelector(".js-loadmore-btn").classList.remove('hide');
            // Clear any stored search results from sessionStorage
            sessionStorage.removeItem('searchResults');
            allposts.start = 0;
            // Clear any existing posts and load the first 5 posts from the database
            allposts.loadMorePosts(null, true);
        }
    });

    if (storedSearchResults) {
        // Parse the stored search results and display them
        let searchResults = JSON.parse(storedSearchResults);
        allposts.displayPosts(searchResults, true);

        // Check if there are more posts to load
        //if (searchResults.length <= limit || searchResults.length >= limit) {
            // Hide the "View More" button
            document.getElementById("loadMoreBtn").style.display = "none";
        //}
    }
</script>
</html>