<?php 
    defined('APP') or die('direct script access denied!');
?>
<script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>

<style>
    .container-row{
        display: flex;
        justify-content: space-between;
    }
    input{
        width: 85%;
        border: none;
        border-bottom: 2px solid #B9B9B9;
        padding: 1px 0px 0px 30px;
        font-size: 1.3rem;
        border-radius: 0px;
        background: transparent;
        outline: none;
    }
    .row{
        margin-bottom:30px;
    }

    select {

        /* styling */
        background-color: white;
        border: thin solid #B9B9B9;
        border-radius: 4px;
        display: inline-block;
        font: inherit;
        line-height: 1.5em;
        padding: 0.5em 3.5em 0.5em 1em;
        width: 85%;
        /* reset */

        margin: 0;      
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    select.minimal {
        background-image:
            linear-gradient(45deg, transparent 50%, gray 50%),
            linear-gradient(135deg, gray 50%, transparent 50%),
            linear-gradient(to right, #ccc, #ccc);
        background-position:
            calc(100% - 20px) calc(1em + 2px),
            calc(100% - 15px) calc(1em + 2px),
            calc(100% - 2.5em) 0.5em;
        background-size:
            5px 5px,
            5px 5px,
            1px 1.5em;
        background-repeat: no-repeat;
        }

        select.minimal:focus {
        background-image:
            linear-gradient(45deg, blue 50%, transparent 50%),
            linear-gradient(135deg, transparent 50%, blue 50%),
            linear-gradient(to right, #ccc, #ccc);
        background-position:
            calc(100% - 15px) 1em,
            calc(100% - 20px) 1em,
            calc(100% - 2.5em) 0.5em;
        background-size:
            5px 5px,
            5px 5px,
            1px 1.5em;
        background-repeat: no-repeat;
        border-color: blue;
        outline: 0;
    }
    

    @media (max-width: 768px) {
        .container-row{

        }
    }

</style>
<section class="js-sched-appointment-modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" onclick="sched_appointment.hide()">&times;</span>
        <form onsubmit="sched_appointment.submit_appointment(event)" id="multi-page-form">


            <!-- Page 1 -->
            <div class="page" id="page-1" style="padding: 2% 5%;">
                <!-- Your form fields for page 1 here -->
                <div class="container">
                <center>
                    <h3>Schedule an Appointment</h3>
                </center>
                <br><br>
                <div class="row container-row">
                    <div class="col" style="
                        min-width: 50%;
                    ">
                        <div class="row">
                            <label class="label-1" for="fname">First Name:</label><br>
                            <i class="fa-solid fa-user" style="position: absolute; margin-left: 9px;"></i>
                            <input type="text" id="fname" name="fname" maxlength="30"><br>
                        </div>

                        <div class="row">
                            <label class="label-1" for="address">Address:</label><br>
                            <i class="fa-solid fa-map" style="position: absolute; margin-left: 9px;"></i>
                            <input type="text" id="address" name="address"><br>
                        </div>

                        <div class="row">
                            <label class="label-1" for="contact">Contact:</label><br>
                            <i class="fa-solid fa-phone" style="position: absolute; margin-left: 9px;"></i>
                            <p style="position: absolute; margin-left: 33px; font-size: 14px;">+63</p>
                            <input type="tel" id="contact" name="contact" maxlength="10" style="padding: 0px 0px 2px 66px;"><br>
                        </div>

                        <div class="row">
                            <label class="label-1" for="gender">Gender:</label><br>
                            <select id="gender" name="gender" class="minimal">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select><br>
                        </div>

                        <!--<div class="row" style="margin-bottom:10px;">
                            <div class="js-select-health-facility hide">
                                <label class="label-1" for="health_facility">Health Facility <span style="color: #B12229;">*</span></label><br>
                                <select name="health_facility" id="health_facility" required class="minimal">
                                </select>
                            </div>
                        </div>-->

                        <div class="row" style="margin-bottom:10px;">
                            <div class="js-select-barangay hide">
                                <label class="label-1" for="barangay">Barangay <span style="color: #B12229;">*</span></label><br>
                                <select name="barangay" id="barangay" required class="minimal">
                                </select>
                            </div>
                        </div>
                            
                    </div>

                    <div class="col" style="
                        min-width: 50%;
                    ">
                        <div class="row">
                            <label class="label-1" for="lname">Last Name:</label><br>
                            <i class="fa-solid fa-user" style="position: absolute; margin-left: 9px;"></i>
                            <input type="text" id="lname" name="lname" maxlength="15"><br>
                        </div>

                        <div class="row">
                            <label class="label-1" for="email">Email:</label><br>
                            <i class="fa-solid fa-envelope" style="position: absolute; margin-left: 9px;"></i>
                            <input type="email" id="email" name="email"><br>
                        </div>

                        <div class="row">
                            <label class="label-1" for="dob">Date of Birth:</label><br>
                            <i class="fa-solid fa-cake-candles" style="position: absolute; margin-left: 9px;"></i>                            
                            <input type="date" id="dob" name="dob"><br>
                        </div>

                        <div class="row">
                            <label class="label-1" for="municipality">City/Municapality <span style="color: #B12229;">*</span></label><br>
                            <select name="municipality" id="municipality" required class="minimal"> </select>
                        </div>

                        <div class="row" style="margin-bottom:10px;">
                            <div class="js-select-health-facility hide">
                                <label class="label-1" for="health_facility">Health Facility <span style="color: #B12229;">*</span></label><br>
                                <select name="health_facility" id="health_facility" required class="minimal">
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

                
            <div class="btn-div"style="display: flex; justify-content: flex-end;">
                <button type="button" class="btn"onclick="sched_appointment.nextPage()"style="
                    display: block;
                    width: 20%;
                    padding: 10px;
                    text-align: center;
                    border: none;
                    background: #F2C1A7;
                    outline: none;
                    border-radius: 10px;
                    font-size: 1.4rem;
                    color: #FFF;
                    cursor: pointer;
                    ">Next</button>
            </div>
                
            </div>

            <!-- Page 2 -->
            <div class="page" id="page-2" style="display: none;">
            <center><p style="margin: 10px 20px 0px 20px; color: #1b4ca1; text-wrap: wrap;">Please select your preferred appointment date.</p></center>
                <!-- Your form fields for page 2 here -->
                <div class="container">
                    <div class="row">
                        <div class="month" style="
                            display: flex;
                            justify-content: space-between;
                            padding: 10px 20px 0px 20px;
                        ">
                        <button class='btn' type="button" onclick="sched_appointment.showPreviousMonth()" style="
                            
                            background: transparent;
                            outline: none;
                        "><i class="fa-solid fa-chevron-left" style="position: relative;
                        margin-left: 0px; font-size: large;"></i></button>
                        <button class='btn' type="button" onclick="sched_appointment.showNextMonth()" style="
                            
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
                <!--<button type="button" onclick="sched_appointment.prevPage()">Previous</button>-->
                <div class="btn-div"style="display: flex; justify-content: flex-end;">
                    <button type="button" onclick="sched_appointment.nextPage()" style="
                        display: block;
                        width: 20%;
                        padding: 10px;
                        text-align: center;
                        border: none;
                        background: #F2C1A7;
                        outline: none;
                        border-radius: 10px;
                        font-size: 1.4rem;
                        color: #FFF;
                        cursor: pointer;
                        ">Next</button>
                </div>
            </div>

            <!-- Page 3 (Final page) -->
            <div class="page" id="page-3" style="display: none;">

                <center><p style="margin: 10px 20px 0px 20px; color: #1b4ca1; text-wrap: wrap;">
                   Kindly pick a suitable time slot for your appointment from the available options below.</p></center>
                
                <center>
                    <h1 class="js-selected-date"></h1>
                </center>
                <!-- Your form fields for page 3 here -->
                <div class="timeslots" style="
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;"></div>
                <div class="appointment_data_privacy" style="margin-top: 30px;">
                    <input type="checkbox" name="appointment_data_privacy" id="appointment_data_privacy" value="I agree" required style="width: 15px;">
                    <label for="appointment_data_privacy" style="position:relative;font-size: 15px;font-weight: 500;">I have read and agree to the Privacy Policy in accordance with the Data Privacy Act of 2012.</label>  
                </div>
                <!--<button type="button" onclick="sched_appointment.prevPage()">Previous</button>-->
                <div class="btn-div"style="display: flex; justify-content: flex-end;">
                    <button style="
                        display: block;
                        width: 20%;
                        padding: 10px;
                        margin-top:15px;
                        text-align: center;
                        border: none;
                        background: #F2C1A7;
                        outline: none;
                        border-radius: 10px;
                        font-size: 1.4rem;
                        color: #FFF;
                        cursor: pointer;
                        ">Submit</button>
                </div>
            </div>
            
        </form>
    </div>
</section>

<script>
    var appointment = true;
    let currentPage = 1;
    let totalPages = 3;
    var dateComponents = new Date();
    let month = dateComponents.getMonth() + 1; // JavaScript months are 0-based
    let year = dateComponents.getFullYear();

    // Get the modal
    /*var modal = document.querySelector(".js-sched-appointment-modal");
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.classList.add('hide');
        }
    }*/
</script>
<script src="sched-appointment.js?v13"></script>