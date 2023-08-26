<?php
	require('connect.php');
	require('functions.php');

	$video_id = $_GET['id'] ?? 0;

	//dito kinukuha yung data depende sa video_id
	$query = "select * from videos where video_id = '$video_id' limit 1";
	$row = query($query);

	if($row)
	{
        $row = $row[0];
        $video_id = $row['video_id'];
        $query = "select count(*) from rating_video where video_id = $video_id AND rating_action = 'like' limit 1";
        $rating_row = query($query);

        $birth_control_id = $row['birth_control_id'];
        $query = "select * from birth_controls where birth_control_id = '$birth_control_id' limit 1";
        $birth_control_row = query($query);
        
        if($birth_control_row){
            $rows['birth_control']['name'] = $birth_control_row[0]['birth_control_name'];
        }
	}
    //echo $rows['birth_control']['name'];
    echo $_SESSION['USER']['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video</title>
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

		.hide{
			display:none;
		}

        .js-userimage-reply{
            width: 50px;
            height: 50px;
        }

        .btn{
            background-color: blue;
        }

        .btn_selected{
            background-color: red;
        }

        .js-replied{
            height: 120px;
            border: 10px solid yellowgreen;
        }
	</style>
    <?php //include('header.php') ?>
    <?php include('videos.php') ?>

	<section class="">
        <div class="js-personal-post ">
            <div class="">
                <?php //include('success.alert.inc.php') ?>
                <?php //include('fail.alert.inc.php') ?>
                
                <h1 class="">
                    Single Video
                </h1>
    
                <?php if(!empty($row)): //pag merong nakitang post?>
                    <div id="video_<?=$row['video_id']?>" row="<?=htmlspecialchars(json_encode($row))?>" class="">
                        <div>
                            <video src="<?=$row['video']?>" width="300" controls id="video-display" class="js-video-display"></video>
                        </div>
                        <h2>
                            <?=htmlspecialchars($row['video_title'])?>
                        </h2>
                        <p>
                            <?=$rows['birth_control']['name']?>
                        </p>    
                        <div>
                            <img src="<?=$row['user_img']?>" class="" width="120">
                            <h2 class="" style="font-size:16px">
                                <?//=$row['user']['user_fname'] ?? 'Unknown'?>
                                <?=$row['user_fname']?>
                            </h2>
                        </div>
                        <div>
                            <!-- Display Like button and number of likes -->
                            <button class="single-video js-like-button" video_id="<?=$row['video_id']?>" style="cursor: pointer;">
                                Like
                            </button>
                            <span class="single-video js-num-likes" video_id="<?=$row['video_id']?>">
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
                        <div class="">
                            <p class="">
                            <?php
                                if ($row['view_count'] == 0) {
                                    echo "No views";
                                } else {
                                    echo $row['view_count'] . ($row['view_count'] == 1 ? ' view' : ' views');
                                }
                            ?>
                            </p>
                            <h4 class="">
                                <span id="video-timestamp"><?=date('Y-m-d\TH:i:s',strtotime($row['video_timestamp']))?></span>
                            </h4>
                            <div class="">
                                <?=nl2br(htmlspecialchars($row['video_desc']))?>
                            </div>

                            <?php// if(i_own_post($row)):?>
                                <!--<div class="class_51" >
                                    <div onclick="my_edit_post.show_me(<?//=$row['video_id']?>)" class="class_53" style="color:blue;cursor: pointer;"  >
                                        Edit
                                    </div>
                                    <div onclick="mypost.delete(<?//=$row['video_id']?>)" class="class_53" style="color:red;cursor: pointer;"  >
                                        Delete
                                    </div>
                                </div>-->
                            <?php// endif;?>

                        </div>
                    </div>
                    
                    <!-- comments on a post -->
                    <div class="">
                        <h1 class="">
                            Comments -------------------------------------------------------------------------------------------------------------------------------------------------------
                        </h1>

                        <section class="js-comments-loading">
                            <div style="padding:10px;text-align:center;">Loading comments....</div>
                        </section>
                        
                        <br><br>

                        <?php if(logged_in()):?>
                            <form onsubmit="single_video.add_comment(event)" method="post" class="">
                                <div class="">
                                    <textarea placeholder="Write a comment" name="post" class="js-comment-input"></textarea>
                                </div>
                                <div>
                                    <label for="anonymous">Comment anonymously:</label>
                                    <input type="checkbox" id="anonymous" name="anonymous" class="js-anonymous-comment">
                                </div>
                                <div class="">
                                    <button class="">
                                        Comment
                                    </button>
                                </div>
                            </form>
                        <?php else:?>
                            <div class="">
                                <div onclick="user.login()" class="" style="cursor:pointer;text-align: center;"  >
                                    You're not logged in <br>Click here to login and comment
                                </div>
                            </div>
                        <?php endif;?>

                    </div>
                <?php else:?>
                    <div class="">
                        <div class="">
                            Video not found!
                        </div>
                    </div>
                <?php endif;?>

            </div>
        </div>
		<br><br>
        <?php //include('edit-my-reply.php') ?>
        <?php //include('community_forum_3_edit_my_post.php') ?>
		<?php //include('community_forum_5_edit_my_comment.php') ?>
	</section>
	
	<!--comment card template-->
	<div class="js-comment-card hide" style="animation: appear 3s ease;"  >
		<!--<a href="#" class="js-profile-link" >-->
			<img src="assets/images/57.png" class="js-photo" width="80">
			<h2 class="js-username" style="font-size:16px" >
				Jane Name
			</h2>
		<!--</a>-->
		<div class="" >
			<h4 class="js-date">
				3rd Jan 23 14:35 pm
			</h4>
			<div class="js-comment">
				is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets c
			</div>
            <div class="js-like-section">
                <button class="js-like-button" style="cursor: pointer;"  >
                    Like
                </button>
                <span class="js-num-likes"></span>
            </div>
			<div class="js-action-buttons">
				<div class="js-edit-button" style="color:blue;cursor: pointer;"  >
					Edit
				</div>
				<div class="js-delete-button" style="color:red;cursor: pointer;"  >
					Delete
				</div>
			</div>
			<div class="js-reply-section">
				<i class="bi bi-chat-left-dots">
				</i>
				<div class="js-reply-link" style="color:blue;cursor: pointer;"  >
					Reply
				</div>
			</div>
            
		</div>
	</div>
	<!--end comment card template-->
</body>

<script>
    var video_id = <?=$video_id?>;
</script>
<!--<script src="allposts.js?v1"></script>-->
<!--<script src="mypost.js?v11"></script>-->
<script src="time.js?v1"></script>
<script src="like-rating-video.js?v1"></script>
<!--<script src="community-topics.js?v6"></script>-->
<script src="video.js?v4"></script>

<script>
    // Call the updateTimestamps function initially when the page loads
    time.updateTimestamps(document.getElementById('video-timestamp'), '<?=$row['video_timestamp']?>');

    // Call add_views when the video ends
    document.getElementById('video-display').addEventListener('ended', function() {
        single_video.increment_views();
    });
    
    //Call the forum.singlePost method when the page is loaded
    window.addEventListener('DOMContentLoaded', function() {
        single_video.check_rating_single_video();
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