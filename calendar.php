<?php 
    require("connect.php");
    require('functions.php');

    function build_calendar($month, $year, $duration, $cleanup, $start, $end){

        /*$query = "SELECT * FROM appointments WHERE MONTH(app_date) = $month AND YEAR(app_date) = $year";
        $rows = query($query);

        $dates = array();
        if (is_array($rows)) {
            foreach ($rows as $row) {
                $dates[] = $row['app_date'];
            }
        }*/

        // make an API request to the Holiday API
        /*$key = '2a22f66f-8af3-44a7-9a10-aabb3de76f3c';
        $holiday_api = new \HolidayAPI\Client(['key' => $key]);
        $holidays_data = $holiday_api->holidays([
            'country' => 'PH',
            'year' => $year,
        ]);

        // create an array of holiday dates
        $holidays = array();
        foreach ($holidays_data['holidays'] as $holiday) {
            $holidays[] = $holiday['date'];
        }*/

        //First, Create an array containing names of all days in a week
        //$daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $daysOfWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        
        //Then we'll get the first day of the month that is in the argument of this function
        $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

        //Now getting the number of days this month contains
        $numberDays = date('t', $firstDayOfMonth);

        //Getting some information about the first day of this month
        $dateComponents = getdate($firstDayOfMonth);

        //Getting the name of this month
        $monthName = $dateComponents['month'];

        //Getting the index value 0-6 of the first day of this month
        $dayOfWeek = $dateComponents['wday'];

        //Getting the current date
        $dateToday = date('Y-m-d');

        //Now creating the HTML table
        $calendar = "<table class='table table-bordered'>";
        $calendar.="<center><h2>$monthName $year</h2>";
 
        $calendar.="<tr>";

        //Creating the calendars headers
        foreach($daysOfWeek as $day){
            $calendar.="<th class='header'>$day</th>";
        }

        $calendar.= "</tr><tr>";

        //The variable $dayOfWeek will make sure that there must be only 7 columns on our table
        if($dayOfWeek > 0){
            for($k=0; $k<$dayOfWeek;$k++){
                $calendar.="<td></td>";
            }
        }

        //Initiating the day counter
        $currentDay = 1;

        //Getting the month number
        $month = str_pad($month, 2, "0", STR_PAD_LEFT);

        while ($currentDay <= $numberDays) {

            //If seventh column (Saturday) reached, start a new row
            if ($dayOfWeek==7) {
                $dayOfWeek=0;
                $calendar.="</tr><tr>";
            }
            $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
            $date = "$year-$month-$currentDayRel";

            //$calendar.="<td><h4>$currentDay</h4>";
            /*if ($dateToday==$date) {
                $calendar.="<td class='today'><h4>$currentDay</h4>";
            }else {
                $calendar.="<td><h4>$currentDay</h4>";
            }*/
            // check if all timeslots on this date are fully booked
            $fully_booked = true;
            $timeslots = timeslots($duration, $cleanup, $start, $end);
            foreach ($timeslots as $timeslot) {
                if (check_available_slots($date, $timeslot) > 0) {
                    $fully_booked = false;
                    break;
                }
            }

            $dayname = strtolower(date('l', strtotime($date)));
            $eventNum = 0;
            $today = $date==date('Y-m-d')? "today" : "";
            $isWeekend = ($dayOfWeek == 0 || $dayOfWeek == 6); // Check if it's Saturday (0) or Sunday (6)
            
            if ($date < date('Y-m-d')) {
                $calendar.="<td class='old-dates'><h4>$currentDay</h4>";
            } elseif ($fully_booked) {
                $calendar.="<td class='fullybooked-dates'><h4>$currentDay</h4>";
            } /*elseif (in_array($date, $holidays)) {
                $calendar .= "<td class='holiday-dates'><h4>$currentDay</h4>";
            }*/ elseif ($isWeekend && $today == "today") {
                $calendar .= "<td class='weekend-dates current-date'><h4>$currentDay</h4>";
            } elseif ($isWeekend) {
                $calendar .= "<td class='weekend-dates'><h4>$currentDay</h4>";
            } else {
                $calendar.="<td class='$today new-dates' onclick='sched_appointment.selectDate(\"$date\")'><h4>$currentDay</h4>";
            }
            

            $calendar.="</td>";

            //Incrementing the counters
            $currentDay++;
            $dayOfWeek++;
        }

        //Completing the row of the last week in month, if necessary
        if($dayOfWeek != 7){
            $remainingDays = 7-$dayOfWeek;

            for ($i=0; $i<$remainingDays; $i++) { 
                $calendar.="<td></td>";
            }
        }

        $calendar.="</tr>";
        $calendar.="</table>";

        //echo $calendar;
        return $calendar;
    }

    $duration = 60;
    $cleanup = 0;
    $start = "09:00";
    $end = "16:00";

    function timeslots($duration, $cleanup, $start, $end){
        $start = new DateTime($start);
        $end = new DateTime($end);
        $interval = new DateInterval("PT" . $duration . "M");
        $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
        $slots = array();

        for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) { 
            $endPeriod = clone $intStart;
            $endPeriod->add($interval);
            if ($endPeriod>$end) {
                break;
            }

            $slots[] = $intStart->format("H:iA")."-".$endPeriod->format("H:iA");
        }

        return $slots;
    }

    // Handling AJAX request to get calendar data
    if (isset($_GET['month']) && isset($_GET['year'])) {
        $month = $_GET['month'];
        $year = $_GET['year'];

        //include 'sched-appointment.php';
        // Generate and return the calendar HTML
        $rows = build_calendar($month, $year, $duration, $cleanup, $start, $end);
        echo $rows;
    }

    // check if the timeslots are being requested
    /*if (isset($_GET['timeslots'])) {
        // output the timeslots
        $timeslots = timeslots($duration, $cleanup, $start, $end);
        echo json_encode($timeslots);
        exit;
    }*/

    if (isset($_GET['timeslots'])) {
        // get the selected date from the GET parameters
        $selected_date = $_GET['date'];
        //echo "Selected date: $selected_date\n";
        // initialize the booked timeslots array
        /*$booked_timeslots = array();
        
        // query to retrieve the timeslots for the selected date from the database
        $query = "SELECT * FROM appointments WHERE app_date = '$selected_date'";
        $result = query($query);
        
        // check if any timeslots were returned
        if ($result !== false) {
            // timeslots were returned, add them to the booked timeslots array
            foreach ($result as $row) {
                $booked_timeslots[] = $row['app_timeslot'];
            }
        }*/

        // generate the available timeslots
        $timeslots = timeslots($duration, $cleanup, $start, $end);
        
        // create an array to store the timeslot objects
        $timeslot_objects = array();

        // create a timeslot object for each timeslot
        foreach ($timeslots as $timeslot) {
            $timeslot_object = new stdClass();
            $timeslot_object->time = $timeslot;
            
            // check if the timeslot is booked
            /*if (in_array($timeslot, $booked_timeslots)) {
                // set the booked property to true
                $timeslot_object->booked = true;
            } else {
                // set the booked property to false
                $timeslot_object->booked = false;
            }*/

            // set the availableSlots property to the result of calling the check_available_slots function
            $available_slots = check_available_slots($selected_date, $timeslot);
            $timeslot_object->availableSlots = $available_slots;
            
            // check if there are no available slots for this timeslot
            if ($available_slots == 0) {
                // set the booked property to true
                $timeslot_object->booked = true;
            } else {
                // set the booked property to false
                $timeslot_object->booked = false;
            }

            // add the timeslot object to the array of timeslot objects
            $timeslot_objects[] = $timeslot_object;
        }
        
        // output the timeslot objects
        echo json_encode($timeslot_objects);
        exit;
    }

    // create a function to check the available slots for a given timeslot on a given date
    function check_available_slots($date, $timeslot) {
        // set the maximum number of slots for each timeslot
        $max_slots = 1;
        
        // query to count the number of appointments for the given timeslot on the given date
        $query = "SELECT COUNT(*) as count FROM appointments WHERE app_date = '$date' AND app_timeslot = '$timeslot'";
        $result = query($query);
        
        // check if any results were returned
        if ($result !== false && count($result) > 0) {
            // a result was returned, calculate the number of available slots
            $available_slots = $max_slots - $result[0]['count'];
            
            // make sure the number of available slots is not negative
            if ($available_slots < 0) {
                $available_slots = 0;
            }
            
            // return the number of available slots
            return $available_slots;
        } else {
            // no result was returned, return the maximum number of slots
            return $max_slots;
        }
    }
?>