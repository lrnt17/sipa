<?php
	
	require('connect.php');
	require('functions.php');

	$post_id = $_GET['id'] ?? 0;

	//dito kinukuha yung data depende sa post_id
	$query = "select * from forum where forum_id = '$post_id' limit 1";
	$row = query($query);

	if($row)
	{
		$row = $row[0];
		$id = $row['user_id'];
		$query = "select * from users where user_id = '$id' limit 1";
		$user_row = query($query);
		
		if($user_row){
			$row['user'] = $user_row[0];
			$row['user']['user_image'] = get_image($user_row[0]['user_image']);
		}

        $forum_id = $row['forum_id'];
        $query = "select count(*) from rating_info where post_id = $forum_id AND rating_action = 'like' limit 1";
        $rating_row = query($query);
	}

	$page = $_GET['page'] ?? 1;
	$page = (int)$page;

	if($page < 1){
        $page = 1;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>

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

        .js-userimage-reply{
            width: 40px;
            height: 40px;
            border-radius:50%; border-style: solid;
        }

        .replies-container{
            background-color:;
        }
        .btn_selected{
            background: transparent;
            border: none;
            outline: none;
            color: red;
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
	</style>
</head>
<body style="background: #F2F5FF;">
    
    <?php include('header.php') ?>
    <?php include('community-forum.php') ?>

    <div class="container">
        <div class="row px-5">
            <div class="col-2">
                <!-- sa column 'tong div -->
            </div>

            <div class="col">

	<section class="class_1" >
        <div class="js-personal-post ps-5 pe-5 pt-5 pb-4 my-5 rounded-5 shadow-sm" style="animation: appear 3s ease; background-color:white;">
            <div class="class_11" >
                <?php //include('success.alert.inc.php') ?>
                <?php //include('fail.alert.inc.php') ?>
                
                <!--<h1 class="class_41"  >
                    Single Post
                </h1>-->
    
                <?php if(!empty($row)): //pag merong nakitang post?>
                    <!-- post card -->
                    <div id="post_<?=$row['forum_id']?>" row="<?=htmlspecialchars(json_encode($row))?>" class="class_42" >
                        
                        <!--<a href="profile.php?id=<?//=$row['user']['user_id'] ?? 0?>" class="class_45" >
                            <img src="<?//=$row['user']['image']?>" class="class_47" >
                            <h2 class="class_48" style="font-size:16px"  >
                                <?//=$row['user']['username'] ?? 'Unknown'?>
                            </h2>
                        </a>-->
                        
                        <div class="class_49" >
                            
                            <div class="class_15"> <!-- title -->
                                <h2 class="js-title py-1">
                                    <?=nl2br(htmlspecialchars($row['forum_title']))?> 
                                </h2>
                            </div>

                            <div class="class_15 py-1"> <!-- post -->
                                <?=nl2br(htmlspecialchars($row['forum_desc']))?>
                            </div>


                            <hr>

                            <div class="row m-1" style="align-items: center;">
                                <div class="col-5">
                                    <img src="<?=$row['user_img']?>" class="class_47" style="width:40px; height:40px; border-radius:50%; border-style: solid;" >
                                    <span style="font-size:14px; color:gray;"> Posted by</span> 
                                    <h2 class="class_48" style="font-size:14px; display:inline; color:blue;" >
                                        <?//=$row['user']['user_fname'] ?? 'Unknown'?>
                                        <?=$row['user_fname']?>
                                    </h2>
                                </div>

                                <!-- time -->
                                <div class="col-5 pt-3">
                                    <p class="class_41" style="font-size:14px; color: gray;" > 
                                        <?//=date("jS M, Y H:i:s a",strtotime($row['forum_timestamp']))?>
                                        <span id="post-timestamp"><?=date('Y-m-d\TH:i:s',strtotime($row['forum_timestamp']))?></span>
                                    </p> 
                                </div>
                                

                                <!-- Display Like button and number of likes -->
                                <div class="col-2 pt-2">
                                    <button class="single-post js-like-button " forum_id="<?=$row['forum_id']?>" style="cursor: pointer;">
                                        <i class="fa-solid fa-heart" style="pointer-events: none;"></i>
                                    </button>
                                    <span class="single-post js-num-likes" style="display:inline;" forum_id="<?=$row['forum_id']?>">
                                        <?php 
                                            if($rating_row){
                                                $row['getlikes'] = $rating_row[0];
                                                if (is_array($row['getlikes'])) {
                                                    foreach ($row['getlikes'] as $value) {
                                                        if ($value > 0) {
                                                            echo $value;
                                                        }
                                                    }
                                                } else {
                                                    echo $row['getlikes'];
                                                }
                                            }
                                        ?>
                                    </span>
                                </div>

                            </div>

                            <hr>

                            <!-- profile, name -->
                            
                            <?php// if(i_own_post($row)):?>
                                <!--<div class="class_51" >
                                    <div onclick="my_edit_post.show_me(<?//=$row['forum_id']?>)" class="class_53" style="color:blue;cursor: pointer;"  >
                                        Edit
                                    </div>
                                    <div onclick="mypost.delete(<?//=$row['forum_id']?>)" class="class_53" style="color:red;cursor: pointer;"  >
                                        Delete
                                    </div>
                                </div>-->
                            <?php// endif;?>

                        </div>
                    </div>
                    
                    <!-- comments on a post -->
                    <div class="class_11" >
                        <p class="class_41" style="font-size:16px; color: #1b4ca1;" >
                            Comments 
                        </p>

                        <section class="js-comments-loading">
                            <div style="padding:10px;text-align:center;">Loading comments....</div>
                        </section>
                        
                        <br><br>

                        <!-- comment box-->
                        <?php if(logged_in()):?>
                            <form onsubmit="mycomment.submit(event)" method="post" class="class_42 p-2 rounded-4" style="background-color:#ebebeb;" >
                                <div class="d-grid" >
                                    <textarea placeholder="Write a comment" rows="2" name="post" class="js-comment-input class_44 p-3" style="background-color: transparent; border:none; resize: none;" ></textarea>
                                </div>
                                <hr>
                                <div class="row mx-1 my-2">
                                    <div class="col-auto me-auto">
                                        <p for="anonymous" style="display:inline; color:#5582da;">Post anonymously:</p>
                                        <input type="checkbox" id="anonymous" name="anonymous" class="js-anonymous-comment"><label for="anonymous">anonymous</label>
                                    </div>
                                    <div class="class_45 col-auto" >
                                        <button class="class_46 btn">
                                            <i class="fa-solid fa-reply" style="pointer-events: none;"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        <?php else:?>
                            <div class="class_13" >
                                
                                <div onclick="user.login()" class="class_15" style="cursor:pointer;text-align: center;"  >
                                    <i class="fa-solid fa-circle-exclamation"> </i> You're not signed in. 
                                    <p style="color: blue;">Click here to sign in and comment</p>
                                </div>
                            </div>
                        <?php endif;?>

                        <!--<div class="class_37" style="display: flex;justify-content: space-between;" >
                            <button onclick="mycomment.prev_page()" class="class_54"  >
                                Prev page
                            </button>
                            <div class="js-page-number">Page 1</div>
                            <button onclick="mycomment.next_page()" class="class_39"  >
                                Next page
                            </button>
                        </div>-->
                    </div>
                <?php else:?>
                    <div class="class_16" >
                        <i class="bi bi-exclamation-circle-fill class_14">
                        </i>
                        <div class="class_15"  >
                            Post not found!
                        </div>
                    </div>
                <?php endif;?>

            </div>
        </div>
		<br><br>
		<?php //include('login.inc.php') ?>
		<?php //include('signup.inc.php') ?>
        <?php include('edit-my-reply.php') ?>
        <?php include('community_forum_3_edit_my_post.php') ?>
		<?php include('community_forum_5_edit_my_comment.php') ?>
	</section>
	
	<!--comment card template-->
	<div class="js-comment-card hide class_42 my-4" style="animation: appear 3s ease; background-color: ;">
    
     <!--3 cols (pic, reply, edit)-->
    <div class="row">
         <!--profile pic-->
         <div class="col-auto">
            <a href="#" class="js-profile-link class_45" style="text-decoration:none;">
                <img src="assets/images/57.png" class="js-photo class_47" style="width:40px; height:40px; border-radius:50%; border-style: solid;"  >
            </a>
        </div>
		
        <!--reply--> <!--NAME, COMMENT, TIME, LIKE -->
		<div class="col" >
            <!--div for name, comment-->
            <div class="cont p-3 rounded-4" style="background-color:#f2f2f2;">
                <div class="row">
                    <div class="col-auto me-auto">
                        <a href="#" class="js-profile-link class_45" style="text-decoration:none;">
                            <h2 class="js-username class_48" style="font-size:16px" >
                                Jane Name
                            </h2>
                        </a>
                    </div>

                    <!--time-->
                    <div class="col-auto">
                        <p class="js-date class_41" style="font-size:14px; color: gray;" >
                            3rd Jan 23 14:35 pm
                        </p>
                </div>
                
                </div>


                

                <div class="js-comment class_15"  >
                    is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets c
                </div>
            </div>

            <!--inside col, row for like,time-->
            <div class="row mt-3">
                <!--like, like span-->
                <div class="js-like-section col-auto">
                    <button class="js-like-button class_53" style="font-size:14px; cursor: pointer;"  >
                       <i class="fa-solid fa-heart" style="pointer-events: none;"></i>
                    </button>
                    <span class="js-num-likes"></span>
                </div>
                
                

                <div class="js-reply-section class_51 col" >
                    <div class="js-reply-link class_53" style="font-size:14px; color:blue;cursor: pointer; color: #1b4ca1; "  >
                        Reply
                    </div>
                </div>
            </div>
		</div>

        <!--edit,del-->
        <div class="col-1">
            <div class="js-action-buttons class_51" >

            <!--3 dots-->
            <a data-toggle="dropdown" class="btn"><i class="fa-solid fa-ellipsis fs-4"></i></a>
                
                <!--div edit,del-->

                <div class="container">
                    <!--ul element-->
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
        </div>

    </div>
        

	</div>
	<!--end comment card template-->

            </div>
        </div>
    </div>
</body>

<script>
    //var page_number = <?=$page?>;
    var post_id = <?=$post_id?>;
    
</script>
<!--<script src="allposts.js?v1"></script>-->
<!--<script src="mypost.js?v11"></script>-->
<script src="time.js?v1"></script>
<script src="like-rating.js?v3"></script>
<script src="community-topics.js?v6"></script>
<script src="mycomment.js?v42"></script>

<script>
    // Call the updateTimestamps function initially when the page loads
    time.updateTimestamps(document.getElementById('post-timestamp'), '<?=$row['forum_timestamp']?>');
    
    //Call the forum.singlePost method when the page is loaded
    window.addEventListener('DOMContentLoaded', function() {
        mycomment.singlePost();
    });

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
</script>

</html>