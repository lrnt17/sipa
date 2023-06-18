<?php defined('APP') or die('direct script access denied!'); ?>

<div class="js-edit-post class_55 hide" > <!-- ito yung hide na tinutukoy ko sa baba-->
	<div class="class_39" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="edit_post.hide()">X</div>
	<h1 class="class_27"  >
		Edit Post
	</h1>
	<form onsubmit="edit_post.submit(event)" method="post" class="class_42" >
        <div class="">
            <input type="text" placeholder="Title" name="post_title" id="post_title" class="js-post-title">
        </div>
        <div class="class_43" >
            <textarea placeholder="Whats on your mind?" name="post" class="js-post-input class_44" ></textarea>
        </div>
        
        <div class="class_45" >
            <button class="class_46"  >
                Save
            </button>
        </div>
	</form>
</div>

<script>
	
	var edit_post = {
 
		show: function(){
			//tinatanggal si hide sa classlist para makita si login
			document.querySelector(".js-edit-post").classList.remove('hide');
            document.querySelector(".js-modification-buttons").classList.add('hide');
			//inaadd si hide sa class para di makita si signup
			//document.querySelector(".js-signup-modal").classList.add('hide');
		},
		
		//pag pinakita si signup, tinatago si login
		hide: function(){
			document.querySelector(".js-edit-post").classList.add('hide');
		},

		submit: function(e){

			e.preventDefault();
			let inputs = e.currentTarget.querySelectorAll("input");
			let form = new FormData();

			for (var i = inputs.length - 1; i >= 0; i--) {
				form.append(inputs[i].name, inputs[i].value);
			}
			
			form.append('data_type', 'login');
			
			var ajax = new XMLHttpRequest();

			ajax.addEventListener('readystatechange',function(){

				if(ajax.readyState == 4)
				{
					if(ajax.status == 200){

						//ganto daw iconvert si JSON back to javascript
						let obj = JSON.parse(ajax.responseText);
						alert(obj.message); //nasa ajax.php yung .message

						if(obj.success)//nasa ajax.php yung .sucess
							alert();
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