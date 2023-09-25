<?php
session_start();

defined('APP') or die('direct script access denied!'); //means hindi to maaccess ni user pag nirun yung file

//ito si function authenticate!!!!
//kinuha nya si variable $row
function authenticate($row)
{
	$_SESSION['USER'] = $row; //sinave si $row sa $_SESSION['USER'] 
	//itong variable na to "$_SESSION['USER']" andito lahat nung info ni user, ngayon kapag
	//halimbawa may ganito kang nakita "$_SESSION['USER']['id'];" ibig sabihin lang nito is
	//pinipili lang nya si "id" duon sa db mo sa mysql
}

//ito si function quesry!!!!
function query($query)
{
	global $conn; //yung term na "global" para makuha pa rin yung variable outside the function
				// and nasa config.inc.php si $con
	//echo $query;
	$result = mysqli_query($conn, $query); //si $query nasa ajax.inc.php
	 
	//pag may laman si result, magiging true
	//kapag si $result is not boleean -> "!is_bool", gagaawin nya yung condition
	if(!is_bool($result) && mysqli_num_rows($result) > 0)
	{
		$data = []; //empty array to

		//iluloop yung resulta or yung mga data
		while ($row = mysqli_fetch_assoc($result)) {
			$data[] = $row; //iaadd sa $data[] na array lahat ng $row
		}

		return $data; //ibabalik na ngayon si $data;
	}

	return false;
}

function alter_table_query($query){
    
    global $conn;

    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function logged_in(){ // sa pag log in 

	//this condition means that pag hindi empty si $_SESSION['USER'], true ganon
	if(!empty($_SESSION['USER']))
		return true;

	return false;
}

function logout(){

	if(!empty($_SESSION['USER']))
		unset($_SESSION['USER']);
		//parang iaaabort ganon ewan ko ba basta unset
		//dinidelete yung user session

}

function get_image($path)
{
	//kapag may laman yung picture, magiging true itong condition
	//so kapag hindi empty pero nag eexist yung file, return path
	if(!empty($path) && file_exists($path))
		return $path;

	//kapag alang laman, ito yung default na pic
	return 'assets/images/user.jpg?v1';
}

function get_birth_control_img($path)
{
	if(!empty($path) && file_exists($path))
		return $path;

	return 'assets/images/contraceptive.png?v1';
}

function get_std_img($path)
{
	if(!empty($path) && file_exists($path))
		return $path;

	return 'assets/images/stds/std.jpg?v1';
}

function get_admin_image($path)
{
	//kapag may laman yung picture, magiging true itong condition
	//so kapag hindi empty pero nag eexist yung file, return path
	if(!empty($path) && file_exists($path))
		return $path;

	//kapag alang laman, ito yung default na pic
	return '../assets/images/user.jpg?v1';
}

function i_own_post($row)
{
	if(logged_in() && $_SESSION['USER']['user_id'] == $row['user_id'])
		return true;

	return false;
}

function i_own_profile($row)
{
	if(logged_in() && $_SESSION['USER']['user_id'] == $row['user_id'])
		return true;

	return false;
}

function head_admin($row) {
	
    if ($row == 'BUSTOS00001') {
        return true;
    } else {
        return false;
    }
}

function check_head_admin($user_role) {
	
    if ($user_role === 'head_admin') {
        return true;
    }

    return false;
}

function check_admin($user_role) {
	
    if ($user_role === 'admin') {
        return true;
    }

    return false;
}

function period_calendar($startMonth, $startYear, $periodDays, $ovulationDays, $numOfMonths) {
    // Get the selected date of the first day of the last period
    $startDate = $startYear . '-' . str_pad($startMonth, 2, '0', STR_PAD_LEFT) . '-01';

    // Calculate the start and end dates of the three months
    $startDateTime = new DateTime($startDate);
    $endDateTime = clone $startDateTime;
    //$endDateTime->add(new DateInterval('P2M')); // Add 2 months to get the end of the 3-month period
    $endDateTime->add(new DateInterval("P{$numOfMonths}M"));

    // Initialize calendar variable
    //$calendar = "<table class='table table-bordered'>";
    $calendar = "";
    //$calendar .= "<tr><th colspan='7'>Three Months Calendar</th></tr>";

    // Loop through each month for the 3-month period
    while ($startDateTime <= $endDateTime) {
        $calendar .= "<div class='calendar-container m-4 rounded-4 shadow-sm rounded' style='background:#ffff;'>"; // Add a div container
        $calendar .= "<table class='m-4' >"; //testing
        $month = $startDateTime->format('n');
        $year = $startDateTime->format('Y');
        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $firstDayOfMonth = new DateTime($year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01');
        $dayOfWeek = $firstDayOfMonth->format('w');
        
        $calendar .= "<tr><th colspan='7' style='text-align:center; color:#5A5A5A;''>" . $startDateTime->format('F Y') . "</th></tr>";
        $calendar .= "<tr>";
        $daysOfWeek = array('<span class="day">Sun</span>', '<span class="day">Mon</span>', '<span class="day">Tue</span>', '<span class="day">Wed</span>', '<span class="day">Thu</span>', '<span class="day">Fri</span>', '<span class="day">Sat</span>');
        foreach ($daysOfWeek as $day) {
            $calendar .= "<th class='header'><span translate='no'>$day</span></th>";
        }
        $calendar .= "</tr><tr>";
        for ($i = 0; $i < $dayOfWeek; $i++) {
            $calendar .= "<td></td>";
        }
        // Loop through each day of the month
        for ($day = 1; $day <= $numDays; $day++) {
            $currentDate = new DateTime($year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT));
            $currentDayOfWeek = $currentDate->format('w');
            
            // Add empty cells for days before the first day of the month
            if ($currentDayOfWeek == 0 && $day != 1) {
                $calendar .= "</tr><tr>";
            }
            if ($currentDayOfWeek == $dayOfWeek) {
                $dayOfWeek = ($dayOfWeek + 1) % 7;
            } else {
                $calendar .= "<td></td>";
            }

            // Check if the current day is in a period day range
            foreach ($periodDays as $range) {
                if ($currentDate >= new DateTime($range['start']) && $currentDate <= new DateTime($range['end'])) {
                    // Add a class to highlight the day in pink
                    $calendar .= "<td class='period-day'>$day</td>";
                    continue 2;
                }
            }
            // Check if the current day is in an ovulation day range
            foreach ($ovulationDays as $range) {
                if ($currentDate >= new DateTime($range['start']) && $currentDate <= new DateTime($range['end'])) {
                    // Add a class to highlight the day in green
                    $calendar .= "<td class='ovulation-day'>$day</td>";
                    continue 2;
                }
            }

            // Check if the current day is in the period days array
            if (in_array($currentDate->format('Y-m-d'), $periodDays)) {
                // Add a class to highlight the day in pink
                $calendar .= "<td class='period-day'>$day</td>";
            } elseif (in_array($currentDate->format('Y-m-d'), $ovulationDays)) {
                // Check if the current day is in the ovulation days array
                // Add a class to highlight the day in orange
                $calendar .= "<td class='ovulation-day'>$day</td>";
            } else {
                $calendar .= "<td>$day</td>";
            }
        }

        // Add empty cells for days after the last day of the month
        while ($currentDayOfWeek != 6) {
            $calendar .= "<td></td>";
            $currentDayOfWeek = ($currentDayOfWeek + 1) % 7;
        }

        $calendar .= "</tr>";
        $startDateTime->add(new DateInterval('P1M'));
        $calendar .= "</table>";//testing
        $calendar .= "</div>"; // Close the div container
    }

    //$calendar .= "</table>";
    return $calendar;
}

function appointment_confirmation($contact, $fname, $municipality, $health_facility, $appointment_date, $appointment_timeslot) 
{
    $message = "Hi $fname, your appointment at $health_facility, $municipality is set on $appointment_date at $appointment_timeslot. Thanks, SiPa!";

    $ch = curl_init();
    $parameters = array(
        'apikey' => 'c17f81a2eb07d0ad839118cad67d2c55', //Your API KEY
        'number' => $contact,
        'message' => $message,
        'sendername' => 'SiPa'
    );

    curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
    curl_setopt( $ch, CURLOPT_POST, 1 );

    //Send the parameters set above with the request
    curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

    // Receive response from server
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $output = curl_exec( $ch );
    curl_close ($ch);

}

// Function to calculate and insert reminder dates into the reminder table
function calculateAndInsertReminderDates($method, $startDate, $usage, $user_id, $conn) {
    
    // Define the duration for each method (in days)
    $durations = array(
        'Hormonal IUD' => 30 * 12 * 5, // 5 years
        'Copper IUD' => 30 * 12 * 10, // 10 years
        'Implant' => 30 * 12 * 3, // 3 years
        'Injection' => 30 * 3, // 3 months
        'Hormonal Vaginal Ring' => 30, // 1 month sms reminder, on 4th week, the vaginal ring should be removed 
        'Hormonal Patch' => 7, // 1 week, if usage is more than 3, there is a 1 week rest before the sms starts again
        'Mini Pill' => 1, // everyday reminder for 21 days and a rest week after it. if the usage is more than or equal to 2, the sms should only resume after the rest week.
        'Combined Pill' => 1 // everyday reminder for 21 days and a rest week after it. if the usage is more than or equal to 2, the sms should only resume after the rest week.
    );

    // Check if the method is valid
    if (array_key_exists($method, $durations)) {
        $duration = $durations[$method];

        // Calculate the interval between usages based on duration and frequency
        
            $interval = $duration;

        // Convert the start date to a Unix timestamp
        $currentDate = strtotime($startDate);

        // Prepare the SQL query for inserting reminder dates
        $insertQuery = "INSERT INTO reminder (user_id, reminder_dates) VALUES ";
        $values = array();

        // Add start date to values
        array_push($values,"($user_id,'$startDate')");
        


    // Calculate the number of iterations based on usage and method
    if ($method == 'Mini Pill' || $method == 'Combined Pill') {
        $iterations = 20 * $usage;
    } else {
        $iterations = $usage - 1;
    }

    // Generate reminder dates and SQL values
    for ($i = 0; $i < $iterations; ++$i) {
        // Add a one-week rest after every third reminder date for hormonal patch
        if ($method == 'Hormonal Patch' && ($i + 1) % 3 == 0) {
            $currentDate = strtotime("+7 day", $currentDate);
        }

        // For Mini Pill and Combined Pill, add a one-week rest after every 21st reminder date
        if (($method == 'Mini Pill' || $method == 'Combined Pill') && ($i + 1) % 21 == 0 && ($i + 1) != $iterations) {
            for ($j = 0; $j < 7; ++$j) {
                $currentDate = strtotime("+1 day", $currentDate);
            }
            continue;
        }

        $reminderDate = date('Y-m-d', strtotime("+$duration days", $currentDate));
        array_push($values,"($user_id,'$reminderDate')");
        $currentDate = strtotime("+$duration days", $currentDate);
    }

    // If usage is 1, set reminderDate to startDate
    if ($usage == 1 && $method != 'Combined Pill' && $method != 'Mini Pill') {
        $reminderDate = $startDate;
    }

    // Insert reminder dates into the reminder table
    if (!empty($values)) {
        $insertQuery .= implode(",", $values);
        if (mysqli_query($conn,$insertQuery)) {
            // Update birth_control_enddate in users table with last reminder date
            $updateQuery = "UPDATE users SET birth_control_enddate = '$reminderDate' WHERE user_id = $user_id";
            if (mysqli_query($conn,$updateQuery)) {
                return true; // Successfully inserted reminder dates and updated birth_control_enddate
            } else {
                return false; // Failed to update birth_control_enddate
            }
        } else {
            return false; // Failed to insert reminder dates
        }
    }

    return false; // Invalid method or other error
    }
}

function sendInstantSMS($conn, $user_id) {
    // Check if the user has birth control information and is eligible for an instant SMS
    $birthControlQuery = "SELECT user_pnum, birth_control_name, birth_control_startdate, birth_control_enddate, birth_control_usage, isMessaged FROM users WHERE user_id = $user_id AND birth_control_startdate IS NOT NULL AND isMessaged IS NULL";
    $birthControlResult = mysqli_query($conn, $birthControlQuery);

    if ($birthControlResult && mysqli_num_rows($birthControlResult) > 0) {
        while ($row = mysqli_fetch_assoc($birthControlResult)) {
            $pnum = $row['user_pnum'];
            $method = $row['birth_control_name'];
            $startDate = $row['birth_control_startdate'];
            $endDate = $row['birth_control_enddate'];
            $cycle = $row['birth_control_usage'];
            $isMessaged = $row['isMessaged'];

            if ($cycle==1){ //pag isa lang usage, di na ilalagay end date kasi same lang start and end date nya pag isang gamitan lang dzuh
                
                // Customize the SMS message based on the birth control method and user's information
                switch ($method) {
                    case 'Hormonal IUD':
                        $message = "Hi there! You will receive an SMS reminder for your Hormonal IUD schedule on $startDate. Stay on track!";
                        break;

                    case 'Copper IUD':
                        $message = "Hi there! You will receive an SMS reminder for your Copper IUD schedule on $startDate. Stay on track!";
                        break;

                    case 'Implant':
                        $message = "Hi there! You will receive an SMS reminder for your Implant schedule on $startDate. Stay on track!";
                        break;

                    case 'Injection':
                        $message = "Hi there! You will receive an SMS reminder for your Injection schedule on $startDate. Stay on track!";
                        break;

                    case 'Hormonal Vaginal Ring':
                        $message = "Hi there! You will receive an SMS reminder for your Hormonal Vaginal Ring schedule on $startDate. Stay on track!";
                        break;

                    case 'Hormonal Patch':
                        $message = "Hi there! You will receive an SMS reminder for your Hormonal Patch schedule on $startDate. Stay on track!";
                        break;

                    case 'Mini Pill':
                    case 'Combined Pill':
                        $message = "Hi there! Your SMS reminder for your $method intake starts on $startDate and ends on $endDate. Stay on track!";
                        break;
                }
            }
            else {
                    // Customize the SMS message based on the birth control method and user's information
                switch ($method) {
                    case 'Hormonal IUD':
                        $message = "Hi there! Your SMS reminder for your Hormonal IUD schedule starts on $startDate and goes until $endDate, for a $cycle cycle. Stay on track!";
                        break;
                    
                    case 'Copper IUD':
                        $message = "Hi there! Your SMS reminder for your Copper IUD schedule begins on $startDate and goes until $endDate, for a $cycle cycle. Stay on track!";
                        break;
                    
                    case 'Implant':
                        $message = "Hi there! Your SMS reminder for your Implant schedule starts on $startDate and ends on $endDate, for a $cycle cycle. Stay on track!";
                        break;
                    
                    case 'Injection':
                        $message = "Hi there! Your SMS reminder for your Injection begins on $startDate and lasts until $endDate, for a $cycle cycle. Stay on track!";
                        break;
                    
                    case 'Hormonal Vaginal Ring':
                        $message = "Hi there! Your SMS reminder for your Hormonal Vaginal Ring schedule starts on $startDate and goes until $endDate, for a $cycle cycle. Stay on track!";
                        break;
                    
                    case 'Hormonal Patch':
                        $message = "Hi there! Your SMS reminder for your Hormonal Patch schedule starts on $startDate and ends on $endDate, for a $cycle cycle. Stay on track!";
                        break;
                    
                    case 'Mini Pill':
                    case 'Combined Pill':
                        $message = "Hi there! Your SMS reminder for your $method intake starts on $startDate and ends on $endDate, for a $cycle cycle. Stay on track!";
                        break;
        
                }
                    
            }

            sendSMS($pnum, $message);

            // Mark the user as messaged by updating the isMessaged column to 1
            mysqli_query($conn, "UPDATE users SET isMessaged = 1 WHERE user_id = $user_id");
        }
    }
}

function sendSMS($number, $message) {
    $ch = curl_init();
    $parameters = array(
        'apikey' => 'c17f81a2eb07d0ad839118cad67d2c55', // Your API KEY
        'number' => $number,
        'message' => $message,
        'sendername' => 'SiPa'
    );

    curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    curl_close($ch);

    //echo $output;
}

function admin_get_image($path)
{
	if(!empty($path) && file_exists($path))
		return $path;

	return '../assets/images/user.jpg?v1';
}

function containsProhibitedWord($content) {
    // List of prohibited words or phrases with variations
    $prohibitedWords = array(
        " /\bbobo\b/i",         // Matches variations of "bobo"
        " /\btangina\b/i",         // Matches variations of "bobo"
        " /\btanga\b/i",         // Matches variations of "bobo"
        " /\btanginamo\b/i",         // Matches variations of "bobo"
        " /\binamo\b/i",         // Matches variations of "bobo"
        " /\bputangina\b/i",         // Matches variations of "bobo"
        " /\bputanginamo\b/i",         // Matches variations of "bobo"
        " /\bkingina\b/i",         // Matches variations of "bobo"
        " /\bpota\b/i",         // Matches variations of "bobo"
        " /\bputa\b/i",         // Matches variations of "bobo"
        " /\bgago\b/i",         // Matches variations of "bobo"
        " /\bogag\b/i",         // Matches variations of "bobo"
        " /\bulol\b/i",         // Matches variations of "bobo"
        " /\badik\b/i",         // Matches variations of "bobo"
        " /\bkupal\b/i",         // Matches variations of "bobo"
        " /\binutil\b/i",         // Matches variations of "bobo"

    );
    
    // Convert content and prohibited words to lowercase for case-insensitive comparison
    $contentLower = strtolower($content);

    foreach ($prohibitedWords as $pattern) {
        if (preg_match($pattern, $contentLower)) {
            return true; // Prohibited word found
        }
    }

    return false; // No prohibited words found
}

