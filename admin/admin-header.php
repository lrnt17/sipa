<?php 
    defined('APP') or die('direct script access denied!');
    $currentPage = basename($_SERVER['PHP_SELF']);
?>


<head>
<link rel="stylesheet" href="main.css">
<script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
</head>
<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  color: #414141;
}

:root {
  --blue: #2a2185;
  --gray: #f5f5f5;
  --black1: #222;
  --black2: #999;
}

body {
  min-height: 100vh;
  overflow-x: hidden;
}

.cont {
    height: 100%;
    position: fixed;
    width: auto;
}

/* =============== Navigation ================ */
.navigation {
  width: 280px;
  height: 100%;
  background: #D2E0F8;
  border-left: 5px solid #D2E0F8;
  transition: 0.5s;
  overflow: hidden;
}
.navigation.active {
  width: 80px;
}

.navigation ul {
    padding-left:15px;
    width: 100%;
}

.navigation ul li {
  position: relative;
  width: 100%;
  list-style: none;
  border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
}

.signout{
    position: relative;
    display: block;
    height: 60px;
    line-height: 60px;
    text-align: start;
    white-space: nowrap;
}

.admin{
    position: relative;
    display: block;
    white-space: nowrap;
}

.navigation ul li:hover,
.navigation ul li.hovered {
  background-color: #F2F5FF;
}

.li-1 {
  margin-bottom: 30px;
  pointer-events: none;
}

.navigation ul li a {
  position: relative;
  display: block;
  width: 100%;
  display: flex;
  text-decoration: none;
  color: var(--white);
}

.active-link{
    background: #F2F5FF;
    font-weight:500;
    color:black;
}

.active-link:hover{
    background: #F2F5FF;
    font-weight:500;
    color:black;
}

.navigation ul li a .icon {
  position: relative;
  display: block;
  min-width: 60px;
  height: 60px;
  line-height: 75px;
  text-align: center;
}
.navigation ul li a .icon ion-icon {
  font-size: 1.75rem;
}

.navigation ul li:hover a,
.navigation ul li.hovered a {
  font-weight:500;
}

.navigation ul li a .title {
  position: relative;
  display: block;
  padding: 0 10px;
  height: 60px;
  line-height: 60px;
  text-align: start;
  white-space: nowrap;
}

/* --------- curve outside ---------- 
.navigation ul li:hover a::before,
.navigation ul li.hovered a::before {
  content: "";
  position: absolute;
  right: 0;
  top: -50px;
  width: 50px;
  height: 50px;
  background-color: transparent;
  border-radius: 50%;
  box-shadow: 35px 35px 0 10px #F2F5FF;
  pointer-events: none;
}
.navigation ul li:hover a::after,
.navigation ul li.hovered a::after {
  content: "";
  position: absolute;
  right: 0;
  bottom: -50px;
  width: 50px;
  height: 50px;
  background-color: transparent;
  border-radius: 50%;
  box-shadow: 35px -35px 0 10px #F2F5FF;
  pointer-events: none;
}*/
    /* Main content */
    .main {
    position: absolute;
    width: calc(100% - 300px);
    left: 300px;
    min-height: 100vh;
    background: var(--white);
    transition: 0.5s;
    }
    .main.active {
    width: calc(100% - 100px);
    left: 100px;
    }

    .topbar {
    width: 100%;
    height: 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10px;
    position:fixed;
    background: #F2F5FF;
    z-index:1;
    }

    .toggle {
    font-size: 2rem;
    cursor: pointer;
    }


</style>
<section>
        <!-- =============== Navigation ================ -->
        <div class="cont">
        <div class="navigation">
            <ul>
                <li class="li-1">
                    <div class="mt-4" style="display: flex; align-items: center;">
                        <div class="col-auto"><img class="sipa-logo" src="sipa_logo.png" alt="SiPa" width="45" height="45" ></div>
                        <div class="col ms-4"><h3 class="title" style="margin: 0;">SiPa</h3></div>
                    </div>
                </li>

                <div class="admin">
                    <div class="mb-3" style="display: flex; align-items: center;">
                        <div class="col-auto" style="padding-right: 15px;">
                            <div class="img-con" style="width:50px; height:50px; border-radius:50%; border-style: solid; position: relative; overflow: hidden; padding: 0;"> 
                                <a href="admin-account-settings.php">
                                    <img src="<?= admin_get_image($_SESSION['USER']['user_image'])?>" title="Account Settings" class="rounded-circle class_28"  style=" width: 100%; height: 100%; object-fit: cover;" >
                                </a>
                            </div>
                        </div>

                        <div class="col-6">
                            <span style="font-size: 15px;font-weight: 500;">Hi, <?= $_SESSION['USER']['user_fname']?></span>
                            <?php if(check_head_admin($user_role)):?>
                                <p style="font-size: 13px;margin: 0;">Head Administrator</p>
                            <?php else:?>
                                <p style="font-size: 13px;margin: 0;">Administrator</p>
                            <?php endif;?>  
                        </div>
                        <div class="col-auto">
                            <a href="admin-account-settings.php"><i class="fa-solid fa-gear" style="font-size: 19px;color: 3A3A3A;"></i></a>
                        </div>
                    </div>
                    
                </div>

                <li <?php if ($currentPage === 'index.php') echo 'class="active-link"'; ?>>
                    <a href="index.php">
                        <i class="fa-solid fa-house me-3" style="margin-left: 20px;position: relative;margin-top: 20px;"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li <?php if ($currentPage === 'my-videos.php') echo 'class="active-link"'; ?>>
                    <a href="my-videos.php">
                        <i class="fa-solid fa-film me-3" style="margin-left: 20px;position: relative;margin-top: 22px;"></i>
                        <span class="title">Videos</span>
                    </a>
                </li>
                
                <li <?php if ($currentPage === 'appointment-list.php') echo 'class="active-link"'; ?>>
                    <a href="appointment-list.php">
                        <i class="fa-solid fa-clipboard-list me-3" style="margin-left: 21.5px;position: relative;margin-top: 20px;"></i>
                        <span class="title">Appointment List</span> 
                    </a>
                </li>

                <?php if(check_admin($user_role)):?>
                    <!--<li <?php //if ($currentPage === 'appointment-list.php') echo 'class="active-link"'; ?>>
                        <a href="appointment-list.php">
                            <i class="fa-solid fa-clipboard-list me-3" style="margin-left: 21.5px;position: relative;margin-top: 20px;"></i>
                            <span class="title">Appointment List</span> 
                        </a>
                    </li>-->

                    <li <?php if ($currentPage === 'schedule-settings.php') echo 'class="active-link"'; ?>>
                        <a href="schedule-settings.php">
                            <i class="fa-solid fa-calendar-day me-3" style="margin-left: 20px;position: relative;margin-top: 22px;"></i>
                            <span class="title">Schedule Settings</span>
                        </a>
                    </li>

                    <li <?php if ($currentPage === 'local-admins.php') echo 'class="active-link"'; ?>>
                        <a href="local-admins.php">
                            <i class="fa-solid fa-user-group me-3" style="margin-left: 20px;position: relative;margin-top: 22px;"></i>
                            <span class="title">Admin List (<?=$facility_name?>)</span>
                        </a>
                    </li>
                <?php endif;?>

                <?php if(check_head_admin($user_role)):?>
                    <!--<li <?php //if ($currentPage === '#about') echo 'class="active-link"'; ?>>
                        <a href="#about">
                            <i class="fa-solid fa-clipboard-list me-3" style="margin-left: 21.5px;position: relative;margin-top: 20px;"></i>
                            <span class="title">Head Administrators</span> 
                        </a>
                    </li>

                    <li <?php //if ($currentPage === 'manage-admins.php') echo 'class="active-link"'; ?>>
                        <a href="manage-admins.php">
                            <i class="fa-solid fa-calendar-day me-3" style="margin-left: 20px;position: relative;margin-top: 22px;"></i>
                            <span class="title">Administrators</span>
                        </a>
                    </li>-->

                    <li class="dropdown" <?php if (in_array($currentPage, ['#head-admin', 'manage-admins.php'])) {echo 'class="active-link"';} ?>>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="align-items: center;">
                            <i class="fa-solid fa-clipboard-list me-3" style="margin-left: 21.5px;position: relative;"></i>
                            <span class="title">Users</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Head Administrators</a>
                            </li>
                            <li style="margin: 0px; cursor: pointer;">
                                <a href="manage-admins.php">Administrators</a>
                            </li>
                        </ul>
                    </li>

                    <li <?php if ($currentPage === 'partner-facilities.php') echo 'class="active-link"'; ?>>
                        <a href="partner-facilities.php">
                            <i class="fa-solid fa-user-group me-3" style="margin-left: 20px;position: relative;margin-top: 22px;"></i>
                            <span class="title">Partner Facilities</span>
                        </a>
                    </li>

                    <li class="dropdown" <?php if (in_array($currentPage, ['contraceptive-sidebyside.php', 'contraceptive-details.php', 'contraceptive-chart.php'])) {echo 'class="active-link"';} ?>>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="align-items: center;">
                            <i class="fa-solid fa-clipboard-list me-3" style="margin-left: 21.5px;position: relative;"></i>
                            <span class="title">Contraceptives</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Contraceptive Methods</a>
                            </li>
                            <li style="margin: 0px; cursor: pointer;">
                                <a href="contraceptive-details.php">Contraceptive Details</a>
                            </li>
                            <li>
                                <a href="contraceptive-chart.php">Contraceptive Chart</a>
                            </li>
                            <li>
                                <a href="contraceptive-sidebyside.php">Contraceptive Side-by-Side</a>
                            </li>
                        </ul>
                    </li>
                <?php endif;?>
                    
                <div class="signout ms-2" style="">
                    <a href="#" onclick="admin.logout()" style="text-decoration:none;">
                        <i class="fa-solid fa-right-from-bracket me-3" style="font-size: 22px; margin-left: 13px;position: relative;"></i>
                        <span class="title">Sign Out</span>
                    </a>
                </div>
            </ul>
        </div>
</section>

<script>
    // JavaScript to add the "active" class to the clicked link
    const navigationLinks = document.querySelectorAll('.navigation ul li');
    
    navigationLinks.forEach(link => {
        link.addEventListener('click', () => {
            // Remove "active" class from all links
            navigationLinks.forEach(l => l.classList.remove('active-link'));
            
            // Add "active" class to the clicked link
            link.classList.add('active-link');
        });
    });

    var admin = {

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

                    window.location.href = "../login_1.php";
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','../ajax.php', true);
        ajax.send(form);
    },
    }
    
</script>




<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
