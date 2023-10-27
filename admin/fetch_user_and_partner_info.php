<?php 
    defined('APP') or die('direct script access denied!');
    
    if(!logged_in()){
		header("Location: ../login_1.php");
		die;
	}
    
    $user_id = $_SESSION['USER']['user_id'];

    $query = "select * from users where user_id = '$user_id' limit 1";
	$row = query($query);

	if($row)
	{
		$row = $row[0];
        $user_fname = $row['user_fname'];
        $id = $row['partner_facility_id'];
        $user_role = $row['user_role'];

        $query = "select * from partner_facility where partner_facility_id = '$id' limit 1";
        $user_row = query($query);

        if ($user_row) {
            $user_row = $user_row[0];
            $partner_facility_id = $user_row['partner_facility_id'];
            $city = $user_row['city_municipality'];
            $facility_name = $user_row['health_facility_name'];
            $pin = $user_row['pin'];
        }
	}
?>