<?php 
    require('../connect.php');
    require('../functions.php');
    require('fetch_user_and_partner_info.php');
    /*$user_role = $_SESSION['USER']['user_role'];
    $user_fname = $_SESSION['USER']['user_fname'];*/

    /*$user_id = $_SESSION['USER']['user_id'];

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
        }
	}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPa <?=$user_role?></title>
</head>
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

    /* On mouse-over 
    .sidenav a:hover, .dropdown-btn:hover {
    color: #f1f1f1;
    }*/



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
<body style="background: #F2F5FF;">

<?php include('admin-header.php') ?>
    <section class="main">
        <!--<h1>SiPa <?=$user_role?></h1>
        <h2><?=$user_fname?></h2>-->
    </section>
</body>
</html>

