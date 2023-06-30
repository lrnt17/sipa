<?php defined('APP') or die('direct script access denied!'); ?>

<div class="js-edit-comment-modal class_55 hide" > <!-- ito yung hide na tinutukoy ko sa baba-->
	<!--<div class="class_39" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="my_edit_comment.hide()">X</div>-->
	<h1 class="class_27"  >
		Edit Comment
	</h1>
	<form onsubmit="my_edit_comment.submit(event)" method="post" class="class_42" >
        <div class="class_43" >
            <textarea placeholder="Edit your comment" name="post" class="js-edit-comment class_44" ></textarea>
        </div>
        
        <div class="class_45" >
            <button class="class_46"  >
                Save
            </button>
        </div>
	</form>
	<div onclick="my_edit_comment.hide()" type="button" class="class_39" style="cursor:pointer;" >
		Cancel
	</div>
</div>

<script>
	
	var my_edit_comment = {
		
		edit_id: 0,

		show_me: function(id){
			
			my_edit_comment.edit_id = id;

			let data = document.querySelector("#post_"+id).getAttribute("row");
			data = data.replaceAll('\\"','"');
			data = JSON.parse(data);

			if(typeof data == 'object')
			{
				document.querySelector(".js-edit-comment").value = data.forum_desc;
			}else{
				alert("Invalid comment data");
			}
			//tinatanggal si hide sa classlist para makita si login
			document.querySelector(".js-edit-comment-modal").classList.remove('hide');
			document.querySelector(".js-personal-post").classList.add('hide');
            //document.querySelector(".js-modification-buttons").classList.add('hide');
			//inaadd si hide sa class para di makita si signup
			//document.querySelector(".js-signup-modal").classList.add('hide');
		},
		
		//pag pinakita si signup, tinatago si login
		hide: function(){
			document.querySelector(".js-edit-comment-modal").classList.add('hide');
			document.querySelector(".js-personal-post").classList.remove('hide');
		},

		submit: function(e){

			e.preventDefault();
			let post = document.querySelector(".js-edit-comment").value.trim();
			let form = new FormData();

			form.append('id', my_edit_comment.edit_id);
			form.append('post', post);
			form.append('data_type', 'my_edit_comment');
			
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