<?php 
    require("connect.php");
    require("functions.php");

    //pagination start
    $page = $_GET['page'] ?? 1;
    $page = (int)$page;

    if ($page < 1) {
        $page = 1;
    }
    //pagination end
    //echo $_SESSION['USER']['user_id'];
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

	</style>

    <!-- navigation bar with logo -->
    <?php include('header.php') ?>
    <?php include('community-forum.php') ?>

    <!-- community forum content -->
    <section>
        <form onsubmit="mypost.submit(event)" method="post" class="class_42" >
            <div class="">
                <input type="text" placeholder="Title" name="post_title" id="post_title" class="js-post-title">
            </div>
            <div class="class_43" >
                <textarea placeholder="Whats on your mind?" name="post" class="js-post-input class_44" ></textarea>
            </div>
            
            <div class="class_45" >
                <button class="class_46"  >
                    Post
                </button>
            </div>
        </form>

        <section class="js-posts">
				<div style="padding:10px;text-align:center;">Loading posts....</div>
        </section>

        <div class="class_37" style="display: flex;justify-content: space-between;" >
            <button onclick="mypost.prev_page()" class="class_54"  >
                Prev page
            </button>
            <div class="js-page-number">Page 1</div>
            <button onclick="mypost.next_page()" class="class_39"  >
                Next page
            </button>
        </div>
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
            <h2 class="js-title ">
                Contraception
            </h2>
			<h4 class="js-date class_41"  >
				3rd Jan 23 14:35 pm
			</h4>
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
		</div>
	</div>
	<!--end post card template-->

</body>

<script>
	
	var mypost = {

        page_number: <?=$page?>,

		submit: function(e){

			e.preventDefault();
			let text = document.querySelector(".js-post-input").value.trim();
            let title = document.getElementById("post_title").value;
			
			if(text == "" && title == ""){
				alert("Please type something");
				return;
			}

			let form = new FormData(); //new form within javascript
 
			form.append('post', text);
            form.append('post_title', title);
			form.append('data_type', 'add_post');
			var ajax = new XMLHttpRequest();

			ajax.addEventListener('readystatechange',function(){

				if(ajax.readyState == 4)
				{
					if(ajax.status == 200){

						//console.log(ajax.responseText);
						let obj = JSON.parse(ajax.responseText);
						alert(obj.message);

						if(obj.success){
                            document.querySelector(".js-post-input").value = "";
                            document.getElementById("post_title").value = "";
							mypost.load_posts();
						}
					}else{
						alert("Please check your internet connection");
					}
				}
			});

			ajax.open('post','ajax.php', true);
			ajax.send(form);
		},
		//dito mapapalitan si loading...... sa taas, magiging data na sya
		load_posts: function(e){

			let form = new FormData();
 
            form.append('page_number', mypost.page_number);
			form.append('data_type', 'load_posts');
			var ajax = new XMLHttpRequest();

			ajax.addEventListener('readystatechange',function(){

				if(ajax.readyState == 4)
				{
					if(ajax.status == 200){

						//console.log(ajax.responseText);
						let obj = JSON.parse(ajax.responseText);

						if(obj.success){
							let post_holder = document.querySelector(".js-posts");

							post_holder.innerHTML = "";
							let template = document.querySelector(".js-post-card");
                            
                            if (typeof obj.rows == 'object') {
                            
                                for (var i = 0; i < obj.rows.length; i++) {
                                    template.querySelector(".js-title").innerHTML = obj.rows[i].forum_title;//si .forum_title ito naman sa db
                                    template.querySelector(".js-post").innerHTML = obj.rows[i].forum_desc; //ito naman sa db
                                    template.querySelector(".js-date").innerHTML = obj.rows[i].date;// si .date based  sa nasa ajax
                                    template.querySelector(".js-comment-link").setAttribute('onclick',`mypost.view_comments(${obj.rows[i].forum_id})`);
                                    template.querySelector(".js-username").innerHTML = (typeof obj.rows[i].user == 'object') ? obj.rows[i].user.user_fname : 'User';
                                    template.querySelector(".js-profile-link").href = (typeof obj.rows[i].user == 'object') ? 'profile.php?id='+obj.rows[i].user.user_id : '#';

                                    /*if(typeof obj.rows[i].user == 'object')
                                        template.querySelector(".js-image").src = obj.rows[i].user.image;*/

                                    let clone = template.cloneNode(true);
                                    clone.classList.remove('hide');
                                    
                                    post_holder.appendChild(clone);
                                }

                            }else{
                                post_holder.innerHTML = "Nothing follows";
                            }
						}
                        document.querySelector(".js-page-number").innerHTML = "Page " + mypost.page_number;
					}
				}
			});

			ajax.open('post','ajax.php', true);
			ajax.send(form);
		},

		view_comments: function(forum_id){

			window.location.href = "post.php?id="+forum_id;
		},

        next_page: function(){ //dito iicrement si page
            mypost.page_number = mypost.page_number + 1;
            //mypost.load_posts();
            window.location.href = 'community_forum_1.php?page=' + mypost.page_number;
        },

        prev_page: function(){
            mypost.page_number = mypost.page_number - 1;

            //pag bumaba less than 1, page 1 pa rin lalabas
            if (mypost.page_number < 1) {
                mypost.page_number = 1;
            }
            window.location.href = 'community_forum_1.php?page=' + mypost.page_number;
            //mypost.load_posts();
        },


	};

	mypost.load_posts(); //dito lumabas yung mga forum kasi tinatawag
</script>

</html>