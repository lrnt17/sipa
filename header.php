<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<header>
    <div>
        <!-- SiPa logo -->
        <div>
            <img src="logo1.png" alt="SiPa" style="width: 50px; height: 50px;">
        </div>
        <!-- hamburger button sya, parang 3 horizontal lines na patong patong  -->
		<!--<div  class="item_class_1 class_6">
			<svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
				<path d="m22 16.75c0-.414-.336-.75-.75-.75h-18.5c-.414 0-.75.336-.75.75s.336.75.75.75h18.5c.414 0 .75-.336.75-.75zm0-5c0-.414-.336-.75-.75-.75h-18.5c-.414 0-.75.336-.75.75s.336.75.75.75h18.5c.414 0 .75-.336.75-.75zm0-5c0-.414-.336-.75-.75-.75h-18.5c-.414 0-.75.336-.75.75s.336.75.75.75h18.5c.414 0 .75-.336.75-.75z" fill-rule="nonzero" >
				</path>
			</svg>
		</div>-->
        <!-- mga links  -->
        <div>
			<a href="home_1_with_user.php">Home</a>
            <a href="#">Videos</a>
            <a href="#">Right for me</a>
            <a href="#">FAQs</a>
            <a href="#" onclick="user.toggleDropdown()">Services</a>
            <!-- pag clinick si "Services" na link, lalabas tong dropdown  -->
            <div id="dropdown" style="display: none;">
                <a href="#">Period Calculator</a><br>
                <a href="#">Contraceptive Cost Calculator</a><br>
                <a href="community_forum_1.php">Community Forum</a><br>
                <a href="#">About STDs</a><br>
                <a href="#">Contraception Method Comparison</a><br>
                <a href="#">Find a health care provider</a><br>
                <a href="#">Contraceptive Reviews</a><br>
            </div>
            <div>
                <?php if(logged_in()):?>
                    <a href="account_settings.php"><img src="<?= get_image($_SESSION['USER']['user_image'])?>" title="SiPa"></a>
                    <a href="account_settings.php">
                        <span>Hi, <?= $_SESSION['USER']['user_fname']?></span>
                    </a>
                <?php else:?>
                    <span style="cursor:pointer;" onclick="user.login()">Sign in</span>
                <?php endif;?>
            </div>
		</div>
	</div>
</header>

<script>
	
	var user = {

		logout: function(){

			let form = new FormData();
			form.append('data_type', 'logout');
			var ajax = new XMLHttpRequest();

			ajax.addEventListener('readystatechange',function(){

				if(ajax.readyState == 4)
				{
					if(ajax.status == 200){
						let obj = JSON.parse(ajax.responseText);
						alert(obj.message);

						window.location.href = "login_1.php";
					}else{
						alert("Please check your internet connection");
					}
				}
			});

			ajax.open('post','ajax.php', true);
			ajax.send(form);
		},

        toggleDropdown: function(){

            var dropdown = document.getElementById("dropdown");

            if (dropdown.style.display === "none") {
                dropdown.style.display = "block";
            } else {
                dropdown.style.display = "none";
            }
        },

        login: function(){

            window.location.href = "login_1.php";
        }
	};
</script>
