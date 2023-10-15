<?php 
    require('../connect.php');
    require('../functions.php');
    require('fetch_user_and_partner_info.php');

    //$city = $_SESSION['USER']['city_municipality'];
    //$facility_name = $_SESSION['USER']['health_facility_name'];

    $query = "select * from schedule_settings where city_municipality = '$city' && health_facility_name = '$facility_name' limit 1";
	$row = query($query);

	if($row)
	{
		$row = $row[0];
        $startAt = date("H:i", strtotime($row['start_at']));
        $endAt = date("H:i", strtotime($row['end_at']));
	}

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $schedule_settings_id 		= $row['schedule_settings_id'];
        $start_at 		            = $_POST['start_at'];
		$end_at 		            = $_POST['end_at'];
        $max_slot 		            = $_POST['max_slots'];

        $query = "update schedule_settings set start_at = '$start_at', end_at = '$end_at', max_slot = '$max_slot' where schedule_settings_id = '$schedule_settings_id' limit 1";
        query($query);

        echo "<script>
                alert('Your account schedule settings is successfully saved');
                window.location.href='schedule-settings.php';
            </script>";
    }
    //echo $start_at;
    //echo $end_at;
    //echo $schedule_settings_id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Schedule Settings | SiPa</title>
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

        select{
            padding: 20px 0px 20px 20px;
            border: 2.2px solid #B9B9B9;
            font-size: 17px !important;
            outline: none;
            background:transparent;
            width: 200px;
        }

        .js-num-slots{
            width: 100px;
            padding: 0px 0px 2px 40px;
            border:none;
            border-bottom: 2.2px solid #B9B9B9;
            font-size: 16px;
            outline: none;
            background:transparent;

        }
    </style>
    <style>
        .hide{
            display: none;
        }
    </style>
    <style>
    .cbox{
        width:auto;
    }
    .modal4 {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 150px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .content-modal4 {
    background-color: #fefefe;
    margin: auto;
    width: 60%; /* Reduce the width of the modal */
    max-height: 80vh; /* Set maximum height for the modal */
    overflow-y: auto; /* Enable vertical scrollbar if content exceeds the height */
    border-radius: 40px;
    box-shadow: 0 0 5px rgba(0,0,0,.3);
    padding: 4%;
    padding-right: 4%; /* Add padding to the right side */
    overflow-y: auto;
        }

    .close-terms-con {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-terms-con:hover,
    .close-terms-con:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

        /* The close-terms-con Button */
        .close-terms-con {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        .close-terms-con:hover,
        .close-terms-con:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
        }

    @media (max-width: 768px) {
    .content-modal4{
        width:90%;

    }
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
        

        <form method="post">
            <div class="container">
                <div class="row flex-nowrap" style="align-items: center; margin-top:85px;">
                    <div class="col-auto">
                        <div class="vl" style="width: 10px;
                        background-color: #1F6CB5;
                        border-radius: 99px;
                        height: 80px;
                        display: -webkit-inline-box;"></div>
                    </div>
                
                    <div class="col-auto mt-1">
                        <div class="row">
                            <div class="col-auto">
                                <h2 style="font-weight: 400;"><b>Time</b> Schedule</h2>
                                <p style="display: inline;">Customize RHU's appointment system business hours and the number of slots available per hour.</p><div id="myBtn4" style="background: transparent; color: white; border: none; margin-left:10px; display: inline;cursor: pointer;"><i class="fa-solid fa-circle-info"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <section id="myModal4" class="modal4">
                    <!-- Modal content -->
                    <div class="content-modal4">
                        <span class="close-terms-con">&times;</span>
                        <div class="scrollable-content">
                        <h3 class="mt-4">Instructions</h3>
                        <p align="justify" class="mb-4">
                        <br>Set the opening and closing times by navigating to the “Business Hours” section. Click on the “Opening Time” field and select your desired opening time from the dropdown menu. Do the same for the “Closing Time” field.

                            <br><br>Next, set the number of slots available each hour. Go to the “Slots Per Hour” section and click on the “Number of Slots” field. Enter your preferred number of slots per hour. Click on the “Save” button to apply these changes.
                        </p>
                    </div>
                </section>
                <br>
                <div class="container" >
                    
                    <div class="con p-4 rounded-4 shadow-sm" style="background-color:white; width: 60%;     min-width: 258px;">
                        <!--<label for="startHourSelector">Select a start hour:</label>-->
                        
                        <h4 class="pb-2">Business Hours</h4>
                        <div class="row mt-4" style="justify-content:center;">
                            <div class="col-auto">
                                <h6 style="text-align: center; font-weight:400;">Opening time</h6>
                                <select class="mb-2 rounded-4 shadow-sm" id="startHourSelector" name="start_at">
                                    <!-- Options for the start hour -->
                                </select>
                            </div>
                            <div class="col-xl-auto" style="
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "><h6 class="my-4" style="text-align: center;"></h6></div>
                            <div class="col-auto">
                                <h6 style="text-align: center; font-weight:400;">Closing time</h6>
                                <select class="mb-2 rounded-4 shadow-sm" id="endHourSelector" name="end_at">
                                    <!-- Options for the end hour -->
                                </select>
                            </div>
                        </div>

                        <br>
                        <h4 class="pt-3">Slots Per Hour</h4>
                        <label for="max_slots">Maximum number of slots per Hour:</label>
                        <input type="number" name="max_slots" class="js-num-slots" min="0" value="<?=$row['max_slot']?>">
                        <br>
                        <div class="class_37 d-flex flex-row-reverse">
                            <button class="class_38 btn px-5 my-3" style="background-color: #F2C1A7; color:#ffff;">Save</button>
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
        </form>
    </section>

</body>
<script>
    var sched_settings = {

        time_schedule:function () {
            // Get references to the select elements
            let startSelect = document.getElementById("startHourSelector");
            let endSelect = document.getElementById("endHourSelector");

            // Function to generate options from 06:00 to 20:00
            function generateOptions(selectElement) {
                for (var hour = 6; hour <= 20; hour++) {
                    let option = document.createElement("option");
                    let formattedHour = `${hour.toString().padStart(2, '0')}:00`;
                    option.value = formattedHour;
                    option.text = formattedHour;
                    selectElement.appendChild(option);
                }
            }

            // Populate both select elements with options
            generateOptions(startSelect);
            generateOptions(endSelect);

            // Add event listener to start select to disable options in end select
            startSelect.addEventListener("change", function () {
                let selectedStartHour = parseInt(this.value.split(":")[0], 10);

                // Enable all options in end select
                for (var i = 0; i < endSelect.options.length; i++) {
                    endSelect.options[i].disabled = false;
                }

                // Disable options less than or equal to the selected start hour
                for (var i = 6; i <= selectedStartHour; i++) {
                    let optionIndex = i - 6; // Calculate the index based on the hour
                    endSelect.options[optionIndex].disabled = true;
                }

                // Automatically set the end select to the next hour
                //let nextHour = selectedStartHour + 1;
                //endSelect.value = `${nextHour.toString().padStart(2, '0')}:00`;
                //endSelect.value = '<?php //echo $endAt; ?>';
            });

            // Set the selected values from PHP
            startSelect.value = '<?php echo $startAt; ?>';
            endSelect.value = '<?php echo $endAt; ?>';

            // Trigger the change event on page load to set the initial state
            startSelect.dispatchEvent(new Event("change"));
        },
    };

    sched_settings.time_schedule();
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

<script>
document.addEventListener("DOMContentLoaded", function() {
    var modal4 = document.getElementById("myModal4");
    var btn4 = document.getElementById("myBtn4");
    var span4 = document.getElementsByClassName("close-terms-con")[0];

    // When the user clicks the button, open the modal
    btn4.onclick = function() {
        modal4.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span4.onclick = function() {
        modal4.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal4) {
            modal4.style.display = "none";
        }
    }
});
</script>

</html>