<?php 
    require("connect.php");
    require('functions.php');
    include('header.php');

    if(!logged_in()){
		header("Location: home_1_with_user.php");
		die;
	}

    $user_id = $_SESSION['USER']['user_id'];
    $user_sex = $_SESSION['USER']['user_sex'];
    $user_password = $_SESSION['USER']['user_password'];

    //echo $user_id;

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

            if ($_POST['current_password'] == $user_password) {
                // Check if the new password and retype password match
                if ($_POST['new_password'] !== $_POST['retype_password']) {
                    $errors['password'] = "New passwords do not match";
                } else {
                    // Update the password in the database
                    $password = $_POST['new_password'];
                    
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

	$query = "select * from users where user_id = '$user_id' limit 1";
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
    </style>
</head>
<body>
    
    <section>
        <!-- navigation bar with logo -->
        

        <!-- your account -->
        <div>
            <?php if(!empty($errors)):?>
                <script>
                    alert("<?php echo implode("\n", $errors); ?>");
                </script>
            <?php endif;?>
            <h1>Your Account</h1>
            <p>See information about your account, password, or about your account deletion.</p>
            <br>

            <div>
                <div onclick="account.show('.js-account-info-modal', '.js-acc-info')" class="js-settings class_15" style="cursor:pointer;" >
                    <p class="js-acc-info bold">Account information</p>
                    <p>See your account information like your name and email address.</p>
                </div>
                <div onclick="account.show('.js-change-password-modal', '.js-cha-pass')" class="js-settings class_15" style="cursor:pointer;" >
                    <p class="js-cha-pass">Change your password</p>
                    <p>Change your password anytime.</p>
                </div>
                <div onclick="account.show('.js-delete-account-modal', '.js-del-acc')" class="js-settings class_15" style="cursor:pointer;" >
                    <p class="js-del-acc">Delete your account</p>
                    <p>Deletion of your account.</p>
                </div>
            </div>
            <button onclick="user.logout()" class="class_39"  >
                Logout
            </button>
        </div>

    </section>
    
    <?php if(!empty($row)):?>
        <form method="post" enctype="multipart/form-data" class="class_26" >
            <!-- account information modal -->
            <div class="js-account-info-modal">
                <h1>Account information</h1>
                <label>
                    <img src="<?=get_image($row['user_image'])?>" class="js-image class_28" style="cursor: pointer;" >
                    <input onchange="display_image(this.files[0])" type="file" name="image" class="class_29">

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
                    <div class="class_31" >
                        <label class="class_32"  >
                            Name
                        </label>
                        <input value="<?=$row['user_fname']?>" placeholder="First Name (Optional)" type="text" name="userfname" class="class_33">
                        <input value="<?=$row['user_lname']?>" placeholder="Last Name (Optional)" type="text" name="userlname" class="class_33">
                    </div>
                    <div class="class_31" >
                        <label class="class_32"  >
                            Email
                        </label>
                        <input value="<?=$row['user_email']?>" placeholder="Email" type="text" name="email" class="class_33"  required="true">
                    </div>
                    <div class="class_31" >
                        <label class="class_32"  >
                            Date of Birth
                        </label>
                        <input value="<?=$row['user_dob']?>" placeholder="Email" type="date" name="dob" class="class_33"  required="true">
                    </div>
                    <div class="class_31" >
                        <label class="class_32"  >
                            Sex
                        </label>
                        <br>
                        <input type="radio" name="sex" value="Male" <?php if ($user_sex === "Male") echo "checked"; ?>>Male<br>
                        <input type="radio" name="sex" value="Female" <?php if ($user_sex === "Female") echo "checked"; ?>>Female<br>
                        <input type="radio" name="sex" value="Other" <?php if ($user_sex === "Other") echo "checked"; ?>>Other<br>
                    </div>
                    <div class="class_31" >
                        <label class="class_32"  >
                            Phone Number
                        </label>
                        +63<input value="<?=$row['user_pnum']?>" placeholder="9998887777" type="text" name="pnum" class="class_33"  required="true">
                    </div>
                    <hr>

                    <div class="class_37">
                        <button class="class_38">
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
                <h1>Change your password</h1>
                <div class="class_30">
                    <div class="class_31">
                        <label class="class_32">
                            Current Password:
                        </label>
                        <input placeholder="" type="password" name="current_password" class="class_33">
                    </div>
                    <div class="class_31">
                        <label class="class_32">
                            New Password:
                        </label>
                        <input placeholder="" type="password" name="new_password" class="class_33">
                    </div>
                    <div class="class_31">
                        <label class="class_36">
                            Retype New Password:
                        </label>
                        <input placeholder="" type="password" name="retype_password" class="class_33">
                    </div>
                    <br>
                    <p>Changing your password will log you out.</p>
                    <hr>

                    <div class="class_37">
                        <button class="class_38">
                            Save
                        </button>
                        <a href="profile.php">
                            <button type="button" class="class_39">
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
            <h1>Delete your account</h1>
            <div class="class_30" >
                <span>
                    You're trying to delete your SiPa account, which provides access to various SiPa 
                    services. You'll no longer be able to to use any of those services, and you account 
                    and data will be lost.
                </span>
                <hr>
                
                <button onclick="account.delete()" class="class_39"  >
                    Delete account
                </button>
                
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

</html>