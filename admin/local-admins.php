<?php 
    require('../connect.php');
    require('../functions.php');

    $city = $_SESSION['USER']['city_municipality'];
    $facility_name = $_SESSION['USER']['health_facility_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <style>
        .hide{
            display: none;
        }
    </style>
</head>
<body>
    <section class="main">
        <?php include('header.php') ?>

        <!-- List of admins -->
        <div>
            <h1><?= $city?> Administrators</h1>
            <table border ="1" cellspacing="0" cellpadding="10" id="admin_table">
                <thead>
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
            <div class="" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="bustos_admins.hide()">X</div>
            <h1>Administrator Details</h1>
            <div>
                <div>User Role: <span class="js-view-role"></span></div>
                <div>Username: <span class="js-view-username"></span></div>
                <br>
                <img src="../assets/images/user.jpg" class="js-view-image" style="cursor: pointer;" width="25" height="25">
                <div>First Name: <span class="js-view-fname"></span></div>
                <div>Last Name: <span class="js-view-lname"></span></div>
                <div>Date of Birth: <span class="js-view-dob"></span></div>
                <div>Gender: <span class="js-view-gender"></span></div>
                <div>Gmail Address: <span class="js-view-gmail"></span></div>
                <div>City or Municipality: <span class="js-view-city-municipality"></span></div>
                <div>Health Facility Name: <span class="js-view-health-facility"></span></div>
                <div>Specialization: <span class="js-view-specialization"></span></div>
                <div>Phone Number: <span class="js-view-pnum"></span></div>
            </div>
        </div>

        <!-- Editing admin modal -->
        <div class="js-edit-admin hide">
            <div class="" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="bustos_admins.hide()">X</div>
            <h1>Edit Administrator</h1>
            <form onsubmit="bustos_admins.save(event)" method="post">
                <div class="form">
                    <label>
                        <img src="../assets/images/user.jpg" class="js-edit-image" style="cursor: pointer;" width="25" height="25">
                        <input onchange="display_image(this.files[0])" type="file" name="edit_image" class="js-image">

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
                <div class="form">
                    <label for="edit_fname">First Name *</label>
                    <input type="text" name="edit_fname" class="js-edit-fname edit-admin" required>
                </div>
                <div class="form">
                    <label for="edit_lname">Last Name *</label>
                    <input type="text" name="edit_lname" class="js-edit-lname edit-admin" required>
                </div>
                <div class="form">
                    <label for="edit_dob">Date of Birth</label>
                    <input type="date" name="edit_dob" class="js-edit-dob edit-admin">
                </div>
                <div class="form">
                    <label for="edit_gender">Gender</label>
                    <select name="edit_gender" id="edit_gender" class="js-edit-gender edit-admin" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form">
                    <label for="edit_gmail">Gmail Address *</label>
                    <input type="email" name="edit_gmail" class="js-edit-gmail edit-admin" required>
                </div>
                <div class="form">
                    <label for="edit_city_municipality">City or Municipality</label>
                    <select name="edit_city_municipality" id="edit_city_municipality" disabled class="js-edit-city-municipality edit-admin" required>
                        <!--<option value="" disabled selected>Select City/Municipality</option>
                        <option value="Baliwag">Baliwag</option>
                        <option value="Bustos">Bustos</option>-->
                    </select>
                </div>
                <div class="form">
                    <label for="edit_health_facility">Health Facility Name:*</label>
                    <select name="edit_health_facility" id="edit_health_facility" disabled class="js-edit-health-facility edit-admin" required>
                        <!--<option value="" disabled selected>Select Health Facility Name</option>
                        <option value="Bustos RHU">Bustos RHU</option>-->
                    </select>
                </div>
                <div class="form">
                    <label for="edit_specialization">Specialization *</label>
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
                <div class="form">
                    <label for="edit_pnum">Phone Number *</label>
                    <input type="number" name="edit_pnum" class="js-edit-pnum edit-admin" required>
                </div>

                <div class="class_45" >
                    <button class="class_46">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </section>

    <template id="row-template">
        <tr>
            <td>
                <img src="../assets/images/user.jpg" class="js-admin-image" width="25" height="25">
                <p class="js-admin-fullname"></p>
            </td>
            <td class="js-admin-email"></td>
            <td class="js-specialization"></td>
            <td class="js-admin-pnum"></td>
            <td>
                <div class="js-edit-btn">
                    <div class="js-admin-edit-btn" style="cursor:pointer;color:blue;">Edit</div>
                </div>
                <div class="js-admin-details-btn" style="cursor:pointer;">View Details</div>
            </td>
        </tr>
    </template>
</body>
<script>

    var bustos_admins = {

        edit_id: null,

        load_admins: function(){

            let form = new FormData();

            let city = '<?= $city?>';
            let facility_name = '<?= $facility_name?>';
            //console.log(city, facility_name);return;
            form.append('city_municipality', city);
            form.append('health_facility_name', facility_name);
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

                                let edit_button = clone.querySelector(".js-edit-btn");
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
                document.querySelector(".js-view-city-municipality").innerHTML = data.city_municipality;
                document.querySelector(".js-view-health-facility").innerHTML = data.health_facility_name;
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
            console.log(file);
            //return;
            let form = new FormData();

            for (var i = inputs.length - 1; i >= 0; i--) {
                form.append(inputs[i].name, inputs[i].value);
            }

            form.append('user_id', bustos_admins.edit_id);
            form.append('edit_image', file);
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
</html>