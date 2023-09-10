<?php
include("connect.php");


// Get the current Unix timestamp
$currentDate = time();
//echo $currentDate;

// Fetch all user IDs from the database
$userIDQuery = "SELECT user_id FROM users";
$userIDResult = mysqli_query($conn, $userIDQuery);

    if ($userIDResult) {
        // Create an array to store user IDs with start dates
        $userIDsToSendSMS = array();

        while ($userIDRow = mysqli_fetch_assoc($userIDResult)) {
            $user_id = $userIDRow['user_id'];

            mysqli_query($conn, "SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED");
            //Check for the presence of a birth control start date for each user
            $startDateQuery = "SELECT user_id FROM users WHERE user_id = $user_id AND birth_control_startdate IS NOT NULL";
            $startDateResult = mysqli_query($conn, $startDateQuery);

            if ($startDateResult && mysqli_num_rows($startDateResult) > 0) {
                // User has a start date, add the user ID to the array
                $userIDsToSendSMS[] = $user_id;
            }
        }

        // Now, you have an array of user IDs with start dates, and you can send SMS to these users
        foreach ($userIDsToSendSMS as $user_id) {
            mysqli_query($conn, "SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED");
            // Retrieve reminder data including user-specific information from the reminder and users tables
            $reminderDatesQuery = "SELECT u.user_pnum, r.reminder_dates, r.isSent, u.birth_control_name FROM reminder r
                                INNER JOIN users u ON r.user_id = u.user_id
                                WHERE r.user_id = $user_id";
            $reminderDatesResult = mysqli_query($conn, $reminderDatesQuery);

            if ($reminderDatesResult) {
                while ($row = mysqli_fetch_assoc($reminderDatesResult)) {
                    $pnum = $row['user_pnum'];
                    $reminderDate = strtotime($row['reminder_dates']);
                    $isSent = $row['isSent'];
                    $method = $row['birth_control_name'];

                    $formattedCurrentDate = date("Y-m-d", $currentDate);
                    $formattedReminderDate = date("Y-m-d", $reminderDate);

                    echo "Current Date: $formattedCurrentDate, Reminder Date: $formattedReminderDate, Method: $method, isSent: $isSent<br>";
                    // Check if the current date matches any reminder date and if the message has not been sent
                    if ($formattedCurrentDate === $formattedReminderDate && $isSent === null ) {
                        // Customize the SMS message based on the birth control method
                        switch ($method) {
                            case 'Hormonal IUD':
                                $message = "Hi there! Here's a reminder for your $method schedule today.";
                                break;
        
                            case 'Copper IUD':
                                $message = "Hi there! Here's a reminder for your $method schedule today.";
                                break;
        
                            case 'Implant':
                                $message = "Hi there! Here's a reminder for you to get your $method today.";
                                break;
        
                            case 'The Shot':
                                $message = "Hi there! Here's a reminder for you to get your Shot today.";
                                break;
        
                            case 'Hormonal Vaginal Ring':
                                $message = "Hi there! Here's a reminder for you to get your $method schedule today.";
                                break;
        
                            case 'Hormonal Patch':
                                $message = "Hi there! Here's a reminder for your $method schedule today.";
                                break;
        
                            case 'Mini Pill':
                            case 'Combined Pill':
                                $message = "Hi there! Here's a reminder for you to take your $method today.";
                                break;
        
                            default:
                                $message = "Hi there! Here's a reminder for your $method schedule today.";
                                break;
                        }

                        // Send the SMS reminder
                        sendSMS($pnum, $message);

                        

                        // Mark the reminder as sent by updating the isSent column to 1
                        mysqli_query($conn, "SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED");
                        $updateIsSentQuery = "UPDATE reminder SET isSent = 1 WHERE user_id = $user_id AND reminder_dates = '{$row['reminder_dates']}'";
                        mysqli_query($conn, $updateIsSentQuery);


                        echo "SMS sent: " . $message . " to " . $pnum . "date today: " . $formattedCurrentDate. "<br> ";
                    }
                    else{
                        echo "SMS not sent due to nasend na kasi sya or di pa date today dzuh";
                    }
                }
            }
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

mysqli_close($conn);

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

?>
