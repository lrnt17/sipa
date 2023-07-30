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
		$anonymous = $_POST['anonymous'];
		$user_id = $_SESSION['USER']['user_id'];
		
		if($anonymous == 'true'){
			$userfname = $_SESSION['USER']['user_fname'];
			$user_fname = substr($userfname, 0, 1) . str_repeat('*', strlen($userfname) - 2) . substr($userfname, -1);
			//$userimg = $_SESSION['USER']['user_image'];
			$user_img = 'assets/images/user.jpg?v1';
		}else{
			$user_fname = $_SESSION['USER']['user_fname'];
			$user_img = $_SESSION['USER']['user_image'];
		}

		$date = date("Y-m-d H:i:s");
 
		$query = "insert into forum (user_img,user_id,user_fname,forum_timestamp,forum_title,forum_desc) values ('$user_img','$user_id','$user_fname','$date','$post_title','$post')";
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
	if($_POST['data_type'] == 'add_comment') //ito na yung sa post, naway makuha mo na lorent yung logic
	{
		$post_id = (int)($_POST['post_id']);
		$post = addslashes($_POST['post']);
		$anonymous = $_POST['anonymous'];
		$user_id = $_SESSION['USER']['user_id'];

		if($anonymous == 'true'){
			$userfname = $_SESSION['USER']['user_fname'];
			$user_fname = substr($userfname, 0, 1) . str_repeat('*', strlen($userfname) - 2) . substr($userfname, -1);
			//$userimg = $_SESSION['USER']['user_image'];
			$user_img = 'assets/images/user.jpg?v1';
		}else{
			$user_fname = $_SESSION['USER']['user_fname'];
			$user_img = $_SESSION['USER']['user_image'];
		}

		$date = date("Y-m-d H:i:s");
 
		$query = "insert into forum (user_img,user_id,user_fname,forum_timestamp,forum_desc,comment_parent_id) values ('$user_img','$user_id','$user_fname','$date','$post','$post_id')";
		query($query);

		$query = "select * from forum where user_id = '$user_id' && comment_parent_id = '$post_id' order by forum_id desc limit 1";
		$row = query($query);
		
		if($row){

			$row = $row[0];
			$info['success'] = true;
			$info['message'] = "Your comment was created successfully";
			$info['row'] = $row;
			
		}

		//count how many comments on this post
		$query = "select count(*) as num from forum where comment_parent_id = '$post_id'";
		$res = query($query);
		if($res){
			$num = $res[0]['num'];
			$query = "update forum set comment_count = '$num' where forum_id = '$post_id' limit 1";
			query($query);
		}

	}else
	if($_POST['data_type'] == 'my_edit_comment') 
	{
		$post = addslashes($_POST['content']);
		$id = (int)($_POST['forum_id']);
		$user_id = $_SESSION['USER']['user_id'];
		$date = date("Y-m-d H:i:s");
	
		$query = "update forum set forum_desc = '$post', forum_timestamp = '$date' where user_id = '$user_id' && forum_id = '$id' limit 1";
		query($query);

		$info['success'] = true;
		$info['updated_date'] = date('Y-m-d\TH:i:s', strtotime($date));
		$info['message'] = "Your comment was edited successfully";
		
	}else
	if($_POST['data_type'] == 'my_edit_post') 
	{
		
		$id = (int)($_POST['forum_id']);
		$post_title = addslashes($_POST['title']);
		$post = addslashes($_POST['content']);
		$user_id = $_SESSION['USER']['user_id'];
		$date = date("Y-m-d H:i:s");
		
		$query = "update forum set forum_desc = '$post', forum_title = '$post_title', forum_timestamp = '$date' where user_id = '$user_id' && forum_id = '$id' limit 1";
		query($query);

		$info['success'] = true;
		$info['updated_date'] = date('Y-m-d\TH:i:s', strtotime($date));
		$info['message'] = "Your post was edited successfully";
		
	}else
	if($_POST['data_type'] == 'my_edit_reply') 
	{
		$post = addslashes($_POST['post']);
		$id = (int)($_POST['id']);
		$user_id = $_SESSION['USER']['user_id'];
		$date = date("Y-m-d H:i:s");
	
		$query = "update forum set forum_desc = '$post', forum_timestamp = '$date' where user_id = '$user_id' && forum_id = '$id' limit 1";
		$info['message'] = "Your reply was edited successfully";
		$info['updated_date'] = date('Y-m-d\TH:i:s', strtotime($date));
		
		query($query);
		$info['success'] = true;
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
		

		// Fetch comment_parent_id for the comment being deleted
		/*$query = "select comment_parent_id from forum where forum_id = '$id' limit 1";
		$res = query($query);
		if($res){
			$comment_parent_id = $res[0]['comment_parent_id'];
		}
	
		$query = "delete from forum where forum_id = '$id' && user_id = '$user_id' limit 1";
		query($query);
	
		if($comment_part) {
			//count how many comments on this post
			$query = "select count(*) as num from forum where comment_parent_id = '$comment_parent_id'";
			$res = query($query);
			if($res){
				$num = $res[0]['num'];
				$query = "update forum set comment_count = '$num' where forum_id = '$comment_parent_id' limit 1";
				query($query);
			}
		}
	
		$info['success'] = true;
	
		if($comment_part) {
			$info['message'] = "Your comment was deleted successfully" . $comment_part;
		}
		else {
			$info['message'] = "Your post was deleted successfully" . $comment_part;
		}*/

	}else
	if($_POST['data_type'] == 'delete_comment') //ito na yung sa post, naway makuha mo na lorent yung logic
	{
		//$comment_part = $_POST['comment_part'];
		$id = (int)($_POST['id']);
		$user_id = $_SESSION['USER']['user_id'];
 
		//si limit 1 is parang pag may nakita na syang match sa data, iistop na sya
		//para rin tipid sa memory
		/*$query = "delete from forum where forum_id = '$id' && user_id = '$user_id' limit 1";
		query($query);

		$info['success'] = true;

		if($comment_part) {
			$info['message'] = "Your comment was deleted successfully" . $id;
		}
		else {
			$info['message'] = "Your post was deleted successfully";
		}*/

		// Fetch comment_parent_id for the comment being deleted
		$query = "select comment_parent_id from forum where forum_id = '$id' limit 1";
		$res = query($query);
		if($res){
			$comment_parent_id = $res[0]['comment_parent_id'];
		}
	
		$query = "delete from forum where forum_id = '$id' && user_id = '$user_id' limit 1";
		query($query);
	
		//if($comment_part) {
			//count how many comments on this post
			$query = "select count(*) as num from forum where comment_parent_id = '$comment_parent_id'";
			$res = query($query);
			if($res){
				$num = $res[0]['num'];
				$query = "update forum set comment_count = '$num' where forum_id = '$comment_parent_id' limit 1";
				query($query);
			}
		//}
	
		$info['success'] = true;
	
		//if($comment_part) {
			$info['message'] = "Your comment was deleted successfully";
		//}
		//else {
		//	$info['message'] = "Your post was deleted successfully" . $comment_part;
		//}

	}else
	if($_POST['data_type'] == 'load_posts') //Initial work done
	{
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		$start = $_POST['start'];
		$limit = $_POST['limit'];

		$query = "select * from forum where comment_parent_id = 0 && reply_parent_id = 0 order by forum_id desc limit $start, $limit";
		
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s', strtotime($row['forum_timestamp']));
				$rows[$key]['forum_desc'] = nl2br(htmlspecialchars($row['forum_desc']));
	
				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;
	
				/*$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){
					$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
				}*/
	
				$forum_id = $row['forum_id'];
				$query = "select count(*) from rating_info where post_id = $forum_id AND rating_action = 'like' limit 1";
				$rating_row = query($query);
	
				if($rating_row){
					$rows[$key]['getlikes'] = $rating_row[0];
				}
				
			}
			
			// Check if there are more rows to load
			$query = "select count(*) from forum where comment_parent_id = 0 && reply_parent_id = 0";
			$result = query($query);
			if ($result) {
				$totalRows = intval($result[0]['count(*)']);
				if ($start + count($rows) < $totalRows) {
					// There are more rows to load
					$info['hasMore'] = true;
				} else {
					// There are no more rows to load
					$info['hasMore'] = false;
				}
			} else {
				// Error querying database
				// Assume there are no more rows to load
				$info['hasMore'] = false;
			}
	
			// Return rows
			$info['rows'] = $rows;
		}
		else{
			// No rows returned
			// Assume there are no more rows to load
			$info['hasMore'] = false;
		}
		 // Return success status
		$info['success'] = true;

	}else
	if($_POST['data_type'] == 'load_comments')
	{
		$user_id = $_SESSION['USER']['user_id'] ?? 0; //chiencheck if may user ba
		$post_id = (int)$_POST['post_id'];
		/*$page_number = (int)$_POST['page_number'];
		$limit = 5;
		$offset = ($page_number - 1) * $limit;*/
		//si offset parang iniiskip yung 1st ten results (yung nasa right) and get
		//the next ten reuslts (katabi nung limit)
	
		//$query = "select * from forum where comment_parent_id = '$post_id' && reply_parent_id = 0 order by forum_id desc limit $limit offset $offset";
		$query = "select * from forum where comment_parent_id = '$post_id' && reply_parent_id = 0 order by forum_id desc";
		
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s',strtotime($row['forum_timestamp']));
				//nl2br - pwede kang mag new line sa textarea tas ganun din output
				//htmlspecialchars - lahat ng characters sa keyboard ginagawang string 
				$rows[$key]['forum_desc'] = nl2br(htmlspecialchars($row['forum_desc']));

				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;

				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){
					$rows[$key]['user'] = $user_row[0]; //ito yung may .user
					$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
				}

				$forum_id = $row['forum_id'];
				$query = "select count(*) from rating_info where post_id = $forum_id AND rating_action = 'like' limit 1";
				$rating_row = query($query);
	
				if($rating_row){
					$rows[$key]['getlikes'] = $rating_row[0];
				}
			}
			
			$info['rows'] = $rows;
		}

		$info['success'] = true;

	}else
	if($_POST['data_type'] == 'load_my_posts')//mytopics ito
	{
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		$start = $_POST['start'];
		$limit = $_POST['limit'];
		
		//si offset parang iniiskip yung 1st ten results (yung nasa right) and get
		//the next ten reuslts (katabi nung limit)
		//$query = "select * from forum where user_id = $user_id && comment_parent_id = 0 && reply_parent_id = 0 order by forum_id desc limit $limit offset $offset";
		$query = "select * from forum where user_id = $user_id && comment_parent_id = 0 && reply_parent_id = 0 order by forum_id desc limit $start, $limit";
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s', strtotime($row['forum_timestamp']));
				$rows[$key]['forum_desc'] = nl2br(htmlspecialchars($row['forum_desc']));
	
				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;
	
				$forum_id = $row['forum_id'];
				$query = "select count(*) from rating_info where post_id = $forum_id AND rating_action = 'like' limit 1";
				$rating_row = query($query);
	
				if($rating_row){
					$rows[$key]['getlikes'] = $rating_row[0];
				}
				
			}
			
			// Check if there are more rows to load
			$query = "select count(*) from forum where user_id = $user_id && comment_parent_id = 0 && reply_parent_id = 0";
			$result = query($query);
			if ($result) {
				$totalRows = intval($result[0]['count(*)']);
				if ($start + count($rows) < $totalRows) {
					// There are more rows to load
					$info['hasMore'] = true;
				} else {
					// There are no more rows to load
					$info['hasMore'] = false;
				}
			} else {
				// Error querying database
				// Assume there are no more rows to load
				$info['hasMore'] = false;
			}
	
			// Return rows
			$info['rows'] = $rows;
		}
		else{
			// No rows returned
			// Assume there are no more rows to load
			$info['hasMore'] = false;
		}
		 // Return success status
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

	}else
	if($_POST['data_type'] == 'delete_account')
	{
		
		$user_id = $_SESSION['USER']['user_id'];
 
		//si limit 1 is parang pag may nakita na syang match sa data, iistop na sya
		//para rin tipid sa memory
		$query = "delete from users where user_id = '$user_id' limit 1";
		query($query);
		logout();
		
		$info['success'] = true;
		$info['message'] = "Your account was deleted successfully";
	}else
	if($_POST['data_type'] == 'user_liked')
	{
		$forum_id = (int)($_POST['forum_id']);
		$user_id = $_SESSION['USER']['user_id'];
		
		$query = "select * from rating_info where user_id = '$user_id' and post_id = '$forum_id' and rating_action = 'like' limit 1";		
		$rows = query($query);
		
		if ($rows) {
			$info['rows'] = $rows;
			$info['success'] = true;
		}
	}else
	if($_POST['data_type'] == 'add_like') //ito na yung sa post, naway makuha mo na lorent yung logic
	{
		$user_id = $_SESSION['USER']['user_id'];
		$post_id = (int)$_POST['forum_id'];
		$action  = $_POST['action'];
 
		if ($action == 'like') {
			$query = "insert into rating_info (user_id,post_id,rating_action) values ('$user_id',$post_id,'like')
			on duplicate key update rating_action = 'like'";
			query($query);

		} elseif ($action == 'unlike') {
			$query = "delete from rating_info where user_id = '$user_id' AND post_id = '$post_id'";
			query($query);
		}

		$row = [];
		$likes_query = "select count(*) from rating_info where post_id = '$post_id' AND rating_action = 'like'";
		$likes = query($likes_query);

		if ($likes) {
			$row = ['likes' => $likes[0]];
			$info['row'] = $row;
			$info['success'] = true;
		}
		
		//count how many comments on this post
		/*$query = "select count(*) as num from forum where comment_parent_id = '$post_id'";
		$res = query($query);
		if($res){
			$num = $res[0]['num'];
			$query = "update forum set comment_count = '$num' where forum_id = '$post_id' limit 1";
			query($query);
		}*/

	}else
	if($_POST['data_type'] == 'get_replies') 
	{ // bago to
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		$forum_id = (int)$_POST['forum_id'];
		$query = "SELECT * FROM forum WHERE reply_parent_id = '$forum_id' ORDER BY forum_id DESC";
		$rows = query($query);
		
		if ($rows) {
			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s', strtotime($row['forum_timestamp']));
				$rows[$key]['forum_desc'] = nl2br(htmlspecialchars($row['forum_desc']));
				
				$rows[$key]['user_owns'] = false;
				if ($user_id == $row['user_id']) {
					$rows[$key]['user_owns'] = true;
				}

				$id = $row['user_id'];
				$query = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";
				$user_row = query($query);
				if ($user_row) {
					//$rows[$key]['user'] = $user_row[0];
					$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
				}

				$forum_id = $row['forum_id'];
				$query = "select count(*) from rating_info where post_id = $forum_id AND rating_action = 'like' limit 1";
				$rating_row = query($query);
	
				if($rating_row){
					$rows[$key]['getlikes'] = $rating_row[0];
				}
			}
			$info['rows'] = $rows;
		}
		$info['success'] = true;
	}else
	if($_POST['data_type'] == 'add_reply') 
	{//bago to
		$forum_id = (int)$_POST['forum_id'];
		$reply_text = addslashes($_POST['reply_text']);
		$anonymous = $_POST['anonymous'];
		$user_id = $_SESSION['USER']['user_id'];

		if($anonymous == 'true'){
			$userfname = $_SESSION['USER']['user_fname'];
			$user_fname = substr($userfname, 0, 1) . str_repeat('*', strlen($userfname) - 2) . substr($userfname, -1);
			//$userimg = $_SESSION['USER']['user_image'];
			$user_img = 'assets/images/user.jpg?v1';
		}else{
			$user_fname = $_SESSION['USER']['user_fname'];
			$user_img = $_SESSION['USER']['user_image'];
		}

		$date = date("Y-m-d H:i:s");

		// Insert new row into forum table with comment_parent_id set to forum_id
		$query = "INSERT INTO forum (user_img, user_id, user_fname, forum_timestamp, forum_desc, reply_parent_id) VALUES ('$user_img', '$user_id', '$user_fname', '$date', '$reply_text', '$forum_id')";
		query($query);
		
		// Return success message and data for new reply
		$query = "SELECT * FROM forum WHERE user_id = '$user_id' AND reply_parent_id = '$forum_id' ORDER BY forum_id DESC LIMIT 1";
		$row = query($query);
		if ($row) {
			$row = $row[0];
			$info['success'] = true;
			$info['message'] = "Your reply was added successfully";
			$info['row'] = $row;
		}

		//count how many reply on this post
		$query = "select count(*) as num from forum where reply_parent_id = '$forum_id'";
		$res = query($query);
		if($res){
			$num = $res[0]['num'];
			$query = "update forum set reply_count = '$num' where forum_id = '$forum_id' limit 1";
			query($query);
		}
	}else
	if($_POST['data_type'] == 'delete_reply') //ito na yung sa post, naway makuha mo na lorent yung logic
	{
		$id = (int)($_POST['id']);
		$user_id = $_SESSION['USER']['user_id'];

		$query = "select reply_parent_id from forum where forum_id = '$id' limit 1";
		$res = query($query);
		if($res){
			$reply_parent_id = $res[0]['reply_parent_id'];
		}
	
		$query = "delete from forum where forum_id = '$id' && user_id = '$user_id' limit 1";
		query($query);

		$query = "select count(*) as num from forum where reply_parent_id = '$reply_parent_id'";
		$res = query($query);
		if($res){
			$num = $res[0]['num'];
			$query = "update forum set reply_count = '$num' where forum_id = '$reply_parent_id' limit 1";
			query($query);
		}
		
		$info['success'] = true;
		$info['message'] = "Your reply was deleted successfully";
	}else
	if($_POST['data_type'] == 'load_posts_decoy')//DO NOT INCLUDE
	{
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		$start = $_POST['start'];
		$limit = $_POST['limit'];

		$query = "select * from forum where comment_parent_id = 0 && reply_parent_id = 0 order by forum_id desc limit $start, $limit";
		
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s', strtotime($row['forum_timestamp']));
				$rows[$key]['forum_desc'] = nl2br(htmlspecialchars($row['forum_desc']));
	
				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;
	
				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){
					$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
				}
	
				$forum_id = $row['forum_id'];
				$query = "select count(*) from rating_info where post_id = $forum_id AND rating_action = 'like' limit 1";
				$rating_row = query($query);
	
				if($rating_row){
					$rows[$key]['getlikes'] = $rating_row[0];
				}
				
			}
			
			// Check if there are more rows to load
			$query = "select count(*) from forum where comment_parent_id = 0 && reply_parent_id = 0";
			$result = query($query);
			if ($result) {
				$totalRows = intval($result[0]['count(*)']);
				if ($start + count($rows) < $totalRows) {
					// There are more rows to load
					$info['hasMore'] = true;
				} else {
					// There are no more rows to load
					$info['hasMore'] = false;
				}
			} else {
				// Error querying database
				// Assume there are no more rows to load
				$info['hasMore'] = false;
			}
	
			// Return rows
			$info['rows'] = $rows;
		}
		else{
			// No rows returned
			// Assume there are no more rows to load
			$info['hasMore'] = false;
		}
		 // Return success status
		$info['success'] = true;
	}else
	if($_POST['data_type'] == 'search_posts')
	{
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		//$start = $_POST['start'];
		//$limit = $_POST['limit'];
		$query = $_POST['query'] ?? '';
		$posts = [];
		
		$query = "SELECT * FROM forum WHERE (forum_title LIKE '%$query%' OR forum_desc LIKE '%$query%') AND comment_parent_id = 0 AND reply_parent_id = 0 ORDER BY forum_id DESC";
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s', strtotime($row['forum_timestamp']));
				$rows[$key]['forum_desc'] = nl2br(htmlspecialchars($row['forum_desc']));
	
				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;
	
				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){
					$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
				}
	
				$forum_id = $row['forum_id'];
				$query = "select count(*) from rating_info where post_id = $forum_id AND rating_action = 'like' limit 1";
				$rating_row = query($query);
	
				if($rating_row){
					$rows[$key]['getlikes'] = $rating_row[0];
				} /*else {
					$rows[$key]['getlikes'] = ['count(*)' => 0];
				}*/ //else testing
			}

			$info['rows'] = $rows;
			// Return success status
			$info['success'] = true;
		}
		
		

		/*$query = "select * from forum where comment_parent_id = 0 && reply_parent_id = 0 order by forum_id desc limit $start, $limit";
		
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s', strtotime($row['forum_timestamp']));
				$rows[$key]['forum_desc'] = nl2br(htmlspecialchars($row['forum_desc']));
	
				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;
	
				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){
					$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
				}
	
				$forum_id = $row['forum_id'];
				$query = "select count(*) from rating_info where post_id = $forum_id AND rating_action = 'like' limit 1";
				$rating_row = query($query);
	
				if($rating_row){
					$rows[$key]['getlikes'] = $rating_row[0];
				}
				
			}
			
			// Check if there are more rows to load
			$query = "select count(*) from forum where comment_parent_id = 0 && reply_parent_id = 0";
			$result = query($query);
			if ($result) {
				$totalRows = intval($result[0]['count(*)']);
				if ($start + count($rows) < $totalRows) {
					// There are more rows to load
					$info['hasMore'] = true;
				} else {
					// There are no more rows to load
					$info['hasMore'] = false;
				}
			} else {
				// Error querying database
				// Assume there are no more rows to load
				$info['hasMore'] = false;
			}
	
			// Return rows
			$info['rows'] = $rows;
		}
		else{
			// No rows returned
			// Assume there are no more rows to load
			$info['hasMore'] = false;
		}
		 // Return success status
		$info['success'] = true;*/
	}else
	if($_POST['data_type'] == 'find_post')
	{
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		$id = (int)($_POST['forum_id']);

		$query = "select * from forum where forum_id = $id && comment_parent_id = 0 && reply_parent_id = 0 limit 1";
		
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s', strtotime($row['forum_timestamp']));
				$rows[$key]['forum_desc'] = nl2br(htmlspecialchars($row['forum_desc']));
	
				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;
	
				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){
					$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
				}
	
				$forum_id = $row['forum_id'];
				$query = "select count(*) from rating_info where post_id = $forum_id AND rating_action = 'like' limit 1";
				$rating_row = query($query);
	
				if($rating_row){
					$rows[$key]['getlikes'] = $rating_row[0];
				}
				
			}
	
			// Return rows
			$info['rows'] = $rows;
		}
		 // Return success status
		$info['success'] = true;
	}else
	if($_POST['data_type'] == 'load_method')
	{
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		$method_id = (int)$_POST['method_id'];
	
		$query = "select * from birth_controls where birth_control_id = '$method_id' limit 1";
		
		$rows = query($query);
		
		if($rows){

			// Extract the preggy and not_preggy values from the first row
			$info['method_name'] = $rows[0]['birth_control_name'];
			$info['preggy'] = $rows[0]['preggy'];
			$info['not_preggy'] = $rows[0]['not_preggy'];
		}

		$info['success'] = true;

	}else
	if($_POST['data_type'] == 'load_all_methods')
	{
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		$query = "select * from birth_controls";
		$rows = query($query);
		$info['rows'] = $rows;
		$info['success'] = true;

	}
	
}
// kinoconvert to json string si "$info", nag ooutput to ng variable $info
echo json_encode($info);
