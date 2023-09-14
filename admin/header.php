<?php 
    defined('APP') or die('direct script access denied!');
    
    $user_role = $_SESSION['USER']['user_role'];
    $user_fname = $_SESSION['USER']['user_fname'];
?>
<section>
    <div class="sidenav">
        <h1 style="color:white;">SiPa</h1>
        <a href="index.php">Dashboard</a>
        <a href="appointment-list.php">Appointment List</a>
        <a href="schedule-settings.php">Schedule Settings</a>
        <a href="#contact">Contact</a>
        <button class="dropdown-btn">Dropdown 
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="#">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
        </div>
        <?php if(check_head_admin($user_role)):?>
            <a href="#about">Head Administrators</a>
            <a href="manage-admins.php">Administrators</a>
            <button class="dropdown-btn">Contraceptives 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="#">Contraceptive Methods</a>
                <a href="contraceptive-details.php">Contraceptive Details</a>
                <a href="contraceptive-chart.php">Contraceptive Chart</a>
            </div>
        <?php endif;?>
        <button class="dropdown-btn">
            Administrator
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