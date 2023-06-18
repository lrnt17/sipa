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
    echo $_SESSION['USER']['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Topics | SiPa</title>
</head>
<body>
    <style>
		/* tinatago si sign up, naka hide sya */
		.hide{
			display:none;
		}

	</style>
    <!-- navigation bar with logo -->
    <div class="navigation-bar" id="navigation-container">
        <img src="#">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Videos</a></li>
            <li><a href="#">Right for me</a></li>
            <li><a href="#">FAQs</a></li>
            <li>
                <div class="dropdown">
                    <button class="dropbtn">Services<i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                        <a href="#">Link 2</a>
                        <a href="community_forum_1.php">Community Forum</a>
                        <a href="#">Link 4</a>
                        <a href="#">Link 5</a>
                        <a href="#">Link 6</a>
                        <a href="#">Contraceptive Reviews</a>
                    </div>
                </div>
            </li>
            <div class="profile_pic">
                <a href="profile.php" id="avatar_name" href="#name">
                    <img id="avatar" src="<?php //echo $_SESSION["image"]; ?>" alt="avatar">
                    <?php echo $_SESSION['USER']['user_fname']; ?>
                </a>
            </div>
        </ul>
    </div>

    <h1>Community Forum</h1>
    <input type="text" name="search" id="search" placeholder="Search for topics">
    <br><br>

    <!-- community forum content -->
    <section>
        <a href="community_forum_1.php">Community Topics</a>
        <a href="community_forum_2_my_topics.php">My Topics</a>

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
    
    <?php include('community_forum_3_edit_my_post.php') ?>
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
							mypost.load_my_posts();
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
		load_my_posts: function(e){

			let form = new FormData();
 
            form.append('page_number', mypost.page_number);
			form.append('data_type', 'load_my_posts');
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
                                    template.querySelector(".js-delete-button").setAttribute('onclick',`mypost.delete(${obj.rows[i].forum_id})`);
                                    template.querySelector(".js-edit-button").setAttribute('onclick',`edit_post.show(${obj.rows[i].forum_id})`);

                                    template.querySelector(".js-username").innerHTML = (typeof obj.rows[i].user == 'object') ? obj.rows[i].user.user_fname : 'User';
                                    template.querySelector(".js-profile-link").href = (typeof obj.rows[i].user == 'object') ? 'profile.php?id='+obj.rows[i].user.user_id : '#';

                                    /*if(typeof obj.rows[i].user == 'object')
                                        template.querySelector(".js-image").src = obj.rows[i].user.image;*/

                                    let clone = template.cloneNode(true);

                                    clone.setAttribute('forum_id','post_'+obj.rows[i].forum_id);
                                    let row_data = JSON.stringify(obj.rows[i]);
								    row_data = row_data.replaceAll('"','\\"');
                                    clone.setAttribute('row',row_data);

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

		view_comments: function(id){

			window.location.href = "post.php?id="+id;
		},

        next_page: function(){ //dito iicrement si page
            mypost.page_number = mypost.page_number + 1;
            //mypost.load_my_posts();
            window.location.href = 'community_forum_2_my_topics.php?page=' + mypost.page_number;
        },

        prev_page: function(){
            mypost.page_number = mypost.page_number - 1;

            //pag bumaba less than 1, page 1 pa rin lalabas
            if (mypost.page_number < 1) {
                mypost.page_number = 1;
            }
            window.location.href = 'community_forum_2_my_topics.php?page=' + mypost.page_number;
            //mypost.load_my_posts();
        },

        delete: function(forum_id) {
            if (!confirm("Are you sure you want to delete this post?")) {
                alert(forum_id);
                return;
            }
            
            let form = new FormData(); //new form within javascript
 
			form.append('id', forum_id);
			form.append('data_type', 'delete_post');
			var ajax = new XMLHttpRequest();

			ajax.addEventListener('readystatechange',function(){

				if(ajax.readyState == 4)
				{
					if(ajax.status == 200){

						//console.log(ajax.responseText);
						let obj = JSON.parse(ajax.responseText);
						alert(obj.message);

						if(obj.success){
							mypost.load_my_posts();
						}
					}else{
						alert("Please check your internet connection");
					}
				}
			});

			ajax.open('post','ajax.php', true);
			ajax.send(form);
        }

	};

	mypost.load_my_posts(); //dito lumabas yung mga forum kasi tinatawag
</script>

</html>