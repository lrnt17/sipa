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