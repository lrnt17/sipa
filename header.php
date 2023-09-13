<?php 
    defined('APP') or die('direct script access denied!'); 

    function getLogoPath() {
      $currentPage = basename($_SERVER['REQUEST_URI']);
      if ($currentPage === 'home_1_with_user.php') {
          return 'logo1.png';
      } else {
          return 'logo-colored.png';
      }
    }
?>

<head>
<link rel="stylesheet" href="main.css">
</head>
    <div class="con-nav py-3">
      <nav class="navbar navbar-expand-lg navbar-light mx-5">
            <a class="navbar-brand" href="#">
              <img class="rounded-circle" src="<?php echo getLogoPath(); ?>" alt="SiPa" width="55" height="55" >
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
              <ul class="navbar-nav">
                <li class="nav-item active mx-2">
                  <a class="js-link nav-link" href="home_1_with_user.php">Home <span class="sr-only"></span></a>
                </li>
                <li class="nav-item mx-2">
                  <a class="js-link nav-link" href="community-videos.php">Videos</a>
                </li>
                <li class="nav-item mx-2">
                  <a class="js-link nav-link" href="right_for_me_1.php">Right for me</a>
                </li>
                <li class="nav-item mx-2">
                  <a class="nav-link" href="faqs.php">FAQs</a>
                </li>
                <li class="nav-item dropdown mx-2">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Services
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="js-link dropdown-item" href="period_calcu.php">Period Calculator</a>
                      <a class="js-link dropdown-item" href="cost_calculator.php">Contraceptive Cost Calculator</a>
                      <a class="js-link dropdown-item" href="community-topics.php">Community Forum</a>
                      <a class="dropdown-item" href="about-std.php">About STDs</a>
                      <a class="js-link dropdown-item" href="comparison-chart.php">Contraception Method Comparison</a>
                      <a class="dropdown-item" href="#">Find a health care provider</a>
                      <!--<a class="dropdown-item" href="gmap.php">Contraceptive Reviews</a>-->
                  </div>
                </li>
                <li>
                <?php if(logged_in()):?>
                  <div class="row mt-2" style="align-items: center;">
                      <div class="col-auto">
                        <a class="js-link navbar-brand d-md-block d-lg-none" href="account_settings.php"><img class="border border-dark rounded-circle" src="<?= get_image($_SESSION['USER']['user_image'])?>" title="SiPa"  width="40" height="40;"></a>
                      </div>
                      <div class="col-auto">
                        <a class="js-link navbar-brand d-md-block d-lg-none" href="account_settings.php" style="display: inline;">
                            <span class="user-fname" style="font-size: 16px; color:#383838; font-weight:normal;"><?= $_SESSION['USER']['user_fname']?></span>
                        </a>

                      </div>
                    </div>
                  <?php else:?>
                    <div class="row mt-2" style="align-items: center;">
                      <div class="col-auto ms-2">
                        <i class="fa-solid fa-arrow-right-to-bracket d-md-block d-lg-none" style="cursor:pointer; font-size: 20px; color:white;" onclick="user.login()"></i>
                      </div>
                      <div class="col-auto">
                        <span class="js-link navbar-brand d-md-block d-lg-none" style="cursor:pointer; font-size: 17px; font-weight:normal; color:white;" onclick="user.login()">Sign in</span>
                      </div>
                    </div>
                  <?php endif;?>
                    
                </li>
              </ul>
            </div>
            <?php if(logged_in()):?>
                      <a class="js-link navbar-brand d-none d-lg-block d-lx-none" href="account_settings.php"><img class="border border-dark rounded-circle" src="<?= get_image($_SESSION['USER']['user_image'])?>" title="SiPa"  width="40" height="40;"></a>
                      <a class="js-link navbar-brand d-none d-lg-block d-lx-none" href="account_settings.php">
                          <span class="user-fname" style="font-size: 16px; font-weight:normal;">Hi, <?= $_SESSION['USER']['user_fname']?></span>

                      </a>
                  <?php else:?>
                      <span class="js-link navbar-brand d-none d-lg-block d-lx-none" style="cursor:pointer; font-size: 16px; font-weight:normal; color:white;" onclick="user.login()">Sign in</span>
                  <?php endif;?>
            
      </nav>
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

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
