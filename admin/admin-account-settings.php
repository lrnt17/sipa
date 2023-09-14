<?php 
    require('../connect.php');
    require('../functions.php');

    if(!logged_in()){
		header("Location: ../login_1.php");
		die;
	}

    include('header.php');

    $user_id = $_SESSION['USER']['user_id'];

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
		$userfname 	            = addslashes($_POST['admin_fname']);
        $userlname 	            = addslashes($_POST['admin_lname']);
        $dob 		            = $_POST['admin_dob'];
        $sex 		            = $_POST['admin_gender'];
		$email 		            = addslashes($_POST['admin_gmail']);
		//$city 		            = $_POST['admin_city'];
        //$health_facility 	    = $_POST['admin_health_facility'];
        $specialization         = $_POST['admin_specialization'];
		$pnum 		            = addslashes($_POST['admin_pnum']);


        if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
            
            if (password_verify($_POST['current_password'], $row['user_password'])) {
                
                if ($_POST['new_password'] !== $_POST['retype_password']) {

                    $errors['password'] = "New passwords do not match";

                } else {

                    $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

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
			$errors['userfname'] = "First name cant have numbers or special characters";
		}

        if(!preg_match("/^[\p{L} ]+$/u", $userlname))
		{
			$errors['userlname'] = "Last name cant have numbers or special characters";
		}

        if (!preg_match("/^[0-9]{10}$/", $pnum)) {
            $errors['pnum'] = "The phone number is not valid";
        }        

		//upload image
		if(!empty($_FILES['image']['name']))
		{
			$allowed = ['image/jpeg','image/png','image/webp'];
			if(!in_array($_FILES['image']['type'], $allowed)){
				$errors['image'] = "Image type not supported";
			}else{

				$folder = "../uploads/";
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
			
			$query = "update users set 
            user_fname = '$userfname', 
            user_lname = '$userlname', 
            user_dob = '$dob', 
            user_sex = '$sex', 
            user_email = '$email',
            user_pnum = '$pnum',
            specialization = '$specialization' 
            $image_string 
            $password_string 
            where user_id = '$user_id' limit 1";
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
                            admin.logout(); 
                      </script>";
            }else{
                echo "<script>
                            alert('Your account details successfully updated');
                            window.location.href='admin-account-settings.php';
                      </script>";
            }
            			
			die;
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings | SiPa</title>
    <style>
        body {
        font-family: "Lato", sans-serif;
        }

        /* Fixed sidenav, full height */
        .sidenav {
        height: 100%;
        width: 200px;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        padding-top: 20px;
        }

        /* Style the sidenav links and the dropdown button */
        .sidenav a, .dropdown-btn {
        padding: 6px 8px 6px 16px;
        text-decoration: none;
        font-size: 20px;
        color: #818181;
        display: block;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        outline: none;
        }

        /* On mouse-over */
        .sidenav a:hover, .dropdown-btn:hover {
        color: #f1f1f1;
        }

        /* Main content */
        .main {
        margin-left: 200px; /* Same as the width of the sidenav */
        font-size: 13px; /* Increased text to enable scrolling */
        padding: 0px 10px;
        }

        /* Add an active class to the active dropdown button */
        .active {
        background-color: green;
        color: white;
        }

        /* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
        .dropdown-container {
        display: none;
        background-color: #262626;
        padding-left: 8px;
        }

        /* Optional: Style the caret down icon */
        .fa-caret-down {
        float: right;
        padding-right: 8px;
        }

        /* Some media queries for responsiveness */
        @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
        }
    </style>
</head>
<body>
    <section class="main">
        
        <?php if(!empty($errors)):?>
            <script>
                alert("<?php echo implode("\n", $errors); ?>");
            </script>
        <?php endif;?>

        <h1>Account Settings</h1>
        <?php if(!empty($row)):?>
            <form method="post" enctype="multipart/form-data">
                <div>
                    <label>
                        <img src="<?=get_admin_image($row['user_image'])?>" class="js-admin-image rounded-circle" style="cursor: pointer; height:50px; border-style: solid;" >
                        <input onchange="display_image(this.files[0])" type="file" name="image" style="display:none;">

                        <script>
                            
                            function display_image(file)
                            {
                                let allowed = ['image/jpeg','image/png','image/webp'];

                                if(!allowed.includes(file.type)){
                                    alert("That file type is not allowed!");
                                    return;
                                }

                                let img = document.querySelector(".js-admin-image");
                                img.src = URL.createObjectURL(file);
                            }
                        </script>
                    </label>
                </div>
                <div>
                    <label for="admin_fname">First Name</label>
                    <input value="<?=$row['user_fname']?>" type="text" name="admin_fname" required>
                </div>
                <div>
                    <label for="admin_lname">Last Name</label>
                    <input value="<?=$row['user_lname']?>" type="text" name="admin_lname" required>
                </div>
                <div>
                    <label for="admin_dob">Date of Birth</label>
                    <input value="<?=$row['user_dob']?>" type="date" name="admin_dob" required>
                </div>
                <div>
                    <label for="admin_gender">Gender</label>
                    <select name="admin_gender" id="admin_gender" required>
                        <option value="Male" <?= $row['user_sex'] == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $row['user_sex'] == 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
                <div>
                    <label for="admin_gmail">Gmail Address</label>
                    <input value="<?=$row['user_email']?>" type="email" name="admin_gmail" required>
                </div>
                <!--<div>
                    <label for="admin_city">City or Municipality</label>
                    <select name="admin_city" id="admin_city" required>
                            options are generated by admin_account_settings.load_city_municipality_list();
                    </select>
                </div>
                <div>
                    <label for="admin_health_facility">Health Facility Name</label>
                    <select name="admin_health_facility" id="admin_health_facility" required>

                    </select>
                </div>-->
                <div>
                    <label for="admin_specialization">Specialization</label>
                    <select name="admin_specialization" id="admin_specialization" required>
                        <option value="" disabled>Select Specialization</option>
                        <option value="Obstetrician-Gynecologist (OB-GYN)" <?= $row['specialization'] == 'Obstetrician-Gynecologist (OB-GYN)' ? 'selected' : '' ?>>Obstetrician-Gynecologist (OB-GYN)</option>
                        <option value="Obstetrician" <?= $row['specialization'] == 'Obstetrician' ? 'selected' : '' ?>>Obstetrician</option>
                        <option value="Gynecologist" <?= $row['specialization'] == 'Gynecologist' ? 'selected' : '' ?>>Gynecologist</option>
                        <option value="Family Medicine Physician" <?= $row['specialization'] == 'Family Medicine Physician' ? 'selected' : '' ?>>Family Medicine Physician</option>
                        <option value="Nurse Practitioner" <?= $row['specialization'] == 'Nurse Practitioner' ? 'selected' : '' ?>>Nurse Practitioner</option>
                        <option value="Nurse-Midwife" <?= $row['specialization'] == 'Nurse-Midwife' ? 'selected' : '' ?>>Nurse-Midwife</option>
                        <option value="Sexual Health Specialist" <?= $row['specialization'] == 'Sexual Health Specialist' ? 'selected' : '' ?>>Sexual Health Specialist</option>
                        <option value="Urologist" <?= $row['specialization'] == 'Urologist' ? 'selected' : '' ?>>Urologist</option>
                        <option value="Adolescent Medicine Specialist" <?= $row['specialization'] == 'Adolescent Medicine Specialist' ? 'selected' : '' ?>>Adolescent Medicine Specialist</option>
                        <option value="Planned Parenthood Clinician" <?= $row['specialization'] == 'Planned Parenthood Clinician' ? 'selected' : '' ?>>Planned Parenthood Clinician</option>
                        <option value="Reproductive Health Counselor" <?= $row['specialization'] == 'Reproductive Health Counselor' ? 'selected' : '' ?>>Reproductive Health Counselor</option>
                    </select>
                </div>
                <div>
                    <label for="admin_pnum">Phone Number</label>
                    <input value="<?=$row['user_pnum']?>" type="text" name="admin_pnum" maxlength="10" required>
                </div>
                
                <br>
                <div>
                    <label>Current Password</label>
                    <input type="password" name="current_password">
                </div>
                <div>
                    <label>New Password</label>
                    <input placeholder="Leave empty to keep old password" type="password" name="new_password">
                </div>
                <div>
                    <label>Retype New Password</label>
                    <input type="password" name="retype_password">
                </div>
                <br>

                <button>Save</button>
            </form>
        <?php else:?>
            <div class="">
                <div class="">Profile not found!</div>
            </div>
        <?php endif;?>
    </section>

</body>
<script>

    /*var admin_account_settings = {

        load_city_municipality_list: function(){

            let form = new FormData();

            form.append('data_type', 'load_city_and_health_facility');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){
                            
                            let selectElement = document.getElementById("admin_city");
                            selectElement.innerHTML = "";

                            let blankOption = document.createElement("option");
                            blankOption.value = "";
                            blankOption.text = "Select a City/Municipality";
                            blankOption.disabled = true;
                            selectElement.appendChild(blankOption);

                            obj.rows.forEach(function(location) {
                                let option = document.createElement("option");
                                //option.value = location.partner_facility_id;
                                option.value = location.city_municipality;
                                option.text = location.city_municipality;
                                //option.setAttribute("city-municipality-name", location.city_municipality);
                                
                                // If the city/municipality matches the value from PHP, select this option
                                if (location.city_municipality == "<?=$row['city_municipality']?>") {
                                    option.selected = true;
                                }

                                selectElement.appendChild(option);
                            });
                        }
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },

        load_health_facility_list: function(){

            let form = new FormData();

            form.append('data_type', 'load_city_and_health_facility');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){
                        
                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){
                            
                            let selectElement = document.getElementById("admin_health_facility");
                            selectElement.innerHTML = "";

                            let blankOption = document.createElement("option");
                            blankOption.value = "";
                            blankOption.text = "Select a Health Facility";
                            blankOption.disabled = true;
                            selectElement.appendChild(blankOption);

                            obj.rows.forEach(function(healthcare_provider) {
                                let option = document.createElement("option");
                                //option.value = healthcare_provider.partner_facility_id;
                                option.value = healthcare_provider.health_facility_name;
                                option.text = healthcare_provider.health_facility_name;
                                //option.setAttribute("health-facility-name", healthcare_provider.health_facility_name);
                                if (healthcare_provider.health_facility_name == "<?=$row['health_facility_name']?>") {
                                    option.selected = true;
                                }
                                selectElement.appendChild(option);
                            });
                        }
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },

    };

    admin_account_settings.load_city_municipality_list();
    admin_account_settings.load_health_facility_list();*/
</script>
</html>