<?php 
    require("connect.php");
    require('functions.php');

    if(!logged_in()){
		header("Location: admin-login.php");
		die;
	}

    $emp_num = $_SESSION['USER']['admin_empnum'];

    //...

    $query = "select * from admin where admin_empnum = '$emp_num' limit 1";
	$row = query($query);

	if($row)
	{
		$row = $row[0];
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPa <?=$row['specialization'] ?> | Siguradong Pagpipilian</title>
</head>
<style>
        @keyframes appear{
			0%{
				opacity: 0;
			}
			100%{
				opacity: 1;
			}
		}

		.hide{
			display:none;
		}

        .bold{
            font-weight: 900;
        }
    </style>
<body>
    <h1>SiPa Administrator</h1>
    <br>
    <h2><?=$row['admin_fullname'] ?></h2>
    <h3><?=$row['specialization'] ?></h3>
    <br>
    <div class="js-admin-main">
        <div onclick="admin.show('.js-access-request-modal', '.js-acc-req')" class="js-admin class_15" style="cursor:pointer;" >
            <p class="js-acc-req bold">Access Requests</p>
        </div>
        <div onclick="admin.show('.js-users-modal', '.js-users')" class="js-admin class_15" style="cursor:pointer;" >
            <p class="js-users">Users</p>
        </div>
        <div onclick="admin.show('.js-registration-modal', '.js-reg')" class="js-admin class_15" style="cursor:pointer;" >
            <p class="js-reg">Registration</p>
        </div>
        <?php if(head_admin($row['admin_empnum'])):?>
            <div onclick="admin.show('.js-mange-admin-modal', '.js-mange-admin')" class="js-admin" style="cursor:pointer;" >
                <p class="js-mange-admin">Manage Administrators</p>
            </div>
            <div onclick="admin.show('.js-mange-contraceptives-modal', '.js-mange-contra')" class="js-admin" style="cursor:pointer;" >
                <p class="js-mange-contra">Manage Contraceptives</p>
            </div>
        <?php endif;?>
        <div>---------------------------------------------------------------------------------------------</div>
    </div>

    <?php include('admin-access-request.php');?>
    <?php include('admin-users.php');?>
    <?php include('admin-registration.php');?>
    <?php include('admin-mange-admin.php');?>
    <?php include('admin-mange-contraceptives.php');?>
</body>
<script>
    var admin = {
 
        show: function(modalClass, linkClass) {
            // Hide all modals
            document.querySelector(".js-access-request-modal").classList.add('hide');
            document.querySelector(".js-users-modal").classList.add('hide');
            document.querySelector(".js-registration-modal").classList.add('hide');

            let jsMangeAdminModal = document.querySelector(".js-mange-admin-modal");
            let jsMangeContraceptivesModal = document.querySelector(".js-mange-contraceptives-modal");
            if (jsMangeAdminModal) {
                jsMangeAdminModal.classList.add('hide');
            } 
            if (jsMangeContraceptivesModal) {
                jsMangeContraceptivesModal.classList.add('hide');
            }

            // Remove bold class from all links
            document.querySelector(".js-acc-req").classList.remove('bold');
            document.querySelector(".js-users").classList.remove('bold');
            document.querySelector(".js-reg").classList.remove('bold');
            
            let jsMangeAdmin = document.querySelector(".js-mange-admin");
            let jsMangeContraceptives = document.querySelector(".js-mange-contra");
            if (jsMangeAdmin) {
                jsMangeAdmin.classList.remove('bold');
            } 
            if (jsMangeContraceptives) {
                jsMangeContraceptives.classList.remove('bold');
            }

            // Show the specified modal
            document.querySelector(modalClass).classList.remove('hide');

            // Add bold class to the specified link
            document.querySelector(linkClass).classList.add('bold');
        },

    };
</script>
</html>