<?php 
    defined('APP') or die('direct script access denied!');
?>

<section class="js-sched-appointment-modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" onclick="sched_appointment.hide()">&times;</span>
        <form onsubmit="sched_appointment.submit_appointment(event)" id="multi-page-form">
            <!-- Page 1 -->
            <div class="page" id="page-1">
                <!-- Your form fields for page 1 here -->
                <label for="fname">First Name:</label><br>
                <input type="text" id="fname" name="fname" maxlength="30"><br>

                <label for="lname">Last Name:</label><br>
                <input type="text" id="lname" name="lname" maxlength="15"><br>

                <label for="address">Address:</label><br>
                <input type="text" id="address" name="address"><br>

                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email"><br>

                <label for="municipality">City/Municapality *</label><br>
                <select name="municipality" id="municipality" required>
                    
                </select><br>

                <div class="js-select-health-facility hide">
                    <label for="health_facility">Health Facility *</label><br>
                    <select name="health_facility" id="health_facility" required>
                        
                    </select>
                </div>
                
                <label for="contact">Contact:</label><br>
                +63 <input type="tel" id="contact" name="contact" maxlength="10"><br>

                <label for="gender">Gender:</label><br>
                <select id="gender" name="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select><br>

                <label for="dob">Date of Birth:</label><br>
                <input type="date" id="dob" name="dob"><br>

                <button type="button" onclick="sched_appointment.nextPage()">Next</button>
            </div>

            <!-- Page 2 -->
            <div class="page" id="page-2" style="display: none;">
                <!-- Your form fields for page 2 here -->
                <div class="container">
                    <div class="row">
                        <button class='btn btn-xs btn-primary' type="button" onclick="sched_appointment.showPreviousMonth()">Previous Month</button>
                        <button class='btn btn-xs btn-primary' type="button" onclick="sched_appointment.showThisMonth()">Current Month</button>
                        <button class='btn btn-xs btn-primary' type="button" onclick="sched_appointment.showNextMonth()">Next Month</button>
                        <div class="col-md-12 calendar-layout">
                            <!-- Calendar Layout display-->
                        </div>
                    </div>
                </div>
                <!--<button type="button" onclick="sched_appointment.prevPage()">Previous</button>-->
                <button type="button" onclick="sched_appointment.nextPage()">Next</button>
            </div>

            <!-- Page 3 (Final page) -->
            <div class="page" id="page-3" style="display: none;">
                <h1 class="js-selected-date"></h1>
                <!-- Your form fields for page 3 here -->
                <div class="timeslots"></div>
                <!--<button type="button" onclick="sched_appointment.prevPage()">Previous</button>-->
                <button>Submit</button>
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
<script src="sched-appointment.js?v8"></script>