<?php 
    defined('APP') or die('direct script access denied!');
?>

<head>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
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

        .btn-success{
            color: black !important;
            background-color: #d2e0f8 !important;
            border-color: #d2e0f8 !important;
        }

        .btn-success:hover{
            color: white !important;
            background-color: #CAA4D0 !important;
            border-color: #d2e0f8 !important;
        }

        .span_time{
            pointer-events: none;
        }

        .span_slots{
            pointer-events: none;
        }

        tbody{
            text-align: center;
        }

        table{
            table-layout: fixed;
        }

        td{
            font-size:14px;
        }

        .today{
            color: #F0C2A9;
        }

        
        .new-dates:hover{
            background-color: #CAA4D0;
            color: white;
            cursor: pointer;
        }

        .old-dates {
            color: gray !important;
        }

        .fullybooked-dates {
            color: red;
        }

        .selected {
            color: white !important;
            background-color: #b88fbf !important;
        }

        .selected-timeslot{
            color: white !important;
            background-color: #b88fbf !important;
        }

        .weekend-dates{
            opacity: 0.3;
            background-color: gray;
        }

        .current-date{
            color: orange !important;
            opacity: 10;
        }

        .booked{
            background-color: red;
        }

        .edit{
            border-bottom: 1px solid black !important;
            height: 75px;
        }
        tr {
            border: none !important;
        }

        thead, tbody, tfoot, tr, td, th {
            border-style: none !important;
        }

        th{
            text-align: center;   
        }
    </style>
    <style>
        .header{
            text-align:center;
            color: #184DA8 !important;
            font-weight: 600;
            font-size:14px;
        }
    </style>
    <style>
        .js-view-appointment, .js-edit-appointment, .js-create-new-appointment {
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 40px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .view-container, .edit-container, .create-new-container {
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
            .view-container, .edit-container {
            width: 90% !important;
            
            }
        }

        .select2-selection__clear{
            display:none;
        }

        .edit-appointment{
            width: 100%;
            padding: 0px 0px 2px 0px;
            border: none;
            border-bottom: 2.2px solid #B9B9B9;
            font-size: 15px;
            outline: none;
            margin: 10px 30px 15px 0px;
        }
    </style>
    <style>
        .form .fa-solid{
        position: absolute;
        top:20px;
        left: 20px;
        color: #9ca3af;


        }
        input:focus{
            outline:none;
        }
    </style>
</head>

<section id="current-date-appointment">
    <div class="container" style="flex-wrap: wrap;">

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
                        <h2 style="font-weight: 400;"><b>Todays Appointments</b> List</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row height d-flex justify-content-center align-items-center">

                <div class="d-flex mt-2">
                    <div class="form" style="position: relative;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="search-username"  class="form-input rounded-pill shadow-sm" placeholder="Search by first name, last name, schedule, or status" style="height: 57px; text-indent: 52px;width: 455px; border: none;">
                    </div>
                    
                </div>
            </div>

            <button type="button" onclick="todays_appointment_list.add_appointment()" class="">+ Create New</button>
        </div>

        <div class="container mt-1 mb-2">
            <label for="" class="me-2">Show</label> 
                <select id="num_rows_displayed" onchange="todays_appointment_list.num_rows_displayed(this.value)">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            <label for="" class="ms-2">entries</label>
        </div>


        <br>
        <table cellspacing="0" cellpadding="10" id="appointment_table" style="border: none; width: 100%;">
            <thead style="text-align: ; height:50px; font-size: 15px;">
                <tr class="edit">
                    <th style="text-align: center; width: 10%; "><input type="checkbox" id="select-all-appointment" onclick="todays_appointment_list.select_all_appointments(this);"></th>
                    <th style="width: 10%;">ID 
                        <button onclick="todays_appointment_list.sortTable('app_id', 'asc')" class="btn" style="padding: 0px;"><i class="fa-regular fa-square-caret-up"></i></button>
                        <button onclick="todays_appointment_list.sortTable('app_id', 'desc')" class="btn" style="padding:0px;"><i class="fa-regular fa-square-caret-down"></i></button>
                    </th>

                    <th style="width: 20%;">First Name 
                        <button onclick="todays_appointment_list.sortTable('app_fname', 'asc')" class="btn" style="padding: 0px;"><i class="fa-regular fa-square-caret-up"></i></button> 
                        <button onclick="todays_appointment_list.sortTable('app_fname', 'desc')" class="btn" style="padding:0px;"><i class="fa-regular fa-square-caret-down"></i></button>
                    </th>

                    <th style="width: 20%;">Last Name 
                        <button onclick="todays_appointment_list.sortTable('app_lname', 'asc')" class="btn" style="padding: 0px;"><i class="fa-regular fa-square-caret-up"></i></button> 
                        <button onclick="todays_appointment_list.sortTable('app_lname', 'desc')" class="btn" style="padding: 0px;"><i class="fa-regular fa-square-caret-down"></i></button>
                    </th>

                    <th style="width: 20%;">Schedule 
                        <button onclick="todays_appointment_list.sortTable('app_date', 'asc')" class="btn" style="padding: 0px;"><i class="fa-regular fa-square-caret-up"></i></button> 
                        <button onclick="todays_appointment_list.sortTable('app_date', 'desc')" class="btn" style="padding: 0px;"><i class="fa-regular fa-square-caret-down"></i></button>
                    </th>

                    <th style="width: 15%;">Status 
                        <button onclick="todays_appointment_list.sortTable('status', 'asc')" class="btn" style="padding: 0px;"><i class="fa-regular fa-square-caret-up"></i></button> 
                        <button onclick="todays_appointment_list.sortTable('status', 'desc')" class="btn" style="padding: 0px;"><i class="fa-regular fa-square-caret-down"></i></button>
                    </th>

                    <th class="pe-3" style="width: 15%;">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <br>
        <!-- Delete button -->
        <div onclick="todays_appointment_list.delete_appointment()" class="ps-4 mt-3" style="cursor:pointer;color:red;" id="delete-positive">Delete</div>
        <br>
        <div class="container" style="display:flex; justify-content:center;">
            <div class="js-entry-range" style="color: #505050;font-size: 15px;"></div>
        </div>


        <br>

        <div class="btn-toolbar justify-content-between" style="align-items: baseline; width:100%;">
            <div class="btn-group" id="pagination" role="group" aria-label="First group">
                <button type="button" onclick="todays_appointment_list.go_to_page(1)" class="btn btn-outline-secondary">First Page</button>
                <button type="button" onclick="todays_appointment_list.previous_page()" class="btn btn-outline-secondary">Prev</button>
                <button type="button" onclick="todays_appointment_list.next_page()"  class="btn btn-outline-secondary">Next</button>
                <button type="button" onclick="todays_appointment_list.go_to_last_page()" class="btn btn-outline-secondary">Last Page</button>
            </div>
            <div class="input-group">
                <p class="pe-2">Page</p>
                <select id="current-page" style="width:60px;" onchange="todays_appointment_list.go_to_page(this.value)">
                    <!-- Add options for each page here -->
                </select>
            </div>
        </div>

        <!-- create new appointment modal -->
        <div class="js-create-new-appointment hide">
            <div class="create-new-container">
                <div class="close-btn" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="todays_appointment_list.hide()">&times;</div>
                <div class="row flex-nowrap mt-4" style="align-items: center;">
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
                                <h2 style="font-weight: 400;">Create New Appointment</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="container ms-4 ps-4 pe-4 appointment-form"  style="width: 94%; display: flex; flex-wrap: wrap;" onsubmit="todays_appointment_list.create_new_appointment(event)" method="post">
                    <input type="hidden" name="selected_municipality" class="js-city-municipality create-new-appointment" value="<?php echo $city; ?>">
                    <input type="hidden" name="selected_health_facility" class="js-health-facility create-new-appointment" value="<?php echo $facility_name; ?>">
                    <input type="hidden" name="appointment_data_privacy" class="js-appointment-data-privacy create-new-appointment" value="I agree">
                    <div class="row" style="width: 100%;">
                        <div class="col">
                            <div class="form">
                                <label for="fname" style="font-size: 15px;">First Name <span style="color:red;">*</span></label>
                                <input type="text" name="fname" class="js-fname create-new-appointment" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form">
                                <label for="lname" style="font-size: 15px;">Last Name <span style="color:red;">*</span></label>
                                <input type="text" name="lname" class="js-lname create-new-appointment" required>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="width: 100%;">
                        <div class="col">
                            <div class="form">
                                <label for="address" style="font-size: 15px;">Address <span style="color:red;">*</span></label>
                                <input type="text" name="address" class="js-address create-new-appointment" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form">
                                <label for="dob" style="font-size: 15px;">Date of Birth <span style="color:red;">*</span></label>
                                <input type="date" name="dob" class="js-dob create-new-appointment" required>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="width: 100%;">
                        <div class="col">
                            <div class="form">
                                <label for="email" style="font-size: 15px;">Email Address  <span style="color:red;">*</span></label>
                                <input type="email" name="email" class="js-gmail create-new-appointment" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form">
                                <label for="pnum" style="font-size: 15px;">Phone Number <span style="color:red;">*</span></label>
                                <div style="display: flex; align-items: center;">
                                    <p style="font-size: 15px; margin-right: 5px; margin-top: 7px;">+63</p>
                                    <input type="text" name="contact" class="js-pnum create-new-appointment" required style="" maxlength="10" minlength="10">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="width: 100%;">
                        <div class="col">
                            <div class="form">
                            <label for="gender" style="font-size: 15px;">Gender <span style="color:red;">*</span></label>
                                <select name="selected_gender" id="gender" class="js-gender create-new-appointment" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form">
                                <label for="new_barangay" style="font-size: 15px;">Barangay <span style="color:red;">*</span></label>
                                <select name="selected_barangay" id="new_barangay" required class="class_33">
                                    <!-- list of barangays -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="calendar-layout-container">
                        <div class="row">
                            <div class="month" style="
                                display: flex;
                                justify-content: space-between;
                                padding: 10px 20px 0px 20px;
                            ">
                            <button class='btn' type="button"  onclick="todays_appointment_list.showPreviousMonthNewAppointment()" style="
                                
                                background: transparent;
                                outline: none;
                            "><i class="fa-solid fa-chevron-left" style="position: relative;
                            margin-left: 0px; font-size: large;"></i></button>
                            <button class='btn' type="button" onclick="todays_appointment_list.showNextMonthNewAppointment()" style="
                                
                                background: transparent;
                                outline: none;
                            "><i class="fa-solid fa-chevron-right" style="position: relative;
                            margin-left: 0px; font-size: large;"></i></button>
                            </div>
                            <div class="col-md-12 calendar-layout-new">
                                <!-- Calendar Layout display-->
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="timeslots-new hide"></div>

                    <div  class="class_45 d-flex flex-row-reverse" style="width: 94%;">
                        <button class=" btn px-5" style="background-color: #F2C1A7; color:#ffff;">Submit</button>
                    </div>
                    
                </form>
            </div>
        </div>

        <!-- View patient details modal -->
        <div class="js-view-appointment hide">
            <div class="view-container">
                <div class="close-btn" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="todays_appointment_list.hide()">&times;</div>
                    <div class="row flex-nowrap mt-4" style="align-items: center;">
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
                                    <h2 style="font-weight: 400;">Appointment Details</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="container ms-4 ps-4 mt-4">
                    <div style="font-size:17px;"><i class="fa-solid fa-clipboard-check me-2 my-2" style="padding-left: 2px;"></i> Appointment Schedule: <span class="js-view-appointment-schedule" style="color: #1F6CB5; font-weight:500;"></span></div>
                    <div style="font-size:17px;"> <i class="fa-solid fa-clock me-1 my-2"></i> Timeslot: <span class="js-view-timeslot" style="color: #1F6CB5; font-weight:500;"></span></div>
                    <div style="font-size: 17px;"><i class="fa-solid fa-check-to-slot my-2" style="padding-right: 2px;"></i> Status: <span class="js-view-status" style="color: #1F6CB5; font-weight:500;"></span></div>

                    <div class="row my-3 mt-4">
                        <div class="col">
                            <div style="font-size: 15px;">Patient Name <br><span class="js-view-patient-name" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                        <div class="col">
                            <div style="font-size: 15px;">Gender<br> <span class="js-view-gender" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <div style="font-size: 15px;">Date of Birth <br> <span class="js-view-dob" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                        <div class="col">
                            <div style="font-size: 15px;">Phone Number <br> <span style="font-size: 16px;color: #1F6CB5;">+63</span><span class="js-view-pnum" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <div style="font-size: 15px;">Address <br><span class="js-view-address" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                        <div class="col">
                            <div style="font-size: 15px;">Barangay <br><span class="js-view-barangay" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <div style="font-size: 15px;">Gmail Address <br> <span class="js-view-gmail" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                        <div class="col">
                            <div style="font-size: 15px;">Privacy Policy <br> <span class="js-view-privacy-policy" style="font-size: 16px;color: #1F6CB5;"></span></div>
                        </div>
                    </div>



                </div>
            </div>
        </div>

        <!-- Editing patient modal -->
        <div class="js-edit-appointment hide">
            <div class="edit-container">
                <div class="close-btn" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="todays_appointment_list.hide()">&times;</div>
                <div class="row flex-nowrap mt-4" style="align-items: center;">
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
                                    <h2 style="font-weight: 400;">Edit Appointment Details</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                <form class="container ms-4 ps-4 pe-4"  style="width: 94%; display: flex;
                flex-wrap: wrap;" onsubmit="todays_appointment_list.save_updated_appointment(event)" method="post">
                    <input type="hidden" name="edit_city_municipality" class="js-edit-city-municipality edit-appointment">
                    <input type="hidden" name="edit_health_facility" class="js-edit-health-facility edit-appointment">
                <div class="row" style="width: 100%;">
                            <div class="col">
                                <div class="form">
                                    <label for="edit_fname" style="font-size: 15px;">First Name <span style="color:red;">*</span></label>
                                    <input type="text" name="edit_fname" class="js-edit-fname edit-appointment" disabled required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form">
                                    <label for="edit_lname" style="font-size: 15px;">Last Name <span style="color:red;">*</span></label>
                                    <input type="text" name="edit_lname" class="js-edit-lname edit-appointment" disabled required>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="width: 100%;">
                            <div class="col">
                                <div class="form">
                                    <label for="edit_gmail" style="font-size: 15px;">Email Address  <span style="color:red;">*</span></label>
                                    <input type="email" name="edit_gmail" class="js-edit-gmail edit-appointment" disabled required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form">
                                    <label for="edit_pnum" style="font-size: 15px;">Phone Number <span style="color:red;">*</span></label>
                                    <div style="display: flex; align-items: center;">
                                        <p style="font-size: 15px; margin-right: 5px; margin-top: 7px;">+63</p>
                                        <input type="number" name="edit_pnum" class="js-edit-pnum edit-appointment" required disabled style="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="width: 100%;">
                            <div class="col">
                                <div class="form">
                                <label for="edit_gender" style="font-size: 15px;">Gender</label>
                                    <select name="edit_gender" id="edit_gender" class="js-edit-gender edit-appointment" disabled required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form">
                                    <label for="edit_dob" style="font-size: 15px;">Date of Birth</label>
                                    <input type="date" name="edit_dob" class="js-edit-dob edit-appointment" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="width: 100%;">
                            <div class="col">
                                <div class="form">
                                    <label for="edit_address" style="font-size: 15px;">Address</label>
                                    <input type="text" name="edit_address" class="js-edit-address edit-appointment" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form">
                                    <label for="edit_barangay" style="font-size: 15px;">Barangay</label>
                                    <input type="text" name="edit_barangay" class="js-edit-barangay edit-appointment" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="width: 100%;">
                            <div class="col">
                                <div class="form">
                                    <label for="edit_status" style="font-size: 15px;">Status </label>
                                    <select name="edit_status" id="edit_status" class="js-edit-status edit-appointment" required>
                                        <option value="Pending">Pending</option>
                                        <option value="Confirmed">Confirmed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">

                            </div>
                        </div>

                    
                    <hr>
                    <div class="calendar-layout-container">
                        <div class="row">
                            <div class="month" style="
                                display: flex;
                                justify-content: space-between;
                                padding: 10px 20px 0px 20px;
                            ">
                            <button class='btn' type="button"  onclick="todays_appointment_list.showPreviousMonth()" style="
                                
                                background: transparent;
                                outline: none;
                            "><i class="fa-solid fa-chevron-left" style="position: relative;
                            margin-left: 0px; font-size: large;"></i></button>
                            <button class='btn' type="button" onclick="todays_appointment_list.showNextMonth()" style="
                                
                                background: transparent;
                                outline: none;
                            "><i class="fa-solid fa-chevron-right" style="position: relative;
                            margin-left: 0px; font-size: large;"></i></button>
                            </div>
                            <div class="col-md-12 calendar-layout">
                                <!-- Calendar Layout display-->
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="timeslots"></div>

                    <div  class="class_45 d-flex flex-row-reverse" style="width: 94%;">
                        <button class=" btn px-5" style="background-color: #F2C1A7; color:#ffff;">Save</button>
                    </div>
                    
                </form>
            </div>
        </div>

    </div>
</section>

<template id="appointments-template">
    <tr style="animation: appear 3s ease;" class="edit">
        <td align="center" id="checkbox" style="width: 10%;">
            <label class="container">
                <input type="checkbox" class="js-select-appointment" name="all_appointments[]">
                <span class="checkmark"></span>
            </label>
        </td>
        <td class="js-appointment-id" style="width: 10%;"></td>
        <td class="js-userfname" style="width: 20%;"></td>
        <td class="js-userlname" style="width: 20%;"></td>
        <td style="width: 20%;">
            <div class="js-appointment-date"></div>
            <div class="js-appointment-timeslot"></div>
        </td>
        <td class="js-appointment-status" style="width: 15%;"></td>
            <td style="width: 15%;">
                <div class="js-action-buttons class_51" >

                <!--3 dots-->
                <a data-toggle="dropdown" class="btn"><i class="fa-solid fa-ellipsis" style="font-size:14px;"></i></i></a>
                    
                    <!--div edit,del-->
                    <div class="container" style="padding: 0;">
                        
                        <!--ul element-->
                        <ul class="dropdown-menu dropdown-menu-right">
                            <div class="js-appointment-edit-btn dropdown-item" style="color:blue;cursor: pointer; font-size:14px;"  >
                                Edit
                            </div>
                            <div class="js-appointment-details-btn dropdown-item" style="cursor: pointer; font-size:14px;"  >
                                View Details
                            </div>
                        </ul>

                    </div>

                </div>
            </td>
    </tr>
</template>

<script>
    var todays_appointments_list = true;
    let partner_facility_id = '<?php echo $partner_facility_id; ?>';
    let city_municipality = '<?php echo $city; ?>';
    let health_facility = '<?php echo $facility_name; ?>';
    let current_page = 1;
    let last_page = 0;
    let dateComponents = new Date();
    let month = dateComponents.getMonth() + 1; // JavaScript months are 0-based
    let year = dateComponents.getFullYear();
</script>
<script src="current-date-appointments.js?v5"></script>
<script>
    let searchInput = document.getElementById('search-username');
    
    searchInput.addEventListener('input', function(event) {
        // Get the user's search query
        let query = event.target.value;
        
        if (query !== '') {
            //document.getElementById('pagination').style.display = "none";

            // Call the allposts.search method with the user's query
            todays_appointment_list.search_appointments(query);
        } else {
            //document.getElementById('pagination').style.display = "";
            // Clear any existing posts and load the first 5 posts from the database
            todays_appointment_list.search_appointments(null);
            todays_appointment_list.current_page = 1;
            todays_appointment_list.load_appointments();
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
                todays_appointment_list.go_to_page(page);
            }
        });
    });
</script>