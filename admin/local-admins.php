<?php 
    require('../connect.php');
    require('../functions.php');
    require('fetch_user_and_partner_info.php');

    //$city = $_SESSION['USER']['city_municipality'];
    //$facility_name = $_SESSION['USER']['health_facility_name'];
    
    /*$user_id = $_SESSION['USER']['user_id'];

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title><?= $city?> Administrators | SiPa</title>
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

        .edit-admin{
            width: 100%;
            padding: 0px 0px 2px 0px;
            border: none;
            border-bottom: 2.2px solid #B9B9B9;
            font-size: 15px;
            outline: none;
            margin: 10px 30px 15px 0px;
        }

        tr{
            border-bottom: 1px solid black !important;
        }
        td{
            font-size: 14px !important;
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
        th{
            padding-left: 15px !important;
            padding-bottom: 5px !important;
        }

        .js-admin-details-btn:hover{
            color:black;
        }

        .js-edit-admin, .js-view-admin {
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 50px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .edit-container, .view-container {
            background-color: #fefefe;
            margin: auto;
            width: 50%;
            border-radius: 25px;
            box-shadow: 0 0 5px rgba(0,0,0,.3);
            padding: 3%;
            max-height: 89vh; /* Set a maximum height for the container (adjust as needed) */
            overflow-y: auto; 
        }

        /* The Close Button */
        .close-btn {
        color: black;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        @media (max-width: 850px){
            .edit-container, .view-container {
            width: 90% !important;
            
            }
        }
    </style>
    <style>
        .hide{
            display: none;
        }
    </style>
</head>
<body style="background: #F2F5FF;">
<?php include('admin-header.php') ?>
    <section class="main">
            <div class="topbar row">
                <div class="toggle col-5">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <!--<div class="img-con col">
                    <img class="rounded-circle" src="logo-colored.png" alt="SiPa" width="45" height="45" >
                </div>-->

            </div>
        

        <!-- List of admins -->
        <div class="container">

                <div class="row flex-nowrap" style="align-items: center; margin-top:85px;">
                    <div class="col-auto">
                        <div class="vl" style="width: 10px;
                        background-color: #1F6CB5;
                        border-radius: 99px;
                        height: 60px;
                        display: -webkit-inline-box;"></div>
                    </div>
                
                    <div class="col-auto mt-1">
                        <div class="row">
                            <div class="col-auto">
                                <h2 style="font-weight: 400;"><b><?= $city?></b> Administrators</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

            <table cellspacing="0" cellpadding="10" id="admin_table">
                <thead style="border-bottom: 1px solid black;
                font-size: 15px;">
                    <tr>
                        <th>Administrators</th>
                        <th>Email</th>
                        <th>Specialization</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <br>
        </div>

        <!-- View admin details modal -->
        <div class="js-view-admin hide">
            <div class="view-container">
                <div class="close-btn" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="closeModal()">
                &times;
                </div>
                <div class="row flex-nowrap" style="align-items: center;">
                    <div class="col-auto">
                        <div class="vl" style="width: 10px;
                        background-color: #1F6CB5;
                        border-radius: 99px;
                        height: 60px;
                        display: -webkit-inline-box;"></div>
                    </div>
                
                    <div class="col-auto mt-1">
                        <div class="row">
                            <div class="col-auto">
                                <h2 style="font-weight: 400;">Administrator Details</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container ms-4 ps-4">
                    <div class="row" style="display: flex; align-items: center;">
                        <div class="col-auto" style="padding:0px;">
                            <div class="img-con" style="width:50px; height:50px; border-radius:50%; border-style: solid; position: ; overflow: hidden; padding: 0;"> 
                                <img src="../assets/images/user.jpg" class="js-view-image"  style=" width: 100%; height: 100%; object-fit: cover;" >
                            </div>
                        </div>
                        <div class="col">
                            <div>User Role: <span class="js-view-role"></span></div>
                            <div>Username: <span class="js-view-username"></span></div>
                        </div>
                    </div>

                    <div class="row mt-4 mb-2">
                        <div class="col">
                            <div style="font-size:18px;"><i class="fa-solid fa-user-doctor"></i> Specialization: <span style="color: #1F6CB5; font-weight:500;"class="js-view-specialization"></span></div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <div style="font-size: 15px;">First Name <br><span class="js-view-fname" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                        <div class="col">
                            <div style="font-size: 15px;">Last Name<br> <span class="js-view-lname" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <div style="font-size: 15px;">Date of Birth <br> <span class="js-view-dob" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                        <div class="col">
                            <div style="font-size: 15px;">Gender <br> <span class="js-view-gender" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <div style="font-size: 15px;">Gmail Address <br> <span class="js-view-gmail" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                        <div class="col">
                            <div style="font-size: 15px;">Phone Number <br> <span style="font-size: 16px;color: #1F6CB5;">+63</span><span class="js-view-pnum" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <div style="font-size: 15px;">City or Municipality <br> <span class="js-view-city-municipality" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                        <div class="col">
                            <div style="font-size: 15px;">Health Facility Name <br> <span class="js-view-health-facility" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Editing admin modal -->
        <div class="js-edit-admin hide">
            <div class="edit-container">
                <div class="close-btn" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="closeEditModal()">
                    &times;
                </div>
                <div class="row flex-nowrap" style="align-items: center;">
                    <div class="col-auto">
                        <div class="vl" style="width: 10px;
                        background-color: #1F6CB5;
                        border-radius: 99px;
                        height: 60px;
                        display: -webkit-inline-box;"></div>
                    </div>
                
                    <div class="col-auto mt-1">
                        <div class="row">
                            <div class="col-auto">
                                <h2 style="font-weight: 400;">Edit Administrator</h2>
                            </div>
                        </div>
                    </div>
                </div>
                    <form class="container ms-4 ps-4" onsubmit="bustos_admins.save(event)" method="post" style="width: 94%;">

                        <div class="container" style="display: flex;justify-content: center;">
                            <div class="form">
                                <label>
                                    <div class="img-con" style="width:60px; height:60px; border-radius:50%; border-style: solid; position: cursor: pointer; overflow: hidden; padding: 0;"> 
                                        <img src="../assets/images/user.jpg" class="js-edit-image" title="Upload new profile photo" style=" width: 100%; height: 100%; object-fit: cover; cursor: pointer;" >
                                    </div>
                                    <input onchange="display_image(this.files[0])" type="file" name="edit_image" class="js-image"  style="display:none;">

                                    <script>
                                        
                                        function display_image(file)
                                        {
                                            let allowed = ['image/jpeg','image/png','image/webp'];

                                            if(!allowed.includes(file.type)){
                                                alert("That file type is not allowed!");
                                                return;
                                            }

                                            let img = document.querySelector(".js-edit-image");
                                            img.src = URL.createObjectURL(file);
                                        }
                                    </script>
                                </label>
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="col mt-3">
                                <div class="form">
                                    <label for="edit_specialization"> <i class="fa-solid fa-user-doctor"></i> Specialization <span style="color:red;">*</span></label>
                                    <select name="edit_specialization" id="edit_specialization" disabled class="js-edit-specialization edit-admin" required>
                                        <option value="" disabled selected>Select Specialization</option>
                                        <option value="Obstetrician-Gynecologist (OB-GYN)">Obstetrician-Gynecologist (OB-GYN)</option>
                                        <option value="Obstetrician">Obstetrician</option>
                                        <option value="Gynecologist">Gynecologist</option>
                                        <option value="Family Medicine Physician">Family Medicine Physician</option>
                                        <option value="Nurse Practitioner">Nurse Practitioner</option>
                                        <option value="Nurse-Midwife">Nurse-Midwife</option>
                                        <option value="Sexual Health Specialist">Sexual Health Specialist</option>
                                        <option value="Urologist">Urologist</option>
                                        <option value="Adolescent Medicine Specialist">Adolescent Medicine Specialist</option>
                                        <option value="Planned Parenthood Clinician">Planned Parenthood Clinician</option>
                                        <option value="Reproductive Health Counselor">Reproductive Health Counselor</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form">
                                    <label for="edit_fname" style="font-size: 15px;">First Name <span style="color:red;">*</span></label>
                                    <input type="text" name="edit_fname" class="js-edit-fname edit-admin" minlength = "1" maxlength="40" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form">
                                    <label for="edit_lname" style="font-size: 15px;">Last Name <span style="color:red;">*</span></label>
                                    <input type="text" name="edit_lname" class="js-edit-lname edit-admin" minlength = "1" maxlength="40" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form">
                                    <label for="edit_dob" style="font-size: 15px;">Date of Birth</label>
                                    <input type="date" name="edit_dob" class="js-edit-dob edit-admin">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form">
                                    <label for="edit_gender" style="font-size: 15px;">Gender</label>
                                    <select name="edit_gender" id="edit_gender" class="js-edit-gender edit-admin" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form">
                                    <label for="edit_gmail" style="font-size: 15px;">Gmail Address <span style="color:red;">*</span></label>
                                    <input type="email" name="edit_gmail" class="js-edit-gmail edit-admin" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form">
                                    <label for="edit_pnum" style="font-size: 15px;">Phone Number <span style="color:red;">*</span></label>
                                    <div style="display: flex; align-items: center;">
                                        <p style="font-size: 15px; margin-right: 5px; margin-top: 7px;">+63</p>
                                        <input type="number" name="edit_pnum" class="js-edit-pnum edit-admin" minlength = "11" maxlength="11" required >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form">
                                    <label for="edit_city_municipality" style="font-size: 15px;">City or Municipality</label>
                                    <select name="edit_city_municipality" id="edit_city_municipality" disabled class="js-edit-city-municipality edit-admin" required>
                                        <!--<option value="" disabled selected>Select City/Municipality</option>
                                        <option value="Baliwag">Baliwag</option>
                                        <option value="Bustos">Bustos</option>-->
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form">
                                    <label for="edit_health_facility" style="font-size: 15px;">Health Facility Name <span style="color:red;">*</span></label>
                                    <select name="edit_health_facility" id="edit_health_facility" disabled class="js-edit-health-facility edit-admin" required>
                                        <!--<option value="" disabled selected>Select Health Facility Name</option>
                                        <option value="Bustos RHU">Bustos RHU</option>-->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="class_45 d-flex flex-row-reverse" >
                            <button class="class_46 btn px-5" style="background-color: #F2C1A7; color:#ffff;">
                                Save
                            </button>
                        </div>
                    </form>
            </div>
            
        </div>
    </section>

    <template id="row-template">
        <tr>
            <td>
                <div class="row my-3" style="display: flex;align-items: center;">
                    <div class="col-auto">
                        <div class="img-con" style="width:40px; height:40px; border-radius:50%; border-style: solid; position: ; overflow: hidden; padding: 0;"> 
                            <img src="../assets/images/user.jpg" class="js-admin-image"   style=" width: 100%; height: 100%; object-fit: cover;" >
                        </div>
                    </div>
                    <div class="col">
                        <p class="js-admin-fullname" style="margin: 0px;"></p>
                    </div>
                </div>
                
            </td>
            <td class="js-admin-email"></td>
            <td class="js-specialization"></td>
            <td class="js-admin-pnum"></td>
            <td>

                <a data-toggle="dropdown" class="btn"><i class="fa-solid fa-ellipsis" style="font-size:14px;"></i></i></a>
                        
                        <!--div edit,del-->
                        <div class="container">
                            
                            <!--ul element-->
                            <ul class="dropdown-menu dropdown-menu-right">
                                
                                <div class="js-admin-edit-btn dropdown-item"  >
                                    <div class="js-edit-btn" style="color:blue;cursor: pointer; font-size: 14.5px;" >
                                        Edit
                                    </div>
                                </div>

                                <div class="js-admin-details-btn dropdown-item" style="cursor: pointer; font-size:14px;"  >
                                    View Details
                                </div>
                            </ul>

                        </div>
            </td>
        </tr>
    </template>
</body>

<script>
    // Function to show the edit modal when the button is clicked
    function showEditModal() {
        document.querySelector(".js-edit-admin").classList.remove("hide");
    }

    // Attach a click event listener to the "js-admin-edit-btn" element
    //document.querySelector(".js-admin-edit-btn").addEventListener("click", showEditModal);

    // Function to hide the edit modal when the close button is clicked
    function closeEditModal() {
        document.querySelector(".js-edit-admin").classList.add("hide");
    }

    // Attach a click event listener to the close button inside the edit modal
    //document.querySelector(".js-edit-admin .close-btn").addEventListener("click", closeEditModal);
    

    // Function to show the modal when the button is clicked
    function showModal() {
        document.querySelector(".js-view-admin").classList.remove("hide");
    }

    // Attach a click event listener to the "js-admin-details-btn" element
    //document.querySelector(".js-admin-details-btn").addEventListener("click", showModal);

    // Function to hide the modal when the close button is clicked
    function closeModal() {
        document.querySelector(".js-view-admin").classList.add("hide");
    }

    // Attach a click event listener to the close button inside the modal
    //document.querySelector(".js-view-admin .close-btn").addEventListener("click", closeModal);
</script>

<script>

    var bustos_admins = {

        edit_id: null,

        load_admins: function(){

            let form = new FormData();

            //let city = '<?//= $city?>';
            //let facility_name = '<?//= $facility_name?>';
            let partner_facility_id = '<?= $partner_facility_id?>';
            //console.log(city, facility_name);return;
            //form.append('city_municipality', city);
            //form.append('health_facility_name', facility_name);
            form.append('partner_facility_id', partner_facility_id);
            form.append('data_type', 'load_local_admins');
            
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let data = JSON.parse(ajax.responseText);

                        if(data.success){
                            // Get table and template elements
                            let table = document.querySelector("#admin_table tbody");
                            let template = document.querySelector("#row-template");

                            // Generate table rows
                            for (let i = 0; i < data.rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-admin-image").src = data.rows[i].user_image;
                                row.querySelector(".js-admin-fullname").textContent = data.rows[i].user_fname + ' ' + data.rows[i].user_lname;
                                row.querySelector(".js-admin-email").textContent = data.rows[i].user_email;
                                row.querySelector(".js-specialization").textContent = data.rows[i].specialization;
                                row.querySelector(".js-admin-pnum").textContent = data.rows[i].user_pnum;
                                row.querySelector(".js-admin-edit-btn").setAttribute('onclick',`bustos_admins.edit_admin('${data.rows[i].user_id}')`);
                                row.querySelector(".js-admin-details-btn").setAttribute('onclick',`bustos_admins.view_admin('${data.rows[i].user_id}')`);
                                
                                //copying the content of postCard
                                let clone = row.cloneNode(true);

                                // Get root element of cloned template
                                let rootElement = clone.querySelector(':first-child');
                                rootElement.setAttribute('id','admin_'+data.rows[i].user_id);
                                let row_data = JSON.stringify(data.rows[i]);
                                row_data = row_data.replaceAll('"','\\"');
                                rootElement.setAttribute('row',row_data);

                                let edit_button = clone.querySelector(".js-admin-edit-btn");
                                if(!data.rows[i].user_owns){
                                    edit_button.remove();
                                }

                                table.appendChild(clone);
                            }
                        }
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },

        view_admin: function(id){

            document.querySelector(".js-view-admin").classList.remove('hide');

            let data = document.querySelector("#admin_"+id).getAttribute("row");
            data = data.replaceAll('\\"','"');
            data = JSON.parse(data);
            console.log(data)
            if(typeof data == 'object') {

                document.querySelector(".js-view-role").innerHTML = data.user_role;
                document.querySelector(".js-view-username").innerHTML = data.user_name;

                document.querySelector(".js-view-image").src = data.user_image;
                document.querySelector(".js-view-fname").innerHTML = data.user_fname;
                document.querySelector(".js-view-lname").innerHTML = data.user_lname;

                let date = new Date(data.user_dob);
                let formattedDate = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                document.querySelector(".js-view-dob").innerHTML = formattedDate;
                document.querySelector(".js-view-gender").innerHTML = data.user_sex;
                document.querySelector(".js-view-gmail").innerHTML = data.user_email;
                document.querySelector(".js-view-city-municipality").innerHTML = data.partner_facility.location;;
                document.querySelector(".js-view-health-facility").innerHTML = data.partner_facility.name;
                document.querySelector(".js-view-specialization").innerHTML = data.specialization;
                document.querySelector(".js-view-pnum").innerHTML = data.user_pnum;

            } else {
                alert("Invalid data");
            }
        },

        edit_admin: function(id){

            document.querySelector(".js-edit-admin").classList.remove('hide');
            bustos_admins.load_city_municipality_list();
            bustos_admins.load_health_facility_list();
            bustos_admins.edit_id = id;

            let data = document.querySelector("#admin_"+id).getAttribute("row");
            data = data.replaceAll('\\"','"');
            data = JSON.parse(data);

            if(typeof data == 'object') {

                document.querySelector(".js-edit-image").src = data.user_image;
                document.querySelector(".js-edit-fname").value = data.user_fname;
                document.querySelector(".js-edit-lname").value = data.user_lname;
                document.querySelector(".js-edit-dob").value = data.user_dob;
                document.querySelector(".js-edit-gender").value = data.user_sex;
                document.querySelector(".js-edit-gmail").value = data.user_email;
                document.querySelector(".js-edit-city-municipality").value = data.city_municipality;
                document.querySelector(".js-edit-health-facility").value = data.health_facility_name;
                document.querySelector(".js-edit-specialization").value = data.specialization;
                document.querySelector(".js-edit-pnum").value = data.user_pnum;

            } else {
                alert("Invalid data");
            }
        },

        save: function(e){

            e.preventDefault();
            let inputs = document.querySelectorAll('.edit-admin');
            function getSelectedValue(selectId) {
                let selectElement = document.getElementById(selectId);
                return selectElement.options[selectElement.selectedIndex].value;
            }

            let selected_gender = getSelectedValue("edit_gender");
            let selected_specialization = getSelectedValue("edit_specialization");
            let selected_city_municipality = getSelectedValue("edit_city_municipality");
            let selected_health_facility = getSelectedValue("edit_health_facility");
            let fileInput = document.querySelector('.js-image');
            let file = fileInput.files[0];

            let form = new FormData();

            if (file) {
                // If a file is selected, you can proceed with further actions
                console.log(file);
                form.append('edit_image', file);
            } else {
                // Handle the case where no file is selected
                console.log("No file selected");
            }
            console.log(fileInput);
            //return;

            for (var i = inputs.length - 1; i >= 0; i--) {
                form.append(inputs[i].name, inputs[i].value);
            }

            form.append('user_id', bustos_admins.edit_id);
            form.append('selected_gender', selected_gender);
            form.append('selected_specialization', selected_specialization);
            form.append('selected_city_municipality', selected_city_municipality);
            form.append('selected_health_facility', selected_health_facility);
            form.append('data_type', 'edit_local_admin');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if(obj.success){

                            //let table = document.querySelector("#admin_table tbody");
                            //table.innerHTML = "";
                            location.reload();
                            //bustos_admins.load_admins();
                            //bustos_admins.hide();
                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);

        },

        hide: function(){
            //document.querySelector(".js-add-admin").classList.add('hide');
            document.querySelector(".js-edit-admin").classList.add('hide');
            document.querySelector(".js-view-admin").classList.add('hide');
        },

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
                            
                            let selectElement = document.getElementById("edit_city_municipality");
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
                            
                            let selectElement = document.getElementById("edit_health_facility");
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

    bustos_admins.load_admins();
</script>

<script>
    let toggle = document.querySelector(".toggle");
    let navigation = document.querySelector(".navigation");
    let main = document.querySelector(".main");

    toggle.onclick = function () {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
    };
</script>
</html>