<?php
/*include("connect.php");
$_SESSION["pnum"] = '09234726098';
$pnum = $_SESSION["pnum"];
$verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);


$ch = curl_init();
$parameters = array(
    'apikey' => 'c17f81a2eb07d0ad839118cad67d2c55', //Your API KEY
    'number' => $pnum,
    'message' => 'Welcome to SiPa! Use this key for confirmation: ' . $verification_code,
    'sendername' => 'SEMAPHORE'
);
curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
curl_setopt( $ch, CURLOPT_POST, 1 );

//Send the parameters set above with the request
curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

// Receive response from server
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$output = curl_exec( $ch );
curl_close ($ch);


//Show the server response
echo $output;
*/



//include("connect.php");
$number = '09234726098';
$verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

$fname = 'John';
$lname = 'Doe';
$healthFacility = 'SiPa Health Center';
$city = 'San Jose del Monte';
$appointmentDate = '2023-09-10';
$appointmentTimeslot = '10:00 AM - 11:00 AM';

$message = "Dear $fname $lname, Thank you for choosing SiPa! We are happy to confirm that your appointment has been successfully scheduled at our $healthFacility in $city. Your appointment details are as follows: Date: $appointmentDate Time: $appointmentTimeslot We look forward to seeing you soon and providing you with the best service possible. If you have any questions or need to reschedule, please don't hesitate to contact us. Thank you again for choosing SiPa! Best regards, The SiPa Team";

$ch = curl_init();
$parameters = array(
'apikey' => 'c17f81a2eb07d0ad839118cad67d2c55', //Your API KEY
'number' => $number,
/*'message' => 'Welcome to SiPa! We are excited to have you join our community. Here at SiPa, we strive to provide the best service possible. Your verification code is: ' . $verification_code,*/
'message' => $message,
'sendername' => 'SEMAPHORE'
);

curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
curl_setopt( $ch, CURLOPT_POST, 1 );

//Send the parameters set above with the request
curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

// Receive response from server
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$output = curl_exec( $ch );
curl_close ($ch);

//Show the server response
//echo $output;
/*
// insert in users table
$sql = "INSERT INTO verification_codes(user_pnum, verification_code, pnum_verified_at) VALUES ('" . $_SESSION["pnum"] . "', '" . $verification_code . "', NULL)";
mysqli_query($conn, $sql);*/


?>

