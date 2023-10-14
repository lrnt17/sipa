<?php
	require('connect.php');
	require('functions.php');

    if (isset($_SESSION['USER']['user_id'])) {
        $user_id = $_SESSION['USER']['user_id'];
    } else {
        $user_id = null;
    }

	$video_id = $_GET['id'] ?? 0;

	//dito kinukuha yung data depende sa video_id
	$query = "select * from videos where video_id = '$video_id' limit 1";
	$row = query($query);

	if($row)
	{
        $row = $row[0];

        $id = $row['partner_facility_id'];
        $query = "select * from partner_facility where partner_facility_id = '$id' limit 1";
        $user_row = query($query);

        if ($user_row) {
            $row['partner_facility'] = $user_row[0];
            $row['partner_facility']['logo'] = get_image($user_row[0]['facility_logo']);
            // Display the full name
            $row['partner_facility']['location'] = $user_row[0]['city_municipality'];
            $row['partner_facility']['name'] = $user_row[0]['health_facility_name'];
        }

        $video_id = $row['video_id'];
        $query = "select count(*) from rating_video where video_id = $video_id AND rating_action = 'like' limit 1";
        $rating_row = query($query);

        $birth_control_id = $row['birth_control_id'];
        $query = "select * from birth_controls where birth_control_id = '$birth_control_id' limit 1";
        $birth_control_row = query($query);
        
        if($birth_control_row){
            $rows['birth_control']['name'] = $birth_control_row[0]['birth_control_name'];
        } else {
            // Manually add a custom name based on the birth_control_id value
            switch ($birth_control_id) {
                case 18:
                    $rows['birth_control']['name'] = 'Family Planning';
                    break;
                // Add more cases as needed
                default:
                    $rows['birth_control']['name'] = 'No name available';
            }
        }
	}
    //echo $rows['birth_control']['name'];
    //echo $_SESSION['USER']['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>Video</title>
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

        .js-username-reply{
            font-size:14px !important;
        }

        .btn{
            background-color: blue;
        }


        .btn_selected{
            background: transparent;
            border: none;
            color: red;
            margin: 5px;
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
</head>
<body style="background: #F2F5FF;">

    <?php include('header.php') ?>
    <?php //include('videos.php') ?>

	<section class="container">
        <div class="js-personal-post ">
            <div class="">
                <?php //include('success.alert.inc.php') ?>
                <?php //include('fail.alert.inc.php') ?>
                
                <h1 class="">
                    <!--Single Video-->
                </h1>
    
                <?php if(!empty($row)): //pag merong nakitang post?>
                    <div class="row">
                        <!--videos-->
                        <div class="col-lg">
                            <div id="video_<?=$row['video_id']?>" row="<?=htmlspecialchars(json_encode($row))?>" class="video">
                                <div>
                                    <video src="<?=$row['video']?>" width="100%" controls id="video-display" class="js-video-display"></video>
                                </div>
                                <div class="row" style="display: flex; align-items: flex-end;">
                                    <div class="col me-auto">
                                        <h2 class="mt-3">
                                            <?=htmlspecialchars($row['video_title'])?>
                                        </h2>
                                    </div>
                                    <div class="col-auto me-4">
                                        <p class="" style="font-size: 13px;">
                                            <?php
                                                if ($row['view_count'] == 0) {
                                                    echo "No views";
                                                } else {
                                                    echo $row['view_count'] . ($row['view_count'] == 1 ? ' view' : ' views');
                                                }
                                            ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="d-flex justify-content-center mb-2">
                                        <div style="width: 99%;
                                        background-color: #B2B2B2;
                                        border-radius: 99px;
                                        height: 1.4px;"></div>
                                    </div>
                                </div>

                                <div class="">
                                        <?=nl2br(htmlspecialchars($row['video_desc']))?>
                                </div>

                                
                                <p class="my-2" style="font-size: 13px; color: green;">
                                <span translate="no"><?=$rows['birth_control']['name']?></span>
                                </p>  
                                
                                <div class="row">
                                    <div class="d-flex justify-content-center mb-2">
                                        <div style="width: 99%;
                                        background-color: #B2B2B2;
                                        border-radius: 99px;
                                        height: 1.4px;"></div>
                                    </div>
                                </div>

                                <div class="row mt-1 mb-4">
                                    <div class="col">
                                        <div>
                                            <img src="<?=$row['partner_facility']['logo']?>" class="" style="width:40px; height:40px; border-radius:50%; border-style: solid;">
                                            <span style="font-size:14px; color:gray;"> Posted by</span>
                                            <h2 class="" style="font-size:14px; display:inline; color: #1b4ca1;">
                                                <?//=$row['user']['user_fname'] ?? 'Unknown'?>
                                                <?=$row['partner_facility']['name']?>
                                            </h2>
                                        </div>
                                    </div>

                                    <div class="col col-md-auto">
                                            <p class="mt-2" style="font-size:14px; color: gray;"> 
                                                <span id="video-timestamp"><?=date('Y-m-d\TH:i:s',strtotime($row['video_timestamp']))?></span>
                                            </p>
                                            

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
                                    <div class="col col-lg-auto">
                                        <div>
                                            <!-- Display Like button and number of likes -->
                                            <button class="single-video js-like-button " video_id="<?=$row['video_id']?>" style="cursor: pointer;">
                                                <i class="fa-solid fa-heart" style="pointer-events: none;"></i>
                                            </button>
                                            <span class="single-video js-num-likes me-2" video_id="<?=$row['video_id']?>">
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
                                </div>

                                

                                
                                
                            </div>
                        </div>

                        <!--comment-->
                        <div class="col-lg-5 ms-2">
                             <!-- comments on a post -->
                            <div class="comment">
                                <h5>
                                    Comments
                                </h5>

                                <section class="js-comments-loading">
                                    <div style="padding:10px;text-align:center;">Loading comments....</div>
                                </section>
                                
                                <br><br>

                                <?php if(logged_in()):?>
                                    <form onsubmit="single_video.add_comment(event)" method="post" class="class_42 p-2 rounded-4" style="background-color:#ebebeb;">
                                    <div class="d-grid" >
                                    <textarea placeholder="Write a comment" rows="2" name="post" class="js-comment-input class_44 p-3" style="background-color: transparent; border:none; resize: none;" maxlength="500"></textarea>
                                </div>
                                <hr>
                                <div class="row mx-1 my-2">
                                    <div class="col-auto me-auto">
                                        <p for="anonymous_comment" style="display:inline; color:#5582da;">Comment anonymously:</p>
                                        <input type="checkbox" id="anonymous_comment" name="anonymous_comment" class="js-anonymous-comment"><label for="anonymous_comment">anonymous</label>
                                    </div>
                                    <div class="class_45 col-auto" >
                                        <button class="class_46 btn">
                                            <i class="fa-solid fa-reply" style="pointer-events: none;"></i>
                                        </button>
                                    </div>
                                </div>
                                    </form>
                                <?php else:?>
                                    <div class="">
                                        <div onclick="user.login()" class="" style="cursor:pointer;text-align: center;"  >
                                            <i class="fa-solid fa-circle-exclamation"> </i> You're not signed in. 
                                            <p style="color: blue;">Click here to sign in and comment</p>
                                        </div>
                                    </div>
                                <?php endif;?>

                            </div>

                        </div>
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
	<div class="js-comment-card hide class_42 my-4" style="animation: appear 3s ease; background-color: ;">
    
     <!--3 cols (pic, reply, edit)-->
        <div class="row">
            <!--profile pic-->
            <div class="col-auto">
                
                    <img src="assets/images/57.png" class="js-photo class_47" style="width:40px; height:40px; border-radius:50%; border-style: solid;"  >
                
            </div>
            
            <!--reply--> <!--NAME, COMMENT, TIME, LIKE -->
            <div class="col" >
                <!--div for name, comment-->
                <div class="cont p-1 rounded-4">
                    <div class="row">
                        <div class="col-auto me-auto">
                            
                                <h2 class="js-username class_48" style="font-size:15px" >
                                    Jane Name
                                </h2>
                            
                        </div>

                        <!--time-->
                        <div class="col-auto">
                            <p class="js-date class_41" style="font-size:12px; color: gray;" >
                                3rd Jan 23 14:35 pm
                            </p>
                    </div>
                    
                    </div>

                    <div class="js-comment class_15" style="font-size:14px" >
                        is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets c
                    </div>
                </div>

                <!--inside col, row for like,time-->
                <div class="row mt-1" >
                    <!--like, like span-->
                    <div class="js-like-section col-auto">
                        <button class="js-like-button class_53" style="font-size:14px; cursor: pointer;"  >
                        <i class="fa-solid fa-heart" style="pointer-events: none;"></i>
                        </button>
                        <span class="js-num-likes" style="font-size:13px;"></span>
                    </div>
                    
                    <div class="js-reply-section class_51 col mt-1" >
                        <div class="js-reply-link class_53 mt-1" style="font-size:14px; cursor: pointer; color: #1b4ca1; "  >
                            Reply
                        </div>
                    </div>
                </div>
            </div>

            <!--edit,del-->
            <div class="col-auto">
                <!--div-->
                <div class="js-action-buttons class_51" >

                <!--3 dots-->
                <a data-toggle="dropdown" class="btn"><i class="fa-solid fa-ellipsis" style="font-size:14px;"></i></i></a>
                    
                    <!--div edit,del-->
                    <div class="container">
                        
                        <!--ul element-->
                        <ul class="dropdown-menu dropdown-menu-right">
                            <div class="js-edit-button class_53 dropdown-item" style="color:blue;cursor: pointer; font-size:14px;"  >
                                Edit
                            </div>
                            <div class="js-delete-button class_53 dropdown-item" style="color:red;cursor: pointer; font-size:14px;"  >
                                Delete
                            </div>
                        </ul>

                    </div>

                </div>
            </div>

        </div>
            

	</div>
	<!--end comment card template-->

    <?php include('footer.php') ?>
</body>

<script>
    var video_id = <?=$video_id?>;
    var userId = <?php echo json_encode($user_id); ?>;
</script>
<!--<script src="allposts.js?v1"></script>-->
<!--<script src="mypost.js?v11"></script>-->
<script src="time.js?v1"></script>
<script src="like-rating-video.js?v3"></script>
<!--<script src="community-topics.js?v6"></script>-->
<script src="video.js?v10"></script>

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