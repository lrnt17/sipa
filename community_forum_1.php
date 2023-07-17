<?php
// DO NOT INCLUDE ALL OF THIS!!! 
    require("connect.php");
    require("functions.php");

    //pagination start
    $page = $_GET['page'] ?? 1;
    $page = (int)$page;

    if ($page < 1) {
        $page = 1;
    }
    //pagination end
    //$user_id = $_SESSION['USER']['user_id'];
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
	</style>

    <!-- navigation bar with logo -->
    <?php include('header.php') ?>
    <?php include('community-forum.php') ?>

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
                    <div style="padding:10px;text-align:center;">Loading posts....</div>
            </section>

            <div class="class_37" style="display: flex;justify-content: space-between;" >
                <button onclick="allposts.prev_page()" class="class_54"  >
                    Prev page
                </button>
                <!--<button onclick="allposts.view_more()" class="js-view-more class_54"  >
                    View more
                </button>-->
                <div class="js-page-number">Page 1</div>
                <button onclick="allposts.next_page()" class="class_39"  >
                    Next page
                </button>
            </div>
        </div>

        <!-- modal ito na mag-aappear pag pinindot ni user yung edit button -->
        <?php include'community_forum_3_edit_my_post.php' ?>        
    </section>
   
    <!-- post card template-->
	<div class="js-post-card hide class_42" style="animation: appear 3s ease;" >
		<a href="#" class="js-profile-link class_45" >
			<img src="assets/images/user.jpg" class="js-image class_47" >
			<h2 class="js-username class_48" style="font-size:16px" >
				Jane Name
			</h2>
		</a>
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
			<div class="class_51" >
				<i class="bi bi-chat-left-dots class_52">
				</i>
				<div class="js-comment-link class_53" style="color:blue;cursor: pointer;"  >
					Comments
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
	<!--end post card template-->

</body>

<script>
	var page_number = <?=$page?>; // ito yung page numbering sa baba
	var all_topics_page = true;
    //let start = 0;
    //let limit = 5;
</script>
<script src="allposts.js?v23"></script>

</html>