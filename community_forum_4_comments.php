<?php
	
	require('connect.php');
	require('functions.php');

    $post_id = $_GET['id'] ?? 0;

	//pagination start
    $page = $_GET['page'] ?? 1;
    $page = (int)$page;

    if ($page < 1) {
        $page = 1;
    }
    //pagination end
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

	<style>

		.hide{
			display:none;
		}
		
	</style>
	<section class="class_1" >
		<div class="class_11" >

			<?php //include('success.alert.inc.php') ?>
			<?php //include('fail.alert.inc.php') ?>

			<div class="class_11" >
				<h1 class="class_41" style="font-size: 16px;"  >
					Comments
				</h1>
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
		</div>

		<br>
		<?php include'community_forum_5_edit_my_comment.php' ?>
	</section>

	<!--comment card template-->
	<div class="js-comment-card hide class_42" style="animation: appear 3s ease;"  >
		<a href="#" class="js-profile-link class_45" >
			<img src="assets/images/57.png" class="js-image class_47" >
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
			<button class="like-button" onclick="mycomment.like()">Like</button>
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
<script src="mypost.js?v4"></script>
<script src="mycomment.js?v3"></script>
</html>