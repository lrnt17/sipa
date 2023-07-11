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

	</style>
    <?php include('header.php') ?>
    <?php include('community-forum.php') ?>

	<section class="class_1" >
        <div class="js-personal-post ">
            <div class="class_11" >
                <?php //include('success.alert.inc.php') ?>
                <?php //include('fail.alert.inc.php') ?>
                
                <h1 class="class_41"  >
                    Single Post
                </h1>
    
                <?php if(!empty($row)): //pag merong nakitang post?>
                    <div id="post_<?=$row['forum_id']?>" row="<?=htmlspecialchars(json_encode($row))?>" class="class_42" >
                        
                        <!--<a href="profile.php?id=<?//=$row['user']['user_id'] ?? 0?>" class="class_45" >
                            <img src="<?//=$row['user']['image']?>" class="class_47" >
                            <h2 class="class_48" style="font-size:16px"  >
                                <?//=$row['user']['username'] ?? 'Unknown'?>
                            </h2>
                        </a>-->
                        <div>
                            <img src="<?=$row['user']['user_image']?>" class="class_47" >
                            <h2 class="class_48" style="font-size:16px"  >
                                <?//=$row['user']['user_fname'] ?? 'Unknown'?>
                                <?=$row['user_fname']?>
                            </h2>
                        </div>
                        <div class="class_49" >
                           <h4 class="class_41"  >
                                <?=date("jS M, Y H:i:s a",strtotime($row['forum_timestamp']))?>
                            </h4> 
                            <div class="class_15">
                                <?=nl2br(htmlspecialchars($row['forum_title']))?>
                            </div>
                            <div class="class_15"  >
                                <?=nl2br(htmlspecialchars($row['forum_desc']))?>
                            </div>

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
                        <h1 class="class_41" >
                            Comments
                        </h1>

                        <?php if(logged_in()):?>
                            <form onsubmit="mycomment.submit(event)" method="post" class="class_42" >
                                <div class="class_43" >
                                    <textarea placeholder="Write a comment" name="post" class="js-comment-input class_44" ></textarea>
                                </div>
                                <div class="class_45" >
                                    <button class="class_46"  >
                                        Comment
                                    </button>
                                </div>
                            </form>
                        <?php else:?>
                            <div class="class_13" >
                                <i class="bi bi-info-circle-fill class_14">
                                </i>
                                <div onclick="user.login()" class="class_15" style="cursor:pointer;text-align: center;"  >
                                    You're not logged in <br>Click here to login and comment
                                </div>
                            </div>
                        <?php endif;?>

                        <section class="js-comments-loading">
                            <div style="padding:10px;text-align:center;">Loading comments....</div>
                        </section>

                        <div class="class_37" style="display: flex;justify-content: space-between;" >
                            <button onclick="mycomment.prev_page()" class="class_54"  >
                                Prev page
                            </button>
                            <div class="js-page-number">Page 1</div>
                            <button onclick="mycomment.next_page()" class="class_39"  >
                                Next page
                            </button>
                        </div>
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
	<div class="js-comment-card hide class_42" style="animation: appear 3s ease;"  >
		<a href="#" class="js-profile-link class_45" >
			<img src="assets/images/57.png" class="js-photo class_47" >
			<h2 class="js-username class_48" style="font-size:16px" >
				Jane Name
			</h2>
		</a>
		<div class="class_49" >
			<h4 class="js-date class_41"  >
				3rd Jan 23 14:35 pm
			</h4>
			<div class="js-comment class_15"  >
				is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets c
			</div>
			<div class="class_51" >
				<i class="bi bi-chat-left-dots class_52">
				</i>
				<div class="js-reply-link class_53" style="color:blue;cursor: pointer;"  >
					Reply
				</div>
                
			</div>
            
			<div class="js-action-buttons class_51" >
				<div class="js-edit-button class_53" style="color:blue;cursor: pointer;"  >
					Edit
				</div>
				<div class="js-delete-button class_53" style="color:red;cursor: pointer;"  >
					Delete
				</div>
			</div>
		</div>
	</div>
	<!--end comment card template-->
</body>

<script>
    var page_number = <?=$page?>;
    var post_id = <?=$post_id?>;
</script>
<!--<script src="allposts.js?v1"></script>-->
<script src="mypost.js?v11"></script>
<script src="mycomment.js?v34"></script>

</html>