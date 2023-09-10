<?php 
    require('../connect.php');
    require('../functions.php');

    $user_place = $_SESSION['USER']['city_municipality'];
    $user_work_at = $_SESSION['USER']['health_facility_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment List | SiPa</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
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

        <div>
            <h1>Appointment List</h1>
            <label for="search-username">Search by username:</label>
            <!--<input type="text" id="search-username" oninput="appointment_list.search_appointments(this.value)">-->
            <input type="text" id="search-username">
            <br>
            <table border ="1" cellspacing="0" cellpadding="10" id="appointment_table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all-appointment" onclick="appointment_list.select_all_appointments(this);"></th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <br>
            <div id="pagination">
                <button onclick="appointment_list.go_to_page(1)">First Page</button>
                <button onclick="appointment_list.previous_page()">Previous Page</button>
                <select id="current-page" onchange="appointment_list.go_to_page(this.value)">
                    <!-- Add options for each page here -->
                </select><br>
                <button onclick="appointment_list.next_page()">Next Page</button>
                <button onclick="appointment_list.go_to_last_page()">Last Page</button>
            </div>

            <br>
            <!-- Delete button -->
            <div onclick="appointment_list.delete_appointment()" style="cursor:pointer;color:red;" id="delete-positive">Delete</div>
        </div>

        <!-- View patient details modal -->
        <div class="js-view-patient hide">
            <div class="" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="appointment_list.hide()">X</div>
            <h1>Administrator Details</h1>
            <div>
                <div>Appointment Schedule: <span class="js-view-appointment-schedule"></span></div>
                <div>Timeslot: <span class="js-view-timeslot"></span></div>
                <div>Patient Name: <span class="js-view-patient-name"></span></div>
                <div>Gender: <span class="js-view-gender"></span></div>
                <div>Date of Birth: <span class="js-view-dob"></span></div>
                <div>Phone No.: <span class="js-view-pnum"></span></div>
                <div>Gmail Address: <span class="js-view-gmail"></span></div>
                <div>Address: <span class="js-view-address"></span></div>
                <div>Status: <span class="js-view-status"></span></div>
            </div>
        </div>

        <!-- Editing patient modal -->
        <div class="js-edit-admin hide">
            <div class="" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="manage_admins.hide()">X</div>
            <h1>Edit Administrator</h1>
            <form onsubmit="manage_admins.save(event)" method="post">
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
                    <select name="edit_city_municipality" id="edit_city_municipality" class="js-edit-city-municipality edit-admin" required>
                        <option value="" disabled selected>Select City/Municipality</option>
                        <option value="Baliwag">Baliwag</option>
                        <option value="Bustos">Bustos</option>
                    </select>
                </div>
                <div class="form">
                    <label for="edit_health_facility">Health Facility Name:*</label>
                    <select name="edit_health_facility" id="edit_health_facility" class="js-edit-health-facility edit-admin" required>
                        <option value="" disabled selected>Select Health Facility Name</option>
                        <option value="Bustos RHU">Bustos RHU</option>
                    </select>
                </div>
                <div class="form">
                    <label for="edit_specialization">Specialization *</label>
                    <select name="edit_specialization" id="edit_specialization" class="js-edit-specialization edit-admin" required>
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

    <template id="appointments-template">
        <tr>
            <td align="center" id="checkbox">
                <label class="container">
                    <input type="checkbox" class="js-select-appointment" name="all_appointments[]">
                    <span class="checkmark"></span>
                </label>
            </td>
            <td class="js-appointment-id"></td>
            <td class="js-userfname"></td>
            <td class="js-userlname"></td>
            <td>
                <div class="js-appointment-date"></div>
                <div class="js-appointment-timeslot"></div>
            </td>
            <td class="js-appointment-status"></td>
            <td>
                <div class="js-appointment-details-btn" style="cursor:pointer;">View Details</div>
                <div class="js-appointment-edit-btn" style="cursor:pointer;color:blue;">Edit</div>
            </td>
        </tr>
    </template>

<script>
    var appointment_list = {

        edit_id: '',
        current_page: 1,
        last_page: 0,

        load_appointments: function(e){

            let city_municipality = '<?php echo $user_place; ?>';
            let health_facility = '<?php echo $user_work_at; ?>';
            //console.log(city_municipality);return;
            let form = new FormData();

            form.append('city_municipality', city_municipality);
            form.append('health_facility', health_facility);
            form.append('page', this.current_page);
            form.append('data_type', 'load_appointments');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let data = JSON.parse(ajax.responseText);

                        if(data.success){
                            // Get table and template elements
                            let table = document.querySelector("#appointment_table tbody");
                            let template = document.querySelector("#appointments-template");

                            // Clear existing rows
                            table.innerHTML = "";

                            // Generate table rows
                            for (let i = 0; i < data.rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-select-appointment").setAttribute('app_id', data.rows[i].app_id);
                                row.querySelector(".js-appointment-id").textContent = data.rows[i].app_id;
                                row.querySelector(".js-userfname").textContent = data.rows[i].app_fname;
                                row.querySelector(".js-userlname").textContent = data.rows[i].app_lname;
                                
                                row.querySelector(".js-appointment-date").textContent = data.rows[i].app_date;
                                row.querySelector(".js-appointment-timeslot").textContent = data.rows[i].app_timeslot;
                                row.querySelector(".js-appointment-status").textContent = data.rows[i].status;
                                row.querySelector(".js-appointment-details-btn").setAttribute('onclick',`appointment_list.view_appointment('${data.rows[i].app_id}')`);
                                row.querySelector(".js-appointment-edit-btn").setAttribute('onclick',`appointment_list.edit_appointment('${data.rows[i].app_id}')`);
                                
                                
                                //copying the content of postCard
                                let clone = row.cloneNode(true);

                                // Get root element of cloned template
                                let rootElement = clone.querySelector(':first-child');
                                rootElement.setAttribute('id','appointment_'+data.rows[i].app_id);
                                let row_data = JSON.stringify(data.rows[i]);
                                row_data = row_data.replaceAll('"','\\"');
                                rootElement.setAttribute('row',row_data);

                                table.appendChild(clone);
                            }
                            
                            // Update pagination controls here
                            appointment_list.last_page = data.last_page;
                            let current_page_select = document.querySelector("#current-page");
                            current_page_select.innerHTML = "";

                            for (let i = 1; i <= appointment_list.last_page; i++) {
                                let option = document.createElement("option");
                                option.value = i;
                                option.textContent = i;
                                if (i == appointment_list.current_page) {
                                    option.selected = true;
                                }
                                current_page_select.appendChild(option);
                            }
                        }
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },

        search_appointments: function(query) {

            let table = document.querySelector("#appointment_table tbody");
            let template = document.querySelector("#appointments-template");

            let city_municipality = '<?php echo $user_place; ?>';
            let health_facility = '<?php echo $user_work_at; ?>';

            let form = new FormData();

            form.append('city_municipality', city_municipality);
            form.append('health_facility', health_facility);
            form.append('data_type', 'search_appointments');
            form.append('query', query);

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange', function() {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        let data = JSON.parse(ajax.responseText);

                        // Clear existing rows
                        table.innerHTML = "";

                        if (data.success) {
                            
                            for (let i = 0; i < data.rows.length; i++) {
                                // Update row data here
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-select-appointment").setAttribute('user_id', data.rows[i].app_id);
                                row.querySelector(".js-appointment-id").textContent = data.rows[i].app_id;
                                row.querySelector(".js-userfname").textContent = data.rows[i].app_fname;
                                row.querySelector(".js-userlname").textContent = data.rows[i].app_lname;
                                
                                row.querySelector(".js-appointment-date").textContent = data.rows[i].app_date;
                                row.querySelector(".js-appointment-timeslot").textContent = data.rows[i].app_timeslot;
                                row.querySelector(".js-appointment-status").textContent = data.rows[i].status;
                                row.querySelector(".js-appointment-details-btn").setAttribute('onclick',`appointment_list.view_appointment('${data.rows[i].app_id}')`);
                                row.querySelector(".js-appointment-edit-btn").setAttribute('onclick',`appointment_list.edit_appointment('${data.rows[i].app_id}')`);
                                
                                //copying the content of postCard
                                let clone = row.cloneNode(true);

                                // Get root element of cloned template
                                let rootElement = clone.querySelector(':first-child');
                                rootElement.setAttribute('id','appointment_'+data.rows[i].app_id);
                                let row_data = JSON.stringify(data.rows[i]);
                                row_data = row_data.replaceAll('"','\\"');
                                rootElement.setAttribute('row',row_data);

                                table.appendChild(clone);
                            }
                            
                        } else {
                            
                            let row = document.createElement("tr");
                            let cell = document.createElement("td");
                            cell.colSpan = 7;
                            cell.textContent = "No match found";
                            row.appendChild(cell);
                            table.appendChild(row);
                        }
                    }
                }
            });

            ajax.open('post', 'ajax-admin.php', true);
            ajax.send(form);
        },

        view_appointment: function(id){

            document.querySelector(".js-view-patient").classList.remove('hide');
            //manage_admins.edit_id = id;

            let data = document.querySelector("#appointment_"+id).getAttribute("row");
            data = data.replaceAll('\\"','"');
            data = JSON.parse(data);
            console.log(data);
            if(typeof data == 'object') {

                document.querySelector(".js-view-appointment-schedule").innerHTML = data.app_date;
                document.querySelector(".js-view-timeslot").innerHTML = data.app_timeslot;
                document.querySelector(".js-view-patient-name").innerHTML = data.app_fname + ' ' + data.app_lname;
                document.querySelector(".js-view-gender").innerHTML = data.app_gender;

                let date = new Date(data.app_bdate);
                let formattedDate = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                document.querySelector(".js-view-dob").innerHTML = formattedDate;
                document.querySelector(".js-view-pnum").innerHTML = data.app_pnum;
                document.querySelector(".js-view-gmail").innerHTML = data.app_email;
                document.querySelector(".js-view-address").innerHTML = data.app_address;
                document.querySelector(".js-view-status").innerHTML = data.status;

            } else {
                alert("Invalid data");
            }
        },

        delete_appointment: function(){

            let selectedRows = document.querySelectorAll("#appointment_table .js-select-appointment:checked");
            if (selectedRows.length == 0) {
                alert("Please select at least one row to delete");
                return;
            }

            let ids = [];
            selectedRows.forEach(function(row) {
                let id = row.getAttribute("app_id");
                ids.push(id);
            });

            //console.log(JSON.stringify(ids));return;

            let form = new FormData();
            form.append('ids', JSON.stringify(ids));
            form.append('data_type', 'delete_appointment');

            let ajax = new XMLHttpRequest();
            ajax.addEventListener('readystatechange', function() {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if (obj.success) {

                            let table = document.querySelector("#appointment_table tbody");
                            table.innerHTML = "";
                            
                            appointment_list.load_appointments();
                            appointment_list.hide();
                        }
                    } else {
                        alert("Please check your internet connection");
                    }
                }
            });
            ajax.open('post', 'ajax-admin.php', true);
            ajax.send(form);
        },

        go_to_page: function(page) {

            this.current_page = page;
            this.load_appointments();
        },

        previous_page: function() {

            if (this.current_page > 1) {
                this.current_page--;
                this.load_appointments();
            }
        },

        next_page: function() {

            if (this.current_page < this.last_page) {
                this.current_page++;
                this.load_appointments();
            }
        },

        go_to_last_page: function() {
            
            this.current_page = this.last_page;
            this.load_appointments();
        },

        hide: function(){
            //document.querySelector(".js-add-admin").classList.add('hide');
            //document.querySelector(".js-edit-admin").classList.add('hide');
            document.querySelector(".js-view-patient").classList.add('hide');
        },

        select_all_appointments: function(source){
            let checkboxes = document.getElementsByName('all_appointments[]');
            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        },
    };

    appointment_list.load_appointments();
</script>
<script>
    let searchInput = document.getElementById('search-username');
    
    searchInput.addEventListener('input', function(event) {
        // Get the user's search query
        let query = event.target.value;
        
        if (query !== '') {
            document.getElementById('pagination').style.display = "none";

            // Call the allposts.search method with the user's query
            appointment_list.search_appointments(query);
        } else {
            document.getElementById('pagination').style.display = "";
            // Clear any existing posts and load the first 5 posts from the database
            appointment_list.current_page = 1;
            appointment_list.load_appointments();
        }
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#current-page').select2({
            placeholder: 'Select a page',
            allowClear: true
        });

        $('#current-page').on('change', function() {
            var page = $(this).val();
            if (page) {
                appointment_list.go_to_page(page);
            }
        });
    });
</script>
</body>
</html>