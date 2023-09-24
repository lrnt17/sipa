<?php 
    require('../connect.php');
    require('../functions.php');
    require('fetch_user_and_partner_info.php');

    //$city = $_SESSION['USER']['city_municipality'];
    //$facility_name = $_SESSION['USER']['health_facility_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment List | SiPa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
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
        @keyframes appear{
			0%{
				opacity: 0;
			}
			100%{
				opacity: 1;
			}
		}

        .block{
            display: block;
        }

        .hide{
            display: none;
        }

        table{
            table-layout: fixed;
        }

        td{
            width: 33%;
        }

        .today{
            color: orange;
        }

        
        .new-dates:hover{
            background-color: purple;
            color: white;
            cursor: pointer;
        }

        .old-dates {
            /* Style for dates that are less than the current date */
            color: gray;
        }

        .fullybooked-dates {
            color: red;
        }

        .selected {
            color: white;
            background-color: purple;
        }

        .selected-timeslot{
            color: white;
            background-color: purple;
        }

        .weekend-dates{
            opacity: 0.3;
            background-color: gray;
        }

        .current-date{
            color: orange;
        }

        .booked{
            background-color: red;
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
            <br><br>

            Show <select id="num_rows_displayed" onchange="appointment_list.num_rows_displayed(this.value)">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select> entries
            
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
        <div class="js-view-appointment hide">
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
                <div>Privacy Policy: <span class="js-view-privacy-policy"></span></div>
            </div>
        </div>

        <!-- Editing patient modal -->
        <div class="js-edit-appointment hide">
            <div class="" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="appointment_list.hide()">X</div>
            <h1>Edit Appointment Details</h1>
            <form onsubmit="appointment_list.save_updated_appointment(event)" method="post">
                <div class="form">
                    <label for="edit_fname">First Name *</label>
                    <input type="text" name="edit_fname" class="js-edit-fname edit-appointment" required>
                </div>
                <div class="form">
                    <label for="edit_lname">Last Name *</label>
                    <input type="text" name="edit_lname" class="js-edit-lname edit-appointment" required>
                </div>
                <div class="form">
                    <label for="edit_gmail">Gmail Address *</label>
                    <input type="email" name="edit_gmail" class="js-edit-gmail edit-appointment" required>
                </div>
                <div class="form">
                    <label for="edit_pnum">Phone Number *</label>
                    <input type="number" name="edit_pnum" class="js-edit-pnum edit-appointment" required>
                </div>
                <div class="form">
                    <label for="edit_gender">Gender</label>
                    <select name="edit_gender" id="edit_gender" class="js-edit-gender edit-appointment" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form">
                    <label for="edit_dob">Date of Birth</label>
                    <input type="date" name="edit_dob" class="js-edit-dob edit-appointment">
                </div>
                <div class="form">
                    <label for="edit_address">Address</label>
                    <input type="text" name="edit_address" class="js-edit-address edit-appointment">
                </div>
                <div class="form">
                    <label for="edit_status">Status</label>
                    <select name="edit_status" id="edit_status" class="js-edit-status edit-appointment" required>
                        <option value="Pending">Pending</option>
                        <option value="Confirmed">Confirmed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="calendar-layout-container">
                    <div class="row">
                        <button class='btn btn-xs btn-primary' type="button" onclick="appointment_list.showPreviousMonth()">Previous Month</button>
                        <button class='btn btn-xs btn-primary' type="button" onclick="appointment_list.showThisMonth()">Current Month</button>
                        <button class='btn btn-xs btn-primary' type="button" onclick="appointment_list.showNextMonth()">Next Month</button>
                        <div class="col-md-12 calendar-layout">
                            <!-- Calendar Layout display-->
                        </div>
                    </div>
                </div>
                <div class="timeslots"></div>


                <div class="">
                    <button class="">Save</button>
                </div>
            </form>
        </div>
    </section>

    <template id="appointments-template">
        <tr style="animation: appear 3s ease;">
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
    var appointment_admin_list = true;
    let city_municipality = '<?php echo $city; ?>';
    let health_facility = '<?php echo $facility_name; ?>';
    let current_page = 1;
    let last_page = 0;
    let dateComponents = new Date();
    let month = dateComponents.getMonth() + 1; // JavaScript months are 0-based
    let year = dateComponents.getFullYear();
    /*var appointment_list = {

        edit_id: '',
        current_page: 1,
        last_page: 0,

        load_appointments: function(e){

            let city_municipality = '<?php //echo $city; ?>';
            let health_facility = '<?php //echo $facility_name; ?>';
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

            let city_municipality = '<?php// echo $city; ?>';
            let health_facility = '<?php //echo $facility_name; ?>';

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

            document.querySelector(".js-view-appointment").classList.remove('hide');
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

        edit_appointment: function(id){

            document.querySelector(".js-edit-appointment").classList.remove('hide');
            appointment_list.edit_id = id;

            let data = document.querySelector("#appointment_"+id).getAttribute("row");
            data = data.replaceAll('\\"','"');
            data = JSON.parse(data);
            console.log(data);return;
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
            document.querySelector(".js-edit-appointment").classList.add('hide');
            document.querySelector(".js-view-appointment").classList.add('hide');
        },

        select_all_appointments: function(source){
            let checkboxes = document.getElementsByName('all_appointments[]');
            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        },
    };

    appointment_list.load_appointments();*/
</script>
<script src="appointment-list.js?v6"></script>
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