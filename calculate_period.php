<?php
//DO NOT INCLUDE
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

/*
// Get the user inputs from the query string
$firstDayLastPeriod = new DateTime($_GET['first_day_last_period']);
$periodLength = (int)$_GET['period_length'];
$cycleLength = (int)$_GET['cycle_length'];
$startDateTime = clone $firstDayLastPeriod;
$endDateTime = clone $startDateTime;
$endDateTime->add(new DateInterval('P3M'));
$periodDays = [];
$ovulationDays = [];
$currentDate = clone $startDateTime;
while ($currentDate <= $endDateTime) {
    // Calculate period days
    $periodStart = clone $currentDate;
    $periodEnd = clone $currentDate;
    $periodEnd->add(new DateInterval("P{$periodLength}D"))->sub(new DateInterval('P1D'));
    $periodDays[] = [
        'start' => $periodStart->format('Y-m-d'),
        'end' => $periodEnd->format('Y-m-d')
    ];
    // Calculate most probable ovulation days
    $ovulationStart = clone $currentDate;
    $ovulationStart->add(new DateInterval("P{$cycleLength}D"))->sub(new DateInterval('P16D'));
    $ovulationEnd = clone $ovulationStart;
    $ovulationEnd->add(new DateInterval('P4D'));
    $ovulationDays[] = [
        'start' => $ovulationStart->format('Y-m-d'),
        'end' => $ovulationEnd->format('Y-m-d')
    ];
    // Increment current date
    $currentDate->add(new DateInterval("P{$cycleLength}D"));
}

// Generate the HTML content for the three months calendar with period and ovulation day highlights
// You can use the build_calendar() function here passing the calculated period and ovulation days as parameters
//include 'your_calendar_functions.php'; // Replace with the correct path to your calendar functions file
echo build_calendar($startDateTime->format('n'), $startDateTime->format('Y'), $periodDays, $ovulationDays);
*/
?>
