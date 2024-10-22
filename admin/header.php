<?php 
    defined('APP') or die('direct script access denied!');
    
    /*if(!logged_in()){
		header("Location: ../login_1.php");
		die;
	}
    
    $user_id = $_SESSION['USER']['user_id'];

    $query = "select * from users where user_id = '$user_id' limit 1";
	$row = query($query);

	if($row)
	{
		$row = $row[0];
        $user_fname = $row['user_fname'];
        $id = $row['partner_facility_id'];
        $user_role = $row['user_role'];

        $query = "select * from partner_facility where partner_facility_id = '$id' limit 1";
        $user_row = query($query);

        if ($user_row) {
            $user_row = $user_row[0];
            $partner_facility_id = $user_row['partner_facility_id'];
            $city = $user_row['city_municipality'];
            $facility_name = $user_row['health_facility_name'];
        }
	}*/
?>
<section>
    <div class="sidenav">
        <h1 style="color:white;">SiPa</h1>
        <a href="index.php">Dashboard</a>
        <a href="my-videos.php">Videos</a>
        <?php if(check_admin($user_role)):?>
            <a href="appointment-list.php">Appointment List</a>
            <a href="schedule-settings.php">Schedule Settings</a>
            <a href="local-admins.php">Admin List (<?=$facility_name?>)</a>
        <?php endif;?>
        <!--<button class="dropdown-btn">Dropdown 
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="#">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
        </div>-->
        <?php if(check_head_admin($user_role)):?>
            <a href="#about">Head Administrators</a>
            <a href="manage-admins.php">Administrators</a>
            <a href="partner-facilities.php">Partner Facilities</a>
            <button class="dropdown-btn">Contraceptives 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="#">Contraceptive Methods</a>
                <a href="contraceptive-details.php">Contraceptive Details</a>
                <a href="contraceptive-chart.php">Contraceptive Chart</a>
                <a href="contraceptive-sidebyside.php">Contraceptive Side-by-Side</a>
            </div>
        <?php endif;?>
        <button class="dropdown-btn">
            <?php if(check_head_admin($user_role)):?>
                Head Administrator
            <?php else:?>
                Administrator
            <?php endif;?>  
            <img src="<?= admin_get_image($_SESSION['USER']['user_image'])?>" title="SiPa" width="25" height="25">
            <span>Hi, <?= $_SESSION['USER']['user_fname']?></span>
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="admin-account-settings.php">Account Settings</a>
            <a href="#" onclick="admin.logout()">Log out</a>
        </div>
        
    </div>
</section>

<script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
            } else {
            dropdownContent.style.display = "block";
            }
        });
    }

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
    };
</script>