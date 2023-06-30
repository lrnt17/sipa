<?php defined('APP') or die('direct script access denied!'); ?>

<div class="js-edit-post-modal class_55 hide" > <!-- ito yung hide na tinutukoy ko sa baba-->
	<!--<div class="class_39" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="my_edit_post.hide()">X</div>-->
	<h1 class="class_27"  >
		Edit Post
	</h1>
	<form onsubmit="my_edit_post.submit(event)" method="post" class="class_42" >
        <div class="">
            <input type="text" placeholder="Title" name="post_title" id="post_title" class="js-edit-title">
        </div>
        <div class="class_43" >
            <textarea placeholder="Whats on your mind?" name="post" class="js-edit-post class_44" ></textarea>
        </div>
        
        <div class="class_45" >
            <button class="class_46"  >
                Save
            </button>
        </div>
	</form>
	<div onclick="my_edit_post.hide()" type="button" class="class_39" style="cursor:pointer;" >
		Cancel
	</div>
	<!-- 
		I just discovered na kapag halimbawa clinick mo si edit button sa isang post, lets say
		pang apat na post. Ede lalabas yung edit post. Tapos kapag naman sinilect mo yung cancel
		button (na instead of <button> tag, <div> tag ang ginamit), babalik ka pa din sa tapat 
		ng pang apat na post, kung saan mo pinindot yung edit link. Kapag kasi <button> tag, 
		babalik ka pa rin naman, ang kaso sa pinakataas na (sa may navbar) 

		pero kapag submit button sa loob ng <form> element, <button> tag ang gagamitin
	
	-->
</div>

<script>
	
	var my_edit_post = {
		
		edit_id: 0,

		show_me: function(id){
			
			my_edit_post.edit_id = id;

			let data = document.querySelector("#post_"+id).getAttribute("row");
			data = data.replaceAll('\\"','"');
			data = JSON.parse(data);

			if(typeof data == 'object')
			{
				document.querySelector(".js-edit-title").value = data.forum_title;
				document.querySelector(".js-edit-post").value = data.forum_desc;
			}else{
				alert("Invalid post data");
			}
			//tinatanggal si hide sa classlist para makita si login
			document.querySelector(".js-edit-post-modal").classList.remove('hide');
			document.querySelector(".js-personal-post").classList.add('hide');
            //document.querySelector(".js-modification-buttons").classList.add('hide');
			//inaadd si hide sa class para di makita si signup
			//document.querySelector(".js-signup-modal").classList.add('hide');
		},
		
		//pag pinakita si signup, tinatago si login
		hide: function(){
			document.querySelector(".js-edit-post-modal").classList.add('hide');
			document.querySelector(".js-personal-post").classList.remove('hide');
		},

		submit: function(e){

			e.preventDefault();
			let post = document.querySelector(".js-edit-post").value.trim();
			let title = document.querySelector(".js-edit-title").value
			let form = new FormData();

			form.append('id', my_edit_post.edit_id);
			form.append('post', post);
			form.append('post_title', title);
			form.append('data_type', 'my_edit_post');
			
			var ajax = new XMLHttpRequest();

			ajax.addEventListener('readystatechange',function(){

				if(ajax.readyState == 4)
				{
					if(ajax.status == 200){

						//ganto daw iconvert si JSON back to javascript
						console.log(ajax.responseText);
						let obj = JSON.parse(ajax.responseText);
						alert(obj.message); //nasa ajax.php yung .message

						if(obj.success)//nasa ajax.php yung .sucess
							window.location.reload();
							
					}else{
						alert("Please check your internet connection");
					}
				}
			});

			ajax.open('post','ajax.php', true);
			ajax.send(form);
		},


	};

</script>