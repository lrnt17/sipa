<?php 
    require("connect.php");
    require('functions.php');
    
    if(!logged_in()){
		header("Location: home_1_with_user.php");
		die;
	}

    include('header.php');
    
    $user_id = $_SESSION['USER']['user_id'];
    $user_sex = $_SESSION['USER']['user_sex'];
    //$user_password = $_SESSION['USER']['user_password'];
    //echo $user_password;
    //echo $user_id;
    $query = "select * from users where user_id = '$user_id' limit 1";
	$row = query($query);

	if($row)
	{
		$row = $row[0];
	}

    //update if statement
    if($_SERVER['REQUEST_METHOD'] == "POST")
	{

		//update
		$errors = [];
		$userfname 	    = addslashes($_POST['userfname']);
        $userlname      = addslashes($_POST['userlname']);
        $useraddress 	= addslashes($_POST['address']);
        $userbarangay 	= addslashes($_POST['barangay']);
		$email 		    = addslashes($_POST['email']);
		$dob 		    = $_POST['dob'];
		$sex 		    = $_POST['sex'];
		$pnum 		    = addslashes($_POST['pnum']);
		
		/*if(!empty($_POST['password']))
		{
			if($_POST['password'] !== $_POST['retype_password'])
			{
				$errors['password'] = "Passwords do not match";
			}

			//$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $password = ($_POST['password'], PASSWORD_DEFAULT);
		}*/

        /*if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
            // Check if the current password matches the one in the database
            $stmt = $pdo->prepare('SELECT password FROM users WHERE id = ?');
            $stmt->execute([$_SESSION['id']]);
            $user = $stmt->fetch();
            if (password_verify($_POST['current_password'], $user['password'])) {
                // Check if the new password and retype password match
                if ($_POST['new_password'] !== $_POST['retype_password']) {
                    $errors['password'] = "New passwords do not match";
                } else {
                    // Update the password in the database
                    $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
                    $stmt->execute([$password, $_SESSION['id']]);
                    
                    // Log out the user and redirect to login page
                    session_destroy();
                    header('Location: login.php');
                }
            } else {
                $errors['current_password'] = "Current password is incorrect";
            }
        }*/

        if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
            //if ($_POST['current_password'] == $user_password) {
            if (password_verify($_POST['current_password'], $row['user_password'])) {
                
                // Check if the new password and retype password match
                if ($_POST['new_password'] !== $_POST['retype_password']) {
                    $errors['password'] = "New passwords do not match";
                } else {
                    // Update the password in the database
                    //$password = $_POST['new_password'];
                    $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                    
                    // Log out the user and redirect to login page
                    //session_destroy();
                    //header('Location: login_1.php');
                }
            } else {
                $errors['current_password'] = "Current password is incorrect";
            }
        }

		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$errors['email'] = "Email is not valid";
		}


		if(!preg_match("/^[a-zA-Z ]+$/", $userfname))
		{
			$errors['userfname'] = "First name cant have numbers";
		}

        if(!preg_match("/^[a-zA-Z ]+$/", $userlname))
		{
			$errors['userlname'] = "Last name cant have numbers";
		}

		//upload image
		if(!empty($_FILES['image']['name']))
		{
			$allowed = ['image/jpeg','image/png','image/webp'];
			if(!in_array($_FILES['image']['type'], $allowed)){
				$errors['image'] = "Image type not supported";
			}else{

				$folder = "uploads/";
				if(!file_exists($folder)){
					mkdir($folder,0777,true);
				}

				//$image = $folder . $_FILES['image']['name'];
                // Sanitize the filename
                $filename = preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['image']['name']);

                $image = $folder . $filename;
				
			}

		}

		if(empty($errors))
		{

			$image_string = "";
			if(!empty($image)){
				$image_string = ", user_image = '$image' ";
				move_uploaded_file($_FILES['image']['tmp_name'], $image);
			}

			$password_string = "";
			if(!empty($password))
				$password_string = ", user_password = '$password' ";
			

			$query = "update users set user_fname = '$userfname', user_lname = '$userlname', user_dob = '$dob', user_sex = '$sex', user_email = '$email', user_address = '$useraddress', user_barangay = '$userbarangay' $image_string $password_string where user_id = '$user_id' limit 1";
			query($query);
			
			$query = "select * from users where user_id = '$user_id' limit 1";
			$row = query($query);

			if($row)
			{
				authenticate($row[0]);
			}

            if(!empty($password)) {
                echo "<script>
                            alert('Your password details successfully updated'); 
                            user.logout(); 
                      </script>";
            }else{
                echo "<script>
                            alert('Your account details successfully updated');
                            window.location.href='account_settings.php';
                      </script>";
            }
            			
			die;
		}
	}

	/*$query = "select * from users where user_id = '$user_id' limit 1";
	$row = query($query);

	if($row)
	{
		$row = $row[0];
	}*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>Account Settings | SiPa</title>

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
            font-weight: 700;
        }

        .text-desc-a{
            font-size: 13px;
            color: #575757;
            width:80%;
            word-wrap: break-word;
            white-space: normal
        }

        .class_311{
            display:flex;
            align-items: center;
        }
        .class_312{
            width: 100%;
            margin: 0px 30px 0px 0px;
        }

        .class_31{
            margin-top: 10px;
        }

        .class_33{
            width: 100%;
            padding: 0px 0px 2px 0px;
            border: none;
            border-bottom: 2.2px solid #B9B9B9;
            font-size: 15px;
            outline: none;
            margin: 10px 30px 15px 0px;
        }
    </style>
</head>
<body style="background: #F2F5FF;">
<?php //include('header.php'); ?>
<div class="parent">
    <div class="container">
    <!--<section>-->

        <!-- your account -->
        <div class="parent text-left py-4 col-lg-10 col-md-15">
        <div class="container d-lg-flex flex-row d-md-block" style="min-height: 550px;">
        <div class="rounded-start-5 p-5 shadow-sm rounded col-xxl-4 col-xl-5 col-lg-6 col-sm-fluid" style="background: #D2E0F8;">
            <h2 style="color: #2F2F2F;
            font-weight: 500;">Your Account</h2>
            <p class ="text-desc d-none md-none d-lg-block" style="font-size: 14px; color: #575757; width:100%;
            word-wrap: break-word; white-space: normal; position: relative; top: -5px;">See information about your account, password, or about your account deletion.</p>

        
            <div class="row row-cols-6 gx-10 row-cols-lg-1 d-m-fluid" style="justify-content: space-between;">
            
                <div class="col-lg-12">
                    <div onclick="account.show('.js-account-info-modal', '.js-acc-info')" class="js-settings class_15 row" style="cursor:pointer;" >
                        <div class="col-2"><i class="fa-solid fa-user" style="font-size:20px;"></i> </div>
                        <div class="col d-none md-none d-lg-block"> <p class="js-acc-info bold" style="display: inline;">Account information</p></div>
                    </div>
                    <div class="row">
                        <div class="col-2"> </div>
                        <div class="col d-none md-none d-lg-block"><p class ="text-desc-a">See your account information like your name and email address.</p></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div onclick="account.show('.js-change-password-modal', '.js-cha-pass')" class="js-settings class_15 row" style="cursor:pointer;" >
                        <div class="col-2 "><i class="fa-solid fa-lock" style="font-size:20px;"></i></div>
                        <div class="col d-none md-none d-lg-block"><p class="js-cha-pass" style="display:inline">Change your password</p></div>
                    </div>
                    <div class="row">
                        <div class="col-2"> </div>
                        <div class="col d-none md-none d-lg-block"><p class ="text-desc-a">Change your password anytime.</p></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div onclick="account.show('.js-view-saved-method-modal', '.js-saved-met')" class="js-settings class_15 row" style="cursor:pointer;" >
                        <div class="col-2 "><i class="fa-solid fa-pills" style="font-size:20px;"></i> </div>
                        <div class="col d-none md-none d-lg-block"><p class="js-saved-met" style="display:inline">Saved Contraceptive Method</p></div>
                    </div>
                    <div class="row">
                        <div class="col-2"> </div>
                        <div class="col d-none md-none d-lg-block"><p class ="text-desc-a">Manage saved contraception or unsubscribe to SMS.</p></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div onclick="account.show('.js-delete-account-modal', '.js-del-acc')" class="js-settings class_15 row" style="cursor:pointer;" >
                        <div class="col-2 "><i class="fa-solid fa-heart-crack" style="font-size:20px;"></i> </div>
                        <div class="col d-none md-none d-lg-block"><p class="js-del-acc" style="display:inline">Delete your account</p></div>
                    </div>
                    <div class="row">
                        <div class="col-2"> </div>
                        <div class="col d-none md-none d-lg-block"><p class ="text-desc-a">Deletion of your account.</p></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row" style="align-items: center;">
                        <div class="col-2"><i class="fa-solid fa-arrow-right-from-bracket" onclick="user.logout()" style="font-size:20px; cursor: pointer;"></i></div>
                        <div class="col d-none md-none d-lg-block"><button onclick="user.logout()" class="class_39 btn btn-link" style="text-decoration: none; color:black;"  >
                            Logout
                        </button></div>
                    </div>
                </div>

               
            </div>

        </div>

        <!-- your account end-->
        
        <?php if(!empty($errors)):?>
            <!--<div class="" >
                <i class="">
                </i>
                <div class=""  >
                    <?//=implode("<br>", $errors)?>
                </div>
            </div>-->
            <script>
                alert("<?=implode('/n', $errors)?>");
            </script>
        <?php endif;?>
        


   <!-- </section>-->
    
    <?php if(!empty($row)):?>
        <div class="conclass_26  p-5 rounded-end-5 shadow-sm rounded 
        col-xxl-8 col-xl-9 col-lg-9 col-sm-fluid" style="min-height: 550px; background-color: #ffff;">
            <form method="post" enctype="multipart/form-data" style="margin: 0;">
                <!-- account information modal -->
                    <div class="js-account-info-modal">
                        <h2 style="color: #2F2F2F;
                        font-weight: 500;">Account information</h2>
                        <label>
                            <div class="img-con" style="width:50px; height:50px; border-radius:50%; border-style: solid; position: relative; overflow: hidden; padding: 0;"> 
                                <img src="<?=get_image($row['user_image'])?>" class="js-input-image class_28"  style=" width: 100%; height: 100%; object-fit: cover; cursor: pointer;" >
                            </div>
                            <input onchange="display_image(this.files[0])" type="file" name="image" class="class_29" style="display:none;">

                            <script>
                                
                                function display_image(file)
                                {
                                    let allowed = ['image/jpeg','image/png','image/webp'];

                                    if(!allowed.includes(file.type)){
                                        alert("That file type is not allowed!");
                                        return;
                                    }

                                    let img = document.querySelector(".js-input-image");
                                    console.log(img);
                                    console.log(file);
                                    img.src = URL.createObjectURL(file);
                                }
                            </script>
                        </label>

                        <div class="class_30" >
                            <div class="class_31">
                                <label >
                                    Name
                                </label>
                            <div class="class_311" >
                                <input value="<?=$row['user_fname']?>" placeholder="First Name" type="text" name="userfname" class="class_33" max="30" required="true">
                                <input value="<?=$row['user_lname']?>" placeholder="Last Name" type="text" name="userlname" class="class_33" max="30" required="true">
                            </div>
                            </div>
                            <div class="class_31" >
                                <label >
                                    Address
                                </label><br>
                                <input value="<?=$row['user_address']?>" placeholder="Address" type="text" name="address" class="class_33" max="100" required="true">
                            </div>
                            <div class="class_31" >
                                <label >
                                    Email
                                </label><br>
                                <input value="<?=$row['user_email']?>" placeholder="Email" type="text" name="email" class="class_33"  required="true">
                            </div>
                            <div class="row class_311" >
                                <div class="col-sm-4">
                                    <label class="class_312"  >
                                        Date of Birth
                                    </label>
                                    <div class="class_312 mb-2" >
                                        <input value="<?=$row['user_dob']?>" placeholder="Email" type="date" name="dob" class="class_33"  disabled>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label class="class_312 mb-2"  >
                                        Sex
                                    </label>
                                    <div class="class_312 mb-2">
                                        <input type="radio" name="sex" value="Male" <?php if ($user_sex === "Male") echo "checked"; ?> onclick="return false;" style="pointer-events: none;">Male
                                        <input type="radio" name="sex" value="Female" <?php if ($user_sex === "Female") echo "checked"; ?> onclick="return false;" style="pointer-events: none;">Female
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label class="class_312" for="barangay">
                                        Barangay
                                    </label>
                                    <div class="class_312 mb-2" >
                                        <select name="barangay" id="barangay" required class="class_33">
                                            <!-- list of barangays -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="class_31" >
                                <label >
                                    Phone Number
                                </label>
                                <!--+63--><input value="<?=$row['user_pnum']?>" placeholder="9998887777" type="text" name="pnum" class="class_33"  required="true">
                            </div>

                            <div class="class_37 d-flex flex-row-reverse">
                                <button class="class_38 btn" style="background-color: #e9a886; color:#ffff;" >
                                    Save
                                </button>
                                <!--<a href="profile.php">
                                    <button type="button" class="class_39">
                                        Back
                                    </button>
                                </a>-->
                                <div class="class_40">
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- end of account information modal -->

                <!-- change password modal -->
                <div class="js-change-password-modal hide">
                <h2 style="color: #2F2F2F;
                font-weight: 500;">Change your password</h2></br>
                    <div class="class_30">
                        <div class="class_31" style="position: relative;">
                            <label class="class_32">
                                Current Password
                            </label>
                            <input type="password" name="current_password" id="cpass" class="class_33">
                            <i class="fas fa-eye" style="font-size: 15px; cursor: pointer; color: gray; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);" id="togglePassword1"></i>
                        </div>
                        </br>
                        <div class="class_31" style="position: relative;">
                            <label class="class_32">
                                New Password
                            </label>
                            <input type="password" placeholder="Leave empty to keep old password" name="new_password" id="npass" class="class_33" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, one special character, and at least 8 or more characters">
                            <i class="fas fa-eye" style="font-size: 15px; cursor: pointer; color: gray; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);" id="togglePassword2"></i>
                        </div>
                        </br>
                        <div class="class_31" style="position: relative;">
                            <label class="class_32">
                                Retype New Password
                            </label>
                            <input type="password" name="retype_password" id="rnpass" class="class_33">
                            <i class="fas fa-eye" style="font-size: 15px; cursor: pointer; color: gray; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);" id="togglePassword3"></i>
                        </div>

                        <p class="chan-text" style="
                        bottom: 21px;
                        font-size: 12px;
                        color: #575757;">Changing your password will log you out.</p>
                        

                        <div class="class_37 d-flex flex-row-reverse">
                            <button class="class_38 btn" style="background-color: #e9a886; color:#ffff; margin-left: 10px; ">
                                Save
                            </button>
                            <a href="profile.php">
                                <button type="button" class="class_39 btn btn-outline-danger" style=" margin-left: 10px;">
                                    Back
                                </button>
                            </a>
                            <div class="class_40"></div>
                        </div>
                    </div>
                </div>
                <!-- end of change password modal -->

            </form>
            <!-- delete account modal -->
            <div class="js-delete-account-modal hide">
                <h2 style="color: #2F2F2F;
                font-weight: 500;">Delete your account</h2>
                <div class="class_30" >
                    <p class="text-desc">
                        You're trying to delete your SiPa account, which provides access to various SiPa 
                        services. You'll no longer be able to to use any of those services, and you account 
                        and data will be lost.
                    </p>
                    <hr>
                    
                    <button onclick="account.delete()" class="del-btn btn" style=" color: #ab0f15; font-weight: bold;" >
                        Delete account
                    </button>
                    
                </div>
            </div>
             <!-- end of delete account modal -->


            <!-- view saved method modal -->
            <div class="js-view-saved-method-modal hide">
                <h2 style="color: #2F2F2F; font-weight: 500;">Saved Contraceptive Method</h2>
                <div class="class_30">
                    <p class="text-desc">
                        <!-- pang short desc -->
                    </p>
                    <br>

                    <div class="class_30">
                        <div class="class_31">
                            <label>
                                Method Name
                            </label>
                            <div class="class_311">
                                <input value="<?=$row['birth_control_name']?>" placeholder="No method saved yet!" type="text" name="method-name" disabled class="class_33" style="margin-right: 0px;">
                            </div>
                            <?php if (!empty($row['birth_control_startdate']) || !empty($row['birth_control_enddate'])) : ?>
                                <div class="row">
                                    <?php if (!empty($row['birth_control_startdate'])) : ?>
                                        <div class="col">
                                            <label>
                                                Start Date
                                            </label><br>
                                            <input value="<?=$row['birth_control_startdate']?>" placeholder="No start date saved!" type="text" name="method-startdate" disabled class="class_33">
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($row['birth_control_enddate'])) : ?>
                                        <div class="col">
                                            <label>
                                                End Date
                                            </label><br>
                                            <input value="<?=$row['birth_control_enddate']?>" placeholder="No end date saved!" type="text" name="method-enddate" disabled class="class_33">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($row['birth_control_startdate'])) : ?>
                    <div class="class_31">
                        <button onclick="account.deleteremdates()" class="del-remdates-btn btn" style=" color: #1b4ca1; font-weight: 300; padding-left:0px;">
                            Click here to unsubscribe from our SMS notifications
                        </button>
                        <hr>
                    </div>
                    <?php endif; ?>
                    
                    <div class="mt-3" style="display: flex; justify-content: flex-end;">
                        <?php if (!empty($row['birth_control_name'])) : ?>
                            <button onclick="account.deletemethod()" class="del-method-btn btn" style="color: #ab0f15; font-weight: 500;">
                                Delete method
                            </button>
                        <?php endif; ?>

                        <button onclick="account.newmethod()" class="new-method-btn btn" style=" color: #4087bf; font-weight: 500; padding-right:0px;">
                            New method
                        </button>
                    </div>

                </div>
            </div>
            <!-- end of view saved method modal -->
            </div>

       

        
    <?php else:?>
        <div class="class_16" >
            <i class="bi bi-exclamation-circle-fill class_14">
            </i>
            <div class="class_15"  >
                Profile not found!
            </div>
        </div>
    <?php endif;?>
    </div>
</div>

<br><br><br>
<?php include('footer.php') ?>
</body>

<script>
    var account = {
 
        show: function(modalClass, linkClass) {
            // Hide all modals
            document.querySelector(".js-account-info-modal").classList.add('hide');
            document.querySelector(".js-change-password-modal").classList.add('hide');
            document.querySelector(".js-delete-account-modal").classList.add('hide');
            document.querySelector(".js-view-saved-method-modal").classList.add('hide');

            // Remove bold class from all links
            document.querySelector(".js-acc-info").classList.remove('bold');
            document.querySelector(".js-cha-pass").classList.remove('bold');
            document.querySelector(".js-del-acc").classList.remove('bold');
            document.querySelector(".js-saved-met").classList.remove('bold');

            // Show the specified modal
            document.querySelector(modalClass).classList.remove('hide');

            // Add bold class to the specified link
            document.querySelector(linkClass).classList.add('bold');
        },
        
        delete: function(){

            if (!confirm("Are you sure you want to delete your account?")) {
                //alert(forum_id);
                return;
            }  

            let form = new FormData();
            form.append('data_type', 'delete_account');
            
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        window.location.href = "home_1_with_user.php";
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        deletemethod: function(){
            if (!confirm("[REMINDER]:\nDoctors advised that if your current birth control method is a hormonal type, you can only change your contraceptive method after a year of discontinuity. Are you sure you want to delete your saved method?")) {
                
                return;
            }  

            let form = new FormData();
            form.append('data_type', 'delete_method');
            
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        window.location.href = "account_settings.php";
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        newmethod: function () {
            var methodNameInput = document.querySelector('input[name="method-name"]');
            if (methodNameInput && methodNameInput.value.trim() === "") {
                window.location.href = "right_for_me_quiz.php";
            } else {
                if (!confirm("[WARNING]:\nDoctors advised that if your current birth control method is a hormonal type, you can only change your contraceptive method after a year of discontinuity. Are you sure you want to take the quiz again?")) {
                    return;
                } else {
                    window.location.href = "right_for_me_quiz.php";
                }
            }
        },

        deleteremdates: function(){
            if (!confirm("Are you sure you want to stop receiving sms reminders from us about your chosen method? Unsubscribing deletes the saved method and reminder dates from the database.")) {
                
                return;
            }  

            let form = new FormData();
            form.append('data_type', 'delete_remdates');
            
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        window.location.href = "account_settings.php";
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        load_user_barangay: function(){
            
            let partner_facility_id = "<?=$row['partner_facility_id']?>";
            //console.log(partner_facility_id);
            let form = new FormData();

            form.append('partner_facility_id', partner_facility_id);
            form.append('data_type', 'load_user_barangay');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){
                        //console.log(ajax.responseText);
                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){
                            
                            let selectElement = document.getElementById("barangay");
                            selectElement.innerHTML = "";

                            let blankOption = document.createElement("option");
                            blankOption.value = "";
                            blankOption.text = "Select a Barangay";
                            blankOption.disabled = true;
                            blankOption.selected = true;
                            selectElement.appendChild(blankOption);

                            obj.rows.forEach(function(user_barangay) {
                                user_barangay.barangay.forEach(function(barangay) {
                                    let option = document.createElement("option");
                                    option.value = barangay.barangay_name;
                                    option.text = barangay.barangay_name;
                                    option.setAttribute("user_barangay-name", barangay.barangay_name);

                                    // Set selected value
                                    if (option.value === "<?=$row['user_barangay']?>") {
                                        option.selected = true;
                                    }

                                    selectElement.appendChild(option);
                                });
                            });

                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

    };

    account.load_user_barangay();
</script>
<script>
    //-----------------------------------------------------------------------------------------------------
    // Assuming you have multiple <a> tags with the class "clearSessionStorage"
    let clearSessionStorageLinks = document.querySelectorAll('.js-link');

    // Loop through each <a> tag and attach the event listener
    clearSessionStorageLinks.forEach(function(link) {
    link.addEventListener('click', function(event) {
        //event.preventDefault(); // Prevent the default hyperlink behavior
        sessionStorage.clear(); // Clear the entire sessionStorage
        // Or you can use sessionStorage.removeItem(key) to remove specific items
        
        // Additional actions or code after clearing sessionStorage, if needed
    });
    });

//-----------------------------------------------------------------------------------------------------


</script>

                <script>
                    const togglePassword2 = document.querySelector("#togglePassword2");
                    const password2 = document.querySelector("#npass");

                    togglePassword2.addEventListener("click", function () {
                        this.classList.toggle("fa-eye-slash");
                        // toggle the type attribute
                        const type = password2.getAttribute("type") === "password" ? "text" : "password";
                        password2.setAttribute("type", type);

                        // toggle the icon
                    });
                </script>

                <script>
                    const togglePassword1 = document.querySelector("#togglePassword1");
                    const password1 = document.querySelector("#cpass");

                    togglePassword1.addEventListener("click", function () {
                        this.classList.toggle("fa-eye-slash");
                        // toggle the type attribute
                        const type = password1.getAttribute("type") === "password" ? "text" : "password";
                        password1.setAttribute("type", type);

                        // toggle the icon
                    });
                </script>

                <script>
                    const togglePassword3 = document.querySelector("#togglePassword3");
                    const password3 = document.querySelector("#rnpass");

                    togglePassword3.addEventListener("click", function () {
                        this.classList.toggle("fa-eye-slash");
                        // toggle the type attribute
                        const type = password3.getAttribute("type") === "password" ? "text" : "password";
                        password3.setAttribute("type", type);

                        // toggle the icon
                    });
                </script>
</html>