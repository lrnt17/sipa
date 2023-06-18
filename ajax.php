<?php

require('connect.php'); // db to
require('functions.php'); //dito mag proprocess yung mga functions

$info['data_type'] = ""; //variable to na nagcoconvert to ng string
$info['success'] = false; //meaning di pa na papasok sa db kaya false pa

//si "$_SERVER['REQUEST_METHOD']" inaalam nya if post or get method, pero dito post ang gamit natin
//si " !empty($_POST['data_type']) " naman siniset nya yung data, kasi dito maraming pumapasok na data
// so dapat alam natin kung anong gagawin duon
if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['data_type']))
{
	//si "$info['data_type']" ito naman is yung variable na array
	// ito yung nagsasala ng ajax request
	$info['data_type'] = $_POST['data_type'];

	//this condition naman is true kapag ang laman ni data_type in signup
	if($_POST['data_type'] == 'signup')
	{

		//si "addslashes()" sinasama nya sa db yung mga apsotrophe or quotations ganun
		$username = addslashes($_POST['username']);
		$email = addslashes($_POST['email']);
		$password = $_POST['password'];
		$password_retype = $_POST['retype_password'];
		$date = date("Y-m-d H:i:s");

		//check if this email already exists, nagchecheck sya ng kamukhang email
		$query = "select * from users where email = '$email' limit 1";
		$row = query($query); //function to nasa functions.php

		if($row) //this condition will be true if nag eexist na si email
		{
			$info['message'] = "That email already exists"; //ito yung laman ni $info['message']
		}else
		if($password !== $password_retype)
		{
			$info['message'] = "Passwords dont match";
		}else
		{
			$password = password_hash($password, PASSWORD_DEFAULT);
			$query = "insert into users (username,email,password,date) values ('$username','$email','$password','$date')";
			query($query);

			$query = "select * from users where email = '$email' limit 1";
			$row = query($query); //function to nasa functions.php
			
			//mangyayari lang daw to if si row ay nireturned na
			if($row){
				//si $row[0] 1st record sa row
				$row = $row[0];
				$info['success'] = true;
				$info['message'] = "Your profile was created successfully";

				//parang ineesure lang na walang kamukha ganun, function to nasa functions.php
				authenticate($row);
			}
		}

	}else
	if($_POST['data_type'] == 'add_post') //ito na yung sa post, naway makuha mo na lorent yung logic
	{

		$post = addslashes($_POST['post']);
		$post_title = addslashes($_POST['post_title']);
		$user_id = $_SESSION['USER']['user_id'];
		$date = date("Y-m-d H:i:s");
 
		$query = "insert into forum (user_id,forum_timestamp,forum_title,forum_desc) values ('$user_id','$date','$post_title','$post')";
		query($query);

		$query = "select * from forum where user_id = '$user_id' order by forum_id desc limit 1";
		$row = query($query);
		
		if($row){

			$row = $row[0];
			$info['success'] = true;
			$info['message'] = "Your post was created successfully";
			$info['row'] = $row;
			
		}

	}else
	if($_POST['data_type'] == 'delete_post') //ito na yung sa post, naway makuha mo na lorent yung logic
	{

		$id = (int)($_POST['id']);
		$user_id = $_SESSION['USER']['user_id'];
 
		//si limit 1 is parang pag may nakita na syang match sa data, iistop na sya
		//para rin tipid sa memory
		$query = "delete from forum where forum_id = '$id' && user_id = '$user_id' limit 1";
		query($query);

		$info['success'] = true;
		$info['message'] = "Your post was deleted successfully";

	}else
	if($_POST['data_type'] == 'load_posts')
	{
		//$user_id = $_SESSION['USER']['user_id'] ?? 0; //chiencheck if may user ba
		$page_number = (int)$_POST['page_number'];
		$limit = 5;
		$offset = ($page_number - 1) * $limit;
		//si offset parang iniiskip yung 1st ten results (yung nasa right) and get
		//the next ten reuslts (katabi nung limit)
		$query = "select * from forum order by forum_id desc limit $limit offset $offset";
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date("jS M, Y H:i:s a",strtotime($row['forum_timestamp']));

				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){
					$rows[$key]['user'] = $user_row[0]; //ito yung may .user
					//$rows[$key]['user']['image'] = get_image($user_row[0]['image']);
				}
			}
			
			$info['rows'] = $rows;
		}
		$info['success'] = true;

	}else
	if($_POST['data_type'] == 'load_my_posts')//mytopics ito
	{
		$user_id = $_SESSION['USER']['user_id'];
		$page_number = (int)$_POST['page_number'];
		$limit = 5;
		$offset = ($page_number - 1) * $limit;
		//si offset parang iniiskip yung 1st ten results (yung nasa right) and get
		//the next ten reuslts (katabi nung limit)
		$query = "select * from forum where user_id = $user_id order by forum_id desc limit $limit offset $offset";
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date("jS M, Y H:i:s a",strtotime($row['forum_timestamp']));

				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){
					$rows[$key]['user'] = $user_row[0]; //ito yung may .user
					//$rows[$key]['user']['image'] = get_image($user_row[0]['image']);
				}
			}
			
			$info['rows'] = $rows;
		}
		$info['success'] = true;

	}else
	if($_POST['data_type'] == 'login') //login version
	{

		$code = addslashes($_POST['code']);
		//check if this account exists
		$query = "select * from users where access_code = '$code' limit 1";
		$row = query($query);

		if(!$row) //wrong email pag lumabas yung nasa loob ng condition na to 
		{
			$info['message'] = "Wrong email or password"; //ito yung lumalabas sa login.inc.php
		}else
		{
			$row = $row[0]; //1st item in that row that we want 

			//verification ng password if <goods></goods>
			if($_POST['pass'] == $row['user_password'])
			{
				//correct
				$info['success'] = true;
				authenticate($row);
				$info['message'] = "Successful login";
			}else{
				$info['message'] = "Wrong email or password";
			}

		}
	}else
	if($_POST['data_type'] == 'logout') //logout version
	{

		logout();
		$info['message'] = "You were successfuly logged out";

	}
	

}
// kinoconvert to json string si "$info", nag ooutput to ng variable $info
echo json_encode($info);
