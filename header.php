<?php 
    defined('APP') or die('direct script access denied!'); 
?>
<head>
<link rel="stylesheet" href="main.css">
</head>
<header>
<<<<<<< HEAD
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
			<a href="home_1_with_user.php" class="js-link">Home</a>
            <a href="#">Videos</a>
            <a href="#">Right for me</a>
            <a href="#">FAQs</a>
            <a href="#" onclick="user.toggleDropdown()">Services</a>
            <!-- pag clinick si "Services" na link, lalabas tong dropdown  -->
            <div id="dropdown" style="display: none;">
                <a href="#">Period Calculator</a><br>
                <a href="contraceptive-cost-calcu.php" class="js-link">Contraceptive Cost Calculator</a><br>
                <a href="community-topics.php" class="js-link">Community Forum</a><br>
                <a href="#">About STDs</a><br>
                <a href="#">Contraception Method Comparison</a><br>
                <a href="#">Find a health care provider</a><br>
                <a href="#">Contraceptive Reviews</a><br>
            </div>
            <div>
                <?php if(logged_in()):?>
                    <a href="account_settings.php" class="js-link"><img src="<?= get_image($_SESSION['USER']['user_image'])?>" title="SiPa"></a>
                    <a href="account_settings.php" class="js-link">
                        <span>Hi, <?= $_SESSION['USER']['user_fname']?></span>
=======
    <nav class="navbar navbar-expand-lg navbar-light mx-5 my-3">
          <a class="navbar-brand" href="#">
            <img class="rounded-circle" src="logo-colored.png" alt="SiPa" width="55" height="55" >
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item active mx-2">
                <a class="nav-link" href="home_1_with_user.php">Home <span class="sr-only"></span></a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="#">Videos</a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="#">Right for me</a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="#">FAQs</a>
              </li>
              <li class="nav-item dropdown mx-2">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Services
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Period Calculator</a>
                    <a class="dropdown-item" href="#">Contraceptive Cost Calculator</a>
                    <a class="dropdown-item" href="community_forum_1.php">Community Forum</a>
                    <a class="dropdown-item" href="#">About STDs</a>
                    <a class="dropdown-item" href="#">Contraception Method Comparison</a>
                    <a class="dropdown-item" href="#">Find a health care provider</a>
                    <a class="dropdown-item" href="#">Contraceptive Reviews</a>
                </div>
              </li>
              <li>
                    <a class="navbar-brand d-none d-md-block d-lg-none" href="account_settings.php"><img class="border border-dark rounded-circle" src="<?= get_image($_SESSION['USER']['user_image'])?>" title="SiPa"  width="40" height="40;"></a>
              </li>
            </ul>
          </div>
          <?php if(logged_in()):?>
                    <a class="navbar-brand d-none d-lg-block d-lx-none" href="account_settings.php"><img class="border border-dark rounded-circle" src="<?= get_image($_SESSION['USER']['user_image'])?>" title="SiPa"  width="40" height="40;"></a>
                    <a class="navbar-brand d-none d-lg-block d-lx-none" href="account_settings.php">
                        <span style="font-size: 16px;">Hi, <?= $_SESSION['USER']['user_fname']?></span>
>>>>>>> 5fb6c14 (css changes, bootstrap)
                    </a>
                <?php else:?>
                    <span style="cursor:pointer; font-size: 16px;" onclick="user.login()">Sign in</span>
                <?php endif;?>
          
        </nav>

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

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
