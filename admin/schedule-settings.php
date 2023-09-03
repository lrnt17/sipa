<?php 
    require('../connect.php');
    require('../functions.php');

    $user_place = $_SESSION['USER']['city_municipality'];
    $user_work_at = $_SESSION['USER']['health_facility_name'];

    $query = "select * from schedule_settings where city_municipality = '$user_place' && health_facility_name = '$user_work_at' limit 1";
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
        <?=$_SESSION['USER']['health_facility_name']; ?><br>
        <?=$row['schedule_settings_id']?>
        <?=$row['city_municipality']?>
        <?=$row['health_facility_name']?>
        <?=$row['duration']?>
        <?=$row['start_at']?>
        <?=$row['end_at']?>
        <?=$row['max_slot']?>

        <form method="post">
            <div>
                <h1>Time Schedule</h1>
                <!--<label for="startHourSelector">Select a start hour:</label>-->
                <select id="startHourSelector" name="start_at">
                    <!-- Options for the start hour -->
                </select> AM -

                <!--<label for="endHourSelector">Select an end hour:</label>-->
                <select id="endHourSelector" name="end_at">
                    <!-- Options for the end hour -->
                </select> PM

                <br>
                <label for="max_slots">Maximum number of slots per Hour:</label>
                <input type="number" name="max_slots" class="js-num-slots" min="0" value="<?=$row['max_slot']?>">
                <button>Save</button>
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
</html>