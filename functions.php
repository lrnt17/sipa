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

function build_calendar($startMonth, $startYear, $periodDays, $ovulationDays, $numOfMonths) {
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
        $calendar .= "<table class='table table-bordered'>"; //testing
        $month = $startDateTime->format('n');
        $year = $startDateTime->format('Y');
        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $firstDayOfMonth = new DateTime($year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01');
        $dayOfWeek = $firstDayOfMonth->format('w');
        
        $calendar .= "<tr><th colspan='7'>" . $startDateTime->format('F Y') . "</th></tr>";
        $calendar .= "<tr>";
        $daysOfWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        foreach ($daysOfWeek as $day) {
            $calendar .= "<th class='header'>$day</th>";
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
    }

    //$calendar .= "</table>";
    return $calendar;
}