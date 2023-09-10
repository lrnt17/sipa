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
		$userfname 	= addslashes($_POST['userfname']);
        $userlname 	= addslashes($_POST['userlname']);
		$email 		= addslashes($_POST['email']);
		$dob 		= $_POST['dob'];
		$sex 		= $_POST['sex'];
		$pnum 		= addslashes($_POST['pnum']);
		
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

				$image = $folder . $_FILES['image']['name'];
				
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
			

			$query = "update users set user_fname = '$userfname', user_lname = '$userlname', user_dob = '$dob', user_sex = '$sex', user_email = '$email' $image_string $password_string where user_id = '$user_id' limit 1";
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
            font-weight: 900;
        }

        *{
            color:black;
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
        <div class="container d-lg-flex flex-row d-md-block" style="height: 550px;">
        <div class="rounded-start-5 p-5 shadow-sm rounded col-xxl-4 col-xl-5 col-lg-6 col-sm-fluid" style="background: #D2E0F8;">
            <h2 style="color: #2F2F2F;
            font-weight: 500;">Your Account</h2>
            <p class ="text-desc d-none md-none d-lg-block" style="font-size: 14px; color: #575757; width:100%;
            word-wrap: break-word; white-space: normal; position: relative; top: -5px;">See information about your account, password, or about your account deletion.</p>
            <br>
        
            <div class="row row-cols-6 gx-10 row-cols-lg-1 d-m-fluid" style="justify-content: space-between;">
                <div onclick="account.show('.js-account-info-modal', '.js-acc-info')" class="js-settings class_15 row" style="cursor:pointer;" >
                    <div class="col-2"><i class="fa-solid fa-user" style="font-size:20px;"></i> </div>
                    <div class="col d-none md-none d-lg-block"> <p class="js-acc-info bold" style="display: inline;">Account information</p></div>
                </div>
                <div class="row">
                    <div class="col-2"> </div>
                    <div class="col d-none md-none d-lg-block"><p class ="text-desc-a">See your account information like your name and email address.</p></div>
                </div>

                <div onclick="account.show('.js-change-password-modal', '.js-cha-pass')" class="js-settings class_15 row" style="cursor:pointer;" >
                    <div class="col-2 "><i class="fa-solid fa-lock" style="font-size:20px;"></i></div>
                    <div class="col d-none md-none d-lg-block"><p class="js-cha-pass" style="display:inline">Change your password</p></div>
                </div>
                <div class="row">
                    <div class="col-2"> </div>
                    <div class="col d-none md-none d-lg-block"><p class ="text-desc-a">Change your password anytime.</p></div>
                </div>

                <div onclick="account.show('.js-delete-account-modal', '.js-del-acc')" class="js-settings class_15 row" style="cursor:pointer;" >
                    <div class="col-2 "><i class="fa-solid fa-heart-crack" style="font-size:20px;"></i> </div>
                    <div class="col d-none md-none d-lg-block"><p class="js-del-acc" style="display:inline">Delete your account</p></div>
                </div>
                <div class="row">
                    <div class="col-2"> </div>
                    <div class="col d-none md-none d-lg-block"><p class ="text-desc-a">Deletion of your account.</p></div>
                </div>

                <div class="row" style="align-items: center;">
                    <div class="col-2"><i class="fa-solid fa-arrow-right-from-bracket" onclick="user.logout()" style="font-size:20px; cursor: pointer;"></i></div>
                    <div class="col d-none md-none d-lg-block"><button onclick="user.logout()" class="class_39 btn btn-link" style="text-decoration: none; color:black;"  >
                        Logout
                    </button></div>
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
        col-xxl-8 col-xl-9 col-lg-9 col-sm-fluid" style="height: 550px; background-color: #ffff;">
            <form method="post" enctype="multipart/form-data" >
                <!-- account information modal -->
                    <div class="js-account-info-modal">
                        <h2 style="color: #2F2F2F;
                        font-weight: 500;">Account information</h2>
                        <label>
                            <img src="<?=get_image($row['user_image'])?>" class="js-image rounded-circle class_28" style="cursor: pointer; height:50px; border-style: solid;" >
                            <input onchange="display_image(this.files[0])" type="file" name="image" class="class_29" style="display:none;">

                            <script>
                                
                                function display_image(file)
                                {
                                    let allowed = ['image/jpeg','image/png','image/webp'];

                                    if(!allowed.includes(file.type)){
                                        alert("That file type is not allowed!");
                                        return;
                                    }

                                    let img = document.querySelector(".js-image");
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
                                <input value="<?=$row['user_fname']?>" placeholder="First Name (Optional)" type="text" name="userfname" class="class_33">
                                <input value="<?=$row['user_lname']?>" placeholder="Last Name (Optional)" type="text" name="userlname" class="class_33">
                            </div>
                            </div>
                            <div class="class_31" >
                                <label >
                                    Email
                                </label><br>
                                <input value="<?=$row['user_email']?>" placeholder="Email" type="text" name="email" class="class_33"  required="true">
                            </div>
                            <div class="class_311" >
                                <label class="class_312"  >
                                    Date of Birth
                                </label>
                                <label class="class_312"  >
                                    Sex
                                </label>
                            </div>
                            <div class="class_311" >
                            <div class="class_312" >
                                <input value="<?=$row['user_dob']?>" placeholder="Email" type="date" name="dob" class="class_33"  required="true">
                            </div>
                            <div class="class_312" >
                                <input type="radio" name="sex" value="Male" <?php if ($user_sex === "Male") echo "checked"; ?>>Male
                                <input type="radio" name="sex" value="Female" <?php if ($user_sex === "Female") echo "checked"; ?>>Female
                                <input type="radio" name="sex" value="Other" <?php if ($user_sex === "Other") echo "checked"; ?>>Other
                            </div>
                            </div>
                            <div class="class_31" >
                                <label >
                                    Phone Number
                                </label>
                                <!--+63--><input value="<?=$row['user_pnum']?>" placeholder="9998887777" type="text" name="pnum" class="class_33"  required="true">
                            </div>

                            <div class="class_37 d-flex flex-row-reverse">
                                <button class="class_38 btn" style="background-color: #F2C1A7; color:#ffff;" >
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
                        <div class="class_31">
                            <label class="class_32">
                                Current Password
                            </label>
                            <input type="password" name="current_password" class="class_33">
                        </div></br>
                        <div class="class_31">
                            <label class="class_32">
                                New Password
                            </label>
                            <input type="password" name="new_password" class="class_33">
                        </div></br>
                        <div class="class_31">
                            <label class="class_36">
                                Retype New Password
                            </label>
                            <input type="password" name="retype_password" class="class_33">
                        </div>
                        <p class="chan-text" style="
                        bottom: 21px;
                        font-size: 12px;
                        color: #575757;">Changing your password will log you out.</p>
                        

                        <div class="class_37 d-flex flex-row-reverse">
                            <button class="class_38 btn" style="background-color: #F2C1A7; color:#ffff; margin-left: 10px; ">
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
        </div>
        <!-- end of delete account modal -->
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
</body>

<script>
    var account = {
 
        show: function(modalClass, linkClass) {
            // Hide all modals
            document.querySelector(".js-account-info-modal").classList.add('hide');
            document.querySelector(".js-change-password-modal").classList.add('hide');
            document.querySelector(".js-delete-account-modal").classList.add('hide');

            // Remove bold class from all links
            document.querySelector(".js-acc-info").classList.remove('bold');
            document.querySelector(".js-cha-pass").classList.remove('bold');
            document.querySelector(".js-del-acc").classList.remove('bold');

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

    };
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
</html>