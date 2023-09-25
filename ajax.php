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
			//$userfname = $_SESSION['USER']['user_fname'];
			//$user_fname = substr($userfname, 0, 1) . str_repeat('*', strlen($userfname) - 2) . substr($userfname, -1);
			//$userimg = $_SESSION['USER']['user_image'];
			//$user_img = 'assets/images/user.jpg?v1';
			$anonimity = 1;
		}else{
			//$user_fname = $_SESSION['USER']['user_fname'];
			//$user_img = $_SESSION['USER']['user_image'];
			$anonimity = 0;
		}

		$date = date("Y-m-d H:i:s");

		// Add word filtering logic here
		if (containsProhibitedWord($post_title) || containsProhibitedWord($post)) {
			$info['success'] = false;
			$info['message'] = "Cannot add your post because it contains prohibited words or phrases.";
		}
		else {
			$query = "insert into forum (user_id,forum_timestamp,forum_title,forum_desc,forum_anonimity) values ('$user_id','$date','$post_title','$post','$anonimity')";
			query($query);

			$query = "select * from forum where user_id = '$user_id' order by forum_id desc limit 1";
			$row = query($query);
			
			if($row){

				$row = $row[0];
				$info['success'] = true;
				$info['message'] = "Your post was created successfully";
				$info['row'] = $row;
				
			}
		}
		

	}else
	if($_POST['data_type'] == 'add_comment') //ito na yung sa post, naway makuha mo na lorent yung logic
	{
		$post_id = (int)($_POST['post_id']);
		$post = addslashes($_POST['post']);
		$anonymous = $_POST['anonymous'];
		$user_id = $_SESSION['USER']['user_id'];

		if($anonymous == 'true'){
			//$userfname = $_SESSION['USER']['user_fname'];
			//$user_fname = substr($userfname, 0, 1) . str_repeat('*', strlen($userfname) - 2) . substr($userfname, -1);
			//$userimg = $_SESSION['USER']['user_image'];
			//$user_img = 'assets/images/user.jpg?v1';
			$anonimity = 1;
		}else{
			//$user_fname = $_SESSION['USER']['user_fname'];
			//$user_img = $_SESSION['USER']['user_image'];
			$anonimity = 0;
		}

		$date = date("Y-m-d H:i:s");

		// Add word filtering logic here
		if (containsProhibitedWord($post)) {
			$info['success'] = false;
			$info['message'] = "Cannot post your comment because it contains prohibited words or phrases.";
		}
		else {
			$query = "insert into forum (user_id,forum_timestamp,forum_desc,comment_parent_id,comment_anonimity) values ('$user_id','$date','$post','$post_id','$anonimity')";
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
		}
		

	}else
	if($_POST['data_type'] == 'my_edit_comment') 
	{
		$post = addslashes($_POST['content']);
		$id = (int)($_POST['forum_id']);
		$user_id = $_SESSION['USER']['user_id'];
		$date = date("Y-m-d H:i:s");

		// Add word filtering logic here
		if (containsProhibitedWord($post)) {
			$info['success'] = false;
			$info['message'] = "Cannot edit your comment because it contains prohibited words or phrases.";
		}
		else{
			$query = "update forum set forum_desc = '$post', forum_timestamp = '$date' where user_id = '$user_id' && forum_id = '$id' limit 1";
			query($query);

			$info['success'] = true;
			$info['updated_date'] = date('Y-m-d\TH:i:s', strtotime($date));
			$info['message'] = "Your comment was edited successfully";
		
		}
	
		
	}else
	if($_POST['data_type'] == 'my_edit_post') 
	{
		
		$id = (int)($_POST['forum_id']);
		$post_title = addslashes($_POST['title']);
		$post = addslashes($_POST['content']);
		$user_id = $_SESSION['USER']['user_id'];
		$date = date("Y-m-d H:i:s");
		
		// Add word filtering logic here
		if (containsProhibitedWord($post_title) || containsProhibitedWord($post)) {
			$info['success'] = false;
			$info['message'] = "Cannot edit your post because it contains prohibited words or phrases.";
		}
		else{
			$query = "update forum set forum_desc = '$post', forum_title = '$post_title', forum_timestamp = '$date' where user_id = '$user_id' && forum_id = '$id' limit 1";
			query($query);

			$info['success'] = true;
			$info['updated_date'] = date('Y-m-d\TH:i:s', strtotime($date));
			$info['message'] = "Your post was edited successfully";
		}
	}else
	if($_POST['data_type'] == 'my_edit_reply') 
	{
		$post = addslashes($_POST['post']);
		$id = (int)($_POST['id']);
		$user_id = $_SESSION['USER']['user_id'];
		$date = date("Y-m-d H:i:s");

		// Add word filtering logic here
		if (containsProhibitedWord($post)) {
			$info['success'] = false;
			$info['message'] = "Cannot edit your reply because it contains prohibited words or phrases.";
		}
		else{
	
		$query = "update forum set forum_desc = '$post', forum_timestamp = '$date' where user_id = '$user_id' && forum_id = '$id' limit 1";
		$info['message'] = "Your reply was edited successfully";
		$info['updated_date'] = date('Y-m-d\TH:i:s', strtotime($date));
		
		query($query);
		$info['success'] = true;
		}
	}else
	if($_POST['data_type'] == 'delete_post') //ito na yung sa post, naway makuha mo na lorent yung logic
	{
		
		$id = (int)($_POST['id']);
		$user_id = $_SESSION['USER']['user_id'];

		// First, fetch all forum_ids of the comments
		$query = "SELECT forum_id FROM forum WHERE comment_parent_id = '$id'";
		$comment_ids = query($query);

		if ($comment_ids) {
			// Then, delete ratings of the comments and their replies
			foreach ($comment_ids as $comment_id) {
				// Delete ratings of the replies
				$query = "SELECT forum_id FROM forum WHERE reply_parent_id = '{$comment_id['forum_id']}'";
				$reply_ids = query($query);
				
				if ($reply_ids) {
					foreach ($reply_ids as $reply_id) {
						$query = "DELETE FROM rating_info WHERE post_id = '{$reply_id['forum_id']}'";
						query($query);
					}
				}

				// Delete ratings of the comment
				$query = "DELETE FROM rating_info WHERE post_id = '{$comment_id['forum_id']}'";
				query($query);
			}
		}

		// Delete ratings of the forum
		$query = "DELETE FROM rating_info WHERE post_id = '$id'";
		query($query);

		// Delete all comments and replies of the forum
		$query = "DELETE FROM forum WHERE comment_parent_id = '$id' OR reply_parent_id IN (SELECT forum_id FROM forum WHERE comment_parent_id = '$id')";
		query($query);
 
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
		
		// First, fetch all forum_ids of the replies
		$query = "SELECT forum_id FROM forum WHERE reply_parent_id = '$id'";
		$reply_ids = query($query);

		// Then, delete ratings of the replies
		foreach ($reply_ids as $reply_id) {
			$query = "DELETE FROM rating_info WHERE post_id = '{$reply_id['forum_id']}'";
			query($query);
		}

		// Delete ratings of the comment
		$query = "DELETE FROM rating_info WHERE post_id = '$id'";
		query($query);

		// Delete all replies of the comment
		$query = "DELETE FROM forum WHERE reply_parent_id = '$id'";
		query($query);
	
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
				//$rows[$key]['user_img'] = get_image($row['user_img']);
	
				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;
	
				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){

					if ($row['forum_anonimity'] == 1) {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = "assets/images/user.jpg?v1";
						// Anonymize the user's name
						$fname = substr($user_row[0]['user_fname'], 0, 1) . str_repeat("*", strlen($user_row[0]['user_fname']) - 2) . substr($user_row[0]['user_fname'], -1);
						$lname = substr($user_row[0]['user_lname'], 0, 1) . ".";
						$rows[$key]['user']['name'] = "$fname $lname";
					} else {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
						// Display the full name
						$rows[$key]['user']['name'] = $user_row[0]['user_fname'] . " " . $user_row[0]['user_lname'];
					}
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
				//$rows[$key]['user_img'] = get_image($row['user_img']);

				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;

				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){

					if ($row['comment_anonimity'] == 1) {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = "assets/images/user.jpg?v1";
						// Anonymize the user's name
						$fname = substr($user_row[0]['user_fname'], 0, 1) . str_repeat("*", strlen($user_row[0]['user_fname']) - 2) . substr($user_row[0]['user_fname'], -1);
						$lname = substr($user_row[0]['user_lname'], 0, 1) . ".";
						$rows[$key]['user']['name'] = "$fname $lname";
					} else {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
						// Display the full name
						$rows[$key]['user']['name'] = $user_row[0]['user_fname'] . " " . $user_row[0]['user_lname'];
					}
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
				//$rows[$key]['user_img'] = get_image($row['user_img']);
	
				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;
	
				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){

					if ($row['forum_anonimity'] == 1) {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = "assets/images/user.jpg?v1";
						// Anonymize the user's name
						$fname = substr($user_row[0]['user_fname'], 0, 1) . str_repeat("*", strlen($user_row[0]['user_fname']) - 2) . substr($user_row[0]['user_fname'], -1);
						$lname = substr($user_row[0]['user_lname'], 0, 1) . ".";
						$rows[$key]['user']['name'] = "$fname $lname";
					} else {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
						// Display the full name
						$rows[$key]['user']['name'] = $user_row[0]['user_fname'] . " " . $user_row[0]['user_lname'];
					}
				}

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
		$username = addslashes($_POST['username']);
		
		$query = "select * from users where user_name = '$username' limit 1";
		$row = query($query);

		if(!$row)
		{
			$info['message'] = "Wrong email or password";
		}else
		{
			$row = $row[0];
			//password_verify($_POST['pass'], $row['user_password'])
			if(password_verify($_POST['pass'], $row['user_password']))
			{
				if ($row['user_role'] == 'admin') {
					$info['admin_success'] = true;
					authenticate($row);
					$info['message'] = "Admin Successful login";

				} else if ($row['user_role'] == 'head_admin') {
					$info['head_admin_success'] = true;
					authenticate($row);
					$info['message'] = "Head Admin Successful login";

				} else if ($row['user_role'] == 'user') {
					/*$info['success'] = true;
					authenticate($row);
					$info['message'] = "Successful login";*/
					if ($row['privacy_policy'] == 'I agree' && $row['terms_conditions'] == 'I agree') {
						$info['user_success'] = true;
						authenticate($row);
						$info['message'] = "Successful login";

					} else {
						$info['user_success'] = false;
						$info['message'] = "You must agree to the privacy policy and terms and conditions";
					
					}
				}

			}else{
				$info['message'] = "Wrong email or password";
			}
		}
	}else
	if($_POST['data_type'] == 'login_with_agree') //login version
	{
		$username = addslashes($_POST['username']);
		$terms_conditions = $_POST['terms_conditions'];
		$privacy_policy = $_POST['privacy_policy'];

		$query = "UPDATE users SET terms_conditions = '$terms_conditions', privacy_policy = '$privacy_policy' WHERE user_name = '$username' LIMIT 1";
		query($query);
		
		$query = "select * from users where user_name = '$username' limit 1";
		$row = query($query);

		if(!$row)
		{
			$info['message'] = "Wrong email or password";
		}else
		{
			$row = $row[0];
			//password_verify($_POST['pass'], $row['user_password'])
			if(password_verify($_POST['pass'], $row['user_password']))
			{
				if ($row['user_role'] == 'user') {
					$info['success'] = true;
					authenticate($row);
					$info['message'] = "Successful login";

				}

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
				//$rows[$key]['user_img'] = get_image($row['user_img']);
				
				$rows[$key]['user_owns'] = false;
				if ($user_id == $row['user_id']) {
					$rows[$key]['user_owns'] = true;
				}

				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){

					if ($row['reply_anonimity'] == 1) {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = "assets/images/user.jpg?v1";
						// Anonymize the user's name
						$fname = substr($user_row[0]['user_fname'], 0, 1) . str_repeat("*", strlen($user_row[0]['user_fname']) - 2) . substr($user_row[0]['user_fname'], -1);
						$lname = substr($user_row[0]['user_lname'], 0, 1) . ".";
						$rows[$key]['user']['name'] = "$fname $lname";
					} else {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
						// Display the full name
						$rows[$key]['user']['name'] = $user_row[0]['user_fname'] . " " . $user_row[0]['user_lname'];
					}
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
			//$userfname = $_SESSION['USER']['user_fname'];
			//$user_fname = substr($userfname, 0, 1) . str_repeat('*', strlen($userfname) - 2) . substr($userfname, -1);
			//$userimg = $_SESSION['USER']['user_image'];
			//$user_img = 'assets/images/user.jpg?v1';
			$anonimity = 1;
		}else{
			//$user_fname = $_SESSION['USER']['user_fname'];
			//$user_img = $_SESSION['USER']['user_image'];
			$anonimity = 0;
		}

		// Add word filtering logic here
		if (containsProhibitedWord($reply_text)) {
			$info['success'] = false;
			$info['message'] = "Cannot post your reply because it contains prohibited words or phrases.";
		}else{

			$date = date("Y-m-d H:i:s");

			// Insert new row into forum table with comment_parent_id set to forum_id
			$query = "INSERT INTO forum (user_id, forum_timestamp, forum_desc, reply_parent_id, reply_anonimity) VALUES ('$user_id', '$date', '$reply_text', '$forum_id', '$anonimity')";
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
				//$rows[$key]['user_img'] = get_image($row['user_img']);
	
				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;
	
				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){

					if ($row['forum_anonimity'] == 1) {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = "assets/images/user.jpg?v1";
						// Anonymize the user's name
						$fname = substr($user_row[0]['user_fname'], 0, 1) . str_repeat("*", strlen($user_row[0]['user_fname']) - 2) . substr($user_row[0]['user_fname'], -1);
						$lname = substr($user_row[0]['user_lname'], 0, 1) . ".";
						$rows[$key]['user']['name'] = "$fname $lname";
					} else {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
						// Display the full name
						$rows[$key]['user']['name'] = $user_row[0]['user_fname'] . " " . $user_row[0]['user_lname'];
					}
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

					if ($row['forum_anonimity'] == 1) {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = "assets/images/user.jpg?v1";
						// Anonymize the user's name
						$fname = substr($user_row[0]['user_fname'], 0, 1) . str_repeat("*", strlen($user_row[0]['user_fname']) - 2) . substr($user_row[0]['user_fname'], -1);
						$lname = substr($user_row[0]['user_lname'], 0, 1) . ".";
						$rows[$key]['user']['name'] = "$fname $lname";
					} else {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
						// Display the full name
						$rows[$key]['user']['name'] = $user_row[0]['user_fname'] . " " . $user_row[0]['user_lname'];
					}
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
			$info['preggy'] = $rows[0]['birth_control_preggy'];
			//$info['not_preggy'] = $rows[0]['not_preggy'];
		}

		$info['success'] = true;

	}else
	if($_POST['data_type'] == 'load_all_methods')
	{
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		$query = "select * from birth_controls";
		$rows = query($query);

		if($rows){

			foreach ($rows as $key => $row) {
				
				$rows[$key]['birth_control_img'] = get_birth_control_img($row['birth_control_img']);
			}
			
			$info['rows'] = $rows;
		}

		$info['success'] = true;

	}else
	if($_POST['data_type'] == 'load_all_stds')
	{
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		$query = "select * from std";
		$rows = query($query);

		if($rows){

			foreach ($rows as $key => $row) {
				
				$rows[$key]['std_img'] = get_std_img($row['std_img']);
			}
			
			$info['rows'] = $rows;
		}

		$info['success'] = true;

	}
	else
	if ($_POST['data_type'] == 'submit_periodResult') 
	{
		$firstDayLastPeriod = new DateTime($_POST['firstDayLastPeriod']);
		$periodLength = (int)$_POST['periodLength'];
		$cycleLength = (int)$_POST['cycleLength'];
		$numOfMonths = (int)$_POST['numOfMonths'];
		$addMonths = (int)$_POST['addMonths'];

		$startDateTime = clone $firstDayLastPeriod;
		$endDateTime = clone $startDateTime;
		//$endDateTime->add(new DateInterval('P3M'));
		$endDateTime->add(new DateInterval("P{$addMonths}M"));
		$periodDays = [];
		$ovulationDays = [];
		$currentDate = clone $startDateTime;

		while ($currentDate <= $endDateTime) {
			$periodStart = clone $currentDate;
			$periodEnd = clone $currentDate;
			$periodEnd->add(new DateInterval("P{$periodLength}D"))->sub(new DateInterval('P1D'));
			$periodDays[] = ['start' => $periodStart->format('Y-m-d'), 'end' => $periodEnd->format('Y-m-d')];
			$ovulationStart = clone $currentDate;
			$ovulationStart->add(new DateInterval("P{$cycleLength}D"))->sub(new DateInterval('P16D'));
			$ovulationEnd = clone $ovulationStart;
			$ovulationEnd->add(new DateInterval('P4D'));
			$ovulationDays[] = ['start' => $ovulationStart->format('Y-m-d'), 'end' => $ovulationEnd->format('Y-m-d')];
			$currentDate->add(new DateInterval("P{$cycleLength}D"));
		}
		
		// Assign generated calendar to rows key in info array
		$info['rows'] = period_calendar($startDateTime->format('n'),$startDateTime->format('Y'),$periodDays,$ovulationDays,$numOfMonths);
		$info['success'] = true;
	}else
	if ($_POST['data_type'] == 'load_method_info') 
	{
		$birth_control_id = (int)$_POST['birth_control_id'];

        $query = "select * from method_positive_effects where birth_control_id = '$birth_control_id'";
        $positive_rows = query($query);

        if ($positive_rows) {
          $info['positive_rows'] = $positive_rows;
          $info['positive_rows_success'] = true;
        }

        $query = "select * from method_negative_effects where birth_control_id = '$birth_control_id'";
        $negative_rows = query($query);

        if ($negative_rows) {
          $info['negative_rows'] = $negative_rows;
          $info['negative_rows_success'] = true;
        }

		$query = "select * from method_fyi where birth_control_id = '$birth_control_id'";
        $fyi_rows = query($query);

        if ($fyi_rows) {
          $info['fyi_rows'] = $fyi_rows;
          $info['fyi_rows_success'] = true;
        }
	}else
	if ($_POST['data_type'] == 'load_std_info') 
	{
		$std_id = $_POST['std_id'];

        $query = "select * from std_symptoms where std_id = '$std_id'";
        $symptoms_rows = query($query);

        if ($symptoms_rows) {
          $info['symptoms_rows'] = $symptoms_rows;
          $info['symptoms_rows_success'] = true;
        }

        $query = "select * from std_signs where std_id = '$std_id'";
        $signs_rows = query($query);

        if ($signs_rows) {
          $info['signs_rows'] = $signs_rows;
          $info['signs_rows_success'] = true;
        }

		$query = "select * from std_preventions where std_id = '$std_id'";
        $preventions_rows = query($query);

        if ($preventions_rows) {
          $info['preventions_rows'] = $preventions_rows;
          $info['preventions_rows_success'] = true;
        }
	}
	else
	if ($_POST['data_type'] == 'load_chart') 
	{
        $query = "select * from birth_controls_chart";
        $chart = query($query);

        if ($chart) {
			// Create a new array to hold the modified data
			$modifiedData = [];
	
			// Loop through the data and remove the underscores from the column names
			foreach ($chart as $row) {
				$modifiedRow = [];
				foreach ($row as $key => $value) {
					$newKey = str_replace('_', ' ', $key);
					$modifiedRow[$newKey] = $value;
				}
				$modifiedData[] = $modifiedRow;
			}
	
			// Set the modified data in the response
			$info['chart_data'] = $modifiedData;
			$info['success'] = true;
		}
	}else
	if ($_POST['data_type'] == 'load_sidebyside_data')
	{
		$birth_control_id = (int)$_POST['birth_control_id'];
		$query = "";

		if (empty($birth_control_id)) {
			$query = "SELECT * FROM birth_controls_sidebyside";
		} else {
			$query = "SELECT * FROM birth_controls_sidebyside WHERE birth_control_id = '$birth_control_id'";
		}

		$rows = query($query);
		
		$info = array();
		$info['columns'] = array();
		$info['rows'] = array();

		if ($rows) {

			foreach ($rows as $row) {
				$info['rows'][] = $row;
			}

			$info['columns'] = array_keys($info['rows'][0]);
			$info['success'] = true;
			// Exclude columns
			$columns_to_exclude = ['sidebyside_id', 'birth_control_id', 'birth_control_name', 'birth_control_icon'];
			foreach ($columns_to_exclude as $column_to_exclude) {
				if (($key = array_search($column_to_exclude, $info['columns'])) !== false) {
					unset($info['columns'][$key]);
				}
			}
		}
	}else
	if($_POST['data_type'] == 'add_video') //ito na yung sa post, naway makuha mo na lorent yung logic
	{
		$video_title = addslashes($_POST['video_title_input']);
		$video_desc = addslashes($_POST['video_desc_input']);
		$birth_control_id = (int)$_POST['selected_method'];
		$user_id = $_SESSION['USER']['user_id'];
		$partner_facility_id = $_POST['partner_facility_id'];
		//$anonymous = $_POST['anonymous'];
		
		/*if($anonymous == 'true'){
			$userfname = $_SESSION['USER']['user_fname'];
			$user_fname = substr($userfname, 0, 1) . str_repeat('*', strlen($userfname) - 2) . substr($userfname, -1);
			$user_img = 'assets/images/user.jpg?v1';
		}else{
			$user_fname = $_SESSION['USER']['user_fname'];
			$user_img = $_SESSION['USER']['user_image'];
		}*/

		$date = date("Y-m-d H:i:s");

		$video_name = $_FILES['user_video']['name'];
		$tmp_name = $_FILES['user_video']['tmp_name'];
    	$error = $_FILES['user_video']['error'];

		if ($error === 0) {
			$video_ex = pathinfo($video_name, PATHINFO_EXTENSION);
			//$info['message'] = $video_ex;
			$video_ex_lc = strtolower($video_ex);
	
			$allowed_exs = array("mp4", 'webm', 'avi', 'flv');
	
			if (in_array($video_ex_lc, $allowed_exs)) {
				
				$new_video_name = uniqid("video-", true). '.'.$video_ex_lc;
				$video_upload_path = 'uploads/'. $new_video_name;
				move_uploaded_file($tmp_name, $video_upload_path);
				
				$vdeoFilename = $video_upload_path;

				$query = "insert into videos (birth_control_id,user_id,partner_facility_id,video_timestamp,video,video_title,video_desc) 
				values ('$birth_control_id','$user_id','$partner_facility_id','$date','$vdeoFilename','$video_title','$video_desc')";
				query($query);

				/*$query = "select * from forum where user_id = '$user_id' order by forum_id desc limit 1";
				$row = query($query);
				
				if($row){

					$row = $row[0];
					$info['success'] = true;
					$info['message'] = "Your post was created successfully";
					$info['row'] = $row;
				}*///naka comment to

				$info['success'] = true;
				$info['message'] = "Your video was uploaded successfully";

			}else {
				$info['message'] = "You can't upload files of this type";
			}
		} else {
			// Error uploading file
			$info['message'] = "An error occurred while uploading the file";
		}
	}else
	if($_POST['data_type'] == 'load_videos')
	{
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		$category_id = (int)$_POST['category_id'];
		$start = $_POST['start'];
		$limit = $_POST['limit'];

		if ($category_id == 0) {
			$query = "select * from videos where comment_parent_id = 0 && reply_parent_id = 0 order by video_id desc limit $start, $limit";
		} else {
			$query = "select * from videos where comment_parent_id = 0 && reply_parent_id = 0 && birth_control_id = '$category_id' order by video_id desc limit $start, $limit";
		}

		//$query = "select * from videos where comment_parent_id = 0 && reply_parent_id = 0 order by video_id desc limit $start, $limit";
		
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s', strtotime($row['video_timestamp']));
				$rows[$key]['video_title'] = htmlspecialchars($row['video_title']);
				$rows[$key]['video_desc'] = nl2br(htmlspecialchars($row['video_desc']));
	
				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;
	
				$id = $row['partner_facility_id'];
				$query = "select * from partner_facility where partner_facility_id = '$id' limit 1";
				$user_row = query($query);

				if ($user_row) {
					$rows[$key]['partner_facility'] = $user_row[0];
					$rows[$key]['partner_facility']['logo'] = get_image($user_row[0]['facility_logo']);
					// Display the full name
					$rows[$key]['partner_facility']['location'] = $user_row[0]['city_municipality'];
					$rows[$key]['partner_facility']['name'] = $user_row[0]['health_facility_name'];
				}
				
				$birth_control_id = $row['birth_control_id'];
				$query = "select * from birth_controls where birth_control_id = '$birth_control_id' limit 1";
				$birth_control_row = query($query);
				
				if($birth_control_row){
					$rows[$key]['birth_control']['name'] = $birth_control_row[0]['birth_control_name'];
				}
				/*$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){
					$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
				}*/
	
				/*$forum_id = $row['forum_id'];
				$query = "select count(*) from rating_info where post_id = $forum_id AND rating_action = 'like' limit 1";
				$rating_row = query($query);
	
				if($rating_row){
					$rows[$key]['getlikes'] = $rating_row[0];
				}*/
				
			}
			
			// Check if there are more rows to load
			if ($category_id == 0) {
				$query = "select count(*) from videos where comment_parent_id = 0 && reply_parent_id = 0";
			} else {
				$query = "select count(*) from videos where comment_parent_id = 0 && reply_parent_id = 0 && birth_control_id = '$category_id'";
			}
			
			//$query = "select count(*) from videos where comment_parent_id = 0 && reply_parent_id = 0";
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
	if($_POST['data_type'] == 'add_video_comment') //ito na yung sa post, naway makuha mo na lorent yung logic
	{
		$video_id = (int)($_POST['video_id']);
		$comment = addslashes($_POST['comment']);
		$anonymous = $_POST['anonymous'];
		$user_id = $_SESSION['USER']['user_id'];

		if($anonymous == 'true'){
			//$userfname = $_SESSION['USER']['user_fname'];
			//$user_fname = substr($userfname, 0, 1) . str_repeat('*', strlen($userfname) - 2) . substr($userfname, -1);
			//$userimg = $_SESSION['USER']['user_image'];
			//$user_img = 'assets/images/user.jpg?v1';
			$anonimity = 1;
		}else{
			//$user_fname = $_SESSION['USER']['user_fname'];
			//$user_img = $_SESSION['USER']['user_image'];
			$anonimity = 0;
		}

		$date = date("Y-m-d H:i:s");
 
		// Add word filtering logic here
		if (containsProhibitedWord($comment)) {
			$info['success'] = false;
			$info['message'] = "Cannot post your comment because it contains prohibited words or phrases.";
		}
		else {
			$query = "insert into videos (user_id,video_timestamp,video_desc,comment_parent_id,comment_anonimity) values ('$user_id','$date','$comment','$video_id','$anonimity')";
			query($query);

			$query = "select * from videos where user_id = '$user_id' && comment_parent_id = '$video_id' order by video_id desc limit 1";
			$row = query($query);
			
			if($row){

				$row = $row[0];
				$info['success'] = true;
				$info['message'] = "Your comment was created successfully";
				$info['row'] = $row;
				
			}

			//count how many comments on this post
			$query = "select count(*) as num from videos where comment_parent_id = '$video_id'";
			$res = query($query);
			if($res){
				$num = $res[0]['num'];
				$query = "update videos set comment_count = '$num' where video_id = '$video_id' limit 1";
				query($query);
			}
		}
		

	}else
	if($_POST['data_type'] == 'load_video_comments')
	{
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		$video_id = (int)$_POST['video_id'];
	
		$query = "select * from videos where comment_parent_id = '$video_id' && reply_parent_id = 0 order by video_id desc";
		
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s',strtotime($row['video_timestamp']));
				$rows[$key]['video_desc'] = nl2br(htmlspecialchars($row['video_desc']));

				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;

				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){

					if ($row['comment_anonimity'] == 1) {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = "assets/images/user.jpg?v1";
						// Anonymize the user's name
						$fname = substr($user_row[0]['user_fname'], 0, 1) . str_repeat("*", strlen($user_row[0]['user_fname']) - 2) . substr($user_row[0]['user_fname'], -1);
						$lname = substr($user_row[0]['user_lname'], 0, 1) . ".";
						$rows[$key]['user']['name'] = "$fname $lname";
					} else {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
						// Display the full name
						$rows[$key]['user']['name'] = $user_row[0]['user_fname'] . " " . $user_row[0]['user_lname'];
					}
				}

				$video_id = $row['video_id'];
				$query = "select count(*) from rating_video where video_id = $video_id AND rating_action = 'like' limit 1";
				$rating_row = query($query);
	
				if($rating_row){
					$rows[$key]['getlikes'] = $rating_row[0];
				}
			}
			
			$info['rows'] = $rows;
		}

		$info['success'] = true;

	}else
	if($_POST['data_type'] == 'user_liked_video')
	{
		$video_id = (int)($_POST['video_id']);
		$user_id = $_SESSION['USER']['user_id'];
		
		$query = "select * from rating_video where user_id = '$user_id' and video_id = '$video_id' and rating_action = 'like' limit 1";		
		$rows = query($query);
		
		if ($rows) {
			$info['rows'] = $rows;
			$info['success'] = true;
		}
	}else
	if($_POST['data_type'] == 'add_like_video') //ito na yung sa post, naway makuha mo na lorent yung logic
	{
		$user_id = $_SESSION['USER']['user_id'];
		$video_id = (int)$_POST['video_id'];
		$action  = $_POST['action'];
 
		if ($action == 'like') {
			$query = "insert into rating_video (user_id,video_id,rating_action) values ('$user_id',$video_id,'like')
			on duplicate key update rating_action = 'like'";
			query($query);

		} elseif ($action == 'unlike') {
			$query = "delete from rating_video where user_id = '$user_id' AND video_id = '$video_id'";
			query($query);
		}

		$row = [];
		$likes_query = "select count(*) from rating_video where video_id = '$video_id' AND rating_action = 'like'";
		$likes = query($likes_query);

		if ($likes) {
			$row = ['likes' => $likes[0]];
			$info['row'] = $row;
			$info['success'] = true;
		}

	}else
	if($_POST['data_type'] == 'increment_views')
	{
		$video_id = (int)($_POST['video_id']);
		
		$query = "UPDATE videos SET view_count = view_count + 1 WHERE video_id = '$video_id'";
		$check = query($query);

		if ($check) {
			$info['success'] = true;
		}
		
	}else
	if($_POST['data_type'] == 'my_edit_comment_video') 
	{
		$edited_comment = addslashes($_POST['edited_comment']);
		$video_id = (int)($_POST['video_id']);
		$user_id = $_SESSION['USER']['user_id'];
		$date = date("Y-m-d H:i:s");
	
		// Add word filtering logic here
		if (containsProhibitedWord($edited_comment)) {
			$info['success'] = false;
			$info['message'] = "Cannot edit your comment because it contains prohibited words or phrases.";
		}
		else {
			$query = "update videos set video_desc = '$edited_comment', video_timestamp = '$date' where user_id = '$user_id' && video_id = '$video_id' limit 1";
			query($query);

			$info['success'] = true;
			$info['updated_date'] = date('Y-m-d\TH:i:s', strtotime($date));
			$info['message'] = "Your comment was edited successfully";
		}
		
		
	}else
	if($_POST['data_type'] == 'delete_comment_video')
	{
		$video_id = (int)($_POST['video_id']);
		$user_id = $_SESSION['USER']['user_id'];

		// Fetch comment_parent_id for the comment being deleted
		$query = "select comment_parent_id from videos where video_id = '$video_id' limit 1";
		$res = query($query);
		if($res){
			$comment_parent_id = $res[0]['comment_parent_id'];
		}
	
		$query = "delete from videos where video_id = '$video_id' && user_id = '$user_id' limit 1";
		query($query);
	
		$query = "select count(*) as num from videos where comment_parent_id = '$comment_parent_id'";
		$res = query($query);
		if($res){
			$num = $res[0]['num'];
			$query = "update videos set comment_count = '$num' where video_id = '$comment_parent_id' limit 1";
			query($query);
		}
	
		$info['success'] = true;
		$info['message'] = "Your comment was deleted successfully";

	}else
	if($_POST['data_type'] == 'get_replies_video') 
	{ 
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		$video_id = (int)$_POST['video_id'];
		$query = "SELECT * FROM videos WHERE reply_parent_id = '$video_id' ORDER BY video_id DESC";
		$rows = query($query);
		
		if ($rows) {
			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s', strtotime($row['video_timestamp']));
				$rows[$key]['video_desc'] = nl2br(htmlspecialchars($row['video_desc']));
				
				$rows[$key]['user_owns'] = false;
				if ($user_id == $row['user_id']) {
					$rows[$key]['user_owns'] = true;
				}

				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){

					if ($row['reply_anonimity'] == 1) {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = "assets/images/user.jpg?v1";
						// Anonymize the user's name
						$fname = substr($user_row[0]['user_fname'], 0, 1) . str_repeat("*", strlen($user_row[0]['user_fname']) - 2) . substr($user_row[0]['user_fname'], -1);
						$lname = substr($user_row[0]['user_lname'], 0, 1) . ".";
						$rows[$key]['user']['name'] = "$fname $lname";
					} else {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
						// Display the full name
						$rows[$key]['user']['name'] = $user_row[0]['user_fname'] . " " . $user_row[0]['user_lname'];
					}
				}

				$video_id = $row['video_id'];
				$query = "select count(*) from rating_video where video_id = $video_id AND rating_action = 'like' limit 1";
				$rating_row = query($query);
	
				if($rating_row){
					$rows[$key]['getlikes'] = $rating_row[0];
				}
			}
			$info['rows'] = $rows;
		}
		$info['success'] = true;

	}else
	if($_POST['data_type'] == 'add_reply_video') 
	{
		$video_id = (int)$_POST['video_id'];
		$reply_text = addslashes($_POST['reply_text']);
		$anonymous = $_POST['anonymous'];
		$user_id = $_SESSION['USER']['user_id'];

		if($anonymous == 'true'){
			//$userfname = $_SESSION['USER']['user_fname'];
			//$user_fname = substr($userfname, 0, 1) . str_repeat('*', strlen($userfname) - 2) . substr($userfname, -1);
			//$userimg = $_SESSION['USER']['user_image'];
			//$user_img = 'assets/images/user.jpg?v1';
			$anonimity = 1;
		}else{
			//$user_fname = $_SESSION['USER']['user_fname'];
			//$user_img = $_SESSION['USER']['user_image'];
			$anonimity = 0;
		}

		$date = date("Y-m-d H:i:s");

		// Add word filtering logic here
		if (containsProhibitedWord($reply_text)) {
			$info['success'] = false;
			$info['message'] = "Cannot post your reply because it contains prohibited words or phrases.";
		}
		else{

			// Insert new row into forum table with comment_parent_id set to video_id
			$query = "INSERT INTO videos (user_id, video_timestamp, video_desc, reply_parent_id, reply_anonimity) VALUES ('$user_id', '$date', '$reply_text', '$video_id', '$anonimity')";
			query($query);
			
			// Return success message and data for new reply
			$query = "SELECT * FROM videos WHERE user_id = '$user_id' AND reply_parent_id = '$video_id' ORDER BY video_id DESC LIMIT 1";
			$row = query($query);
			if ($row) {
				$row = $row[0];
				$info['success'] = true;
				$info['message'] = "Your reply was added successfully";
				$info['row'] = $row;
			}

			//count how many reply on this post
			$query = "select count(*) as num from videos where reply_parent_id = '$video_id'";
			$res = query($query);
			if($res){
				$num = $res[0]['num'];
				$query = "update videos set reply_count = '$num' where video_id = '$video_id' limit 1";
				query($query);
			}
		}
	}else
	if($_POST['data_type'] == 'my_edit_reply_video') 
	{
		$edited_reply_text = addslashes($_POST['edited_reply_text']);
		$video_id = (int)($_POST['video_id']);
		$user_id = $_SESSION['USER']['user_id'];
		$date = date("Y-m-d H:i:s");
	
		// Add word filtering logic here
		if (containsProhibitedWord($edited_reply_text)) {
			$info['success'] = false;
			$info['message'] = "Cannot edit your reply because it contains prohibited words or phrases.";
		}
		else{
		$query = "update videos set video_desc = '$edited_reply_text', video_timestamp = '$date' where user_id = '$user_id' && video_id = '$video_id' limit 1";
		$info['message'] = "Your reply was edited successfully";
		$info['updated_date'] = date('Y-m-d\TH:i:s', strtotime($date));
		
		query($query);
		$info['success'] = true;
		}
	}else
	if($_POST['data_type'] == 'delete_reply_video') //ito na yung sa post, naway makuha mo na lorent yung logic
	{
		$video_id = (int)($_POST['video_id']);
		$user_id = $_SESSION['USER']['user_id'];

		$query = "select reply_parent_id from videos where video_id = '$video_id' limit 1";
		$res = query($query);
		if($res){
			$reply_parent_id = $res[0]['reply_parent_id'];
		}
	
		$query = "delete from videos where video_id = '$video_id' && user_id = '$user_id' limit 1";
		query($query);

		$query = "select count(*) as num from videos where reply_parent_id = '$reply_parent_id'";
		$res = query($query);
		if($res){
			$num = $res[0]['num'];
			$query = "update videos set reply_count = '$num' where video_id = '$reply_parent_id' limit 1";
			query($query);
		}
		
		$info['success'] = true;
		$info['message'] = "Your reply was deleted successfully";
	}else
	if($_POST['data_type'] == 'load_my_videos') 
	{
		//$user_id = $_SESSION['USER']['user_id'] ?? 0;
		$partner_facility_id = $_POST['partner_facility_id'];
		//$partner_facility_id = $_SESSION['USER']['partner_facility_id'];
		
		$query = "select * from videos where partner_facility_id = $partner_facility_id && comment_parent_id = 0 && reply_parent_id = 0 order by video_id desc";
		$rows = query($query);
		
		if($rows){
			foreach ($rows as $key => $row) {

				$rows[$key]['video'] = "../" . $row['video'];
				$datetime = new DateTime($row['video_timestamp']);
				$date = $datetime->format('m-d-Y');
				$rows[$key]['date'] = $date;

				$video_id = $row['video_id'];
				$query = "select count(*) from rating_video where video_id = $video_id AND rating_action = 'like' limit 1";
				$rating_row = query($query);
	
				if($rating_row){
					$rows[$key]['getlikes'] = $rating_row[0];
				}

				$birth_control_id = $row['birth_control_id'];
				$query = "select * from birth_controls where birth_control_id = '$birth_control_id' limit 1";
				$birth_control_row = query($query);
				
				if($birth_control_row){
					$rows[$key]['birth_control']['name'] = $birth_control_row[0]['birth_control_name'];
				}
			}
			$info['rows'] = $rows;
			$info['success'] = true;
		}
	}else
	if($_POST['data_type'] == 'edit_video_details') 
	{
		$partner_facility_id = $_POST['partner_facility_id'];
		$video_id = (int)($_POST['video_id']);
		$edited_title = addslashes($_POST['edited_title']);
		$edited_desc = addslashes($_POST['edited_desc']);
		$birth_control_id = (int)$_POST['birth_control_id'];
		//$user_id = $_SESSION['USER']['user_id'];
		//$date = date("Y-m-d H:i:s");
		
		$query = "update videos set video_desc = '$edited_desc', video_title = '$edited_title', birth_control_id = '$birth_control_id' where partner_facility_id = '$partner_facility_id' && video_id = '$video_id' limit 1";
		query($query);

		$info['success'] = true;
		//$info['updated_date'] = date('Y-m-d\TH:i:s', strtotime($date));
		$info['message'] = "Your video details was edited successfully";
		
	}else
	if($_POST['data_type'] == 'delete_video') //ito na yung sa post, naway makuha mo na lorent yung logic
	{
		$ids = json_decode($_POST['ids']);

		foreach ($ids as $id) {
			$id = (string)$id;
			$query = "delete from videos where video_id = '$id' LIMIT 1";
			query($query);
		}

		$info['success'] = true;
		$info['message'] = "Video/s deleted successfully";

	}else
	if($_POST['data_type'] == 'search_videos')
	{
		$user_id = $_SESSION['USER']['user_id'] ?? 0;
		//$start = $_POST['start'];
		//$limit = $_POST['limit'];
		$query = $_POST['query'] ?? '';
		//$posts = [];
		
		$query = "SELECT * FROM videos WHERE (video_title LIKE '%$query%') AND comment_parent_id = 0 AND reply_parent_id = 0 ORDER BY video_id DESC";
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s', strtotime($row['video_timestamp']));
				$rows[$key]['video_title'] = htmlspecialchars($row['video_title']);
				$rows[$key]['video_desc'] = nl2br(htmlspecialchars($row['video_desc']));
	
				$rows[$key]['user_owns'] = false;
				if($user_id == $row['user_id'])
					$rows[$key]['user_owns'] = true;
	
				$id = $row['partner_facility_id'];
				$query = "select * from partner_facility where partner_facility_id = '$id' limit 1";
				$user_row = query($query);

				if ($user_row) {
					$rows[$key]['partner_facility'] = $user_row[0];
					$rows[$key]['partner_facility']['logo'] = get_image($user_row[0]['facility_logo']);
					// Display the full name
					$rows[$key]['partner_facility']['location'] = $user_row[0]['city_municipality'];
					$rows[$key]['partner_facility']['name'] = $user_row[0]['health_facility_name'];
				}
				
				$birth_control_id = $row['birth_control_id'];
				$query = "select * from birth_controls where birth_control_id = '$birth_control_id' limit 1";
				$birth_control_row = query($query);
				
				if($birth_control_row){
					$rows[$key]['birth_control']['name'] = $birth_control_row[0]['birth_control_name'];
				}
			}

			$info['rows'] = $rows;
			
			$info['success'] = true;
		}
	}else
	if($_POST['data_type'] == 'load_forum_carousel') //Initial work done
	{

		$query = "SELECT forum.*, COUNT(rating_info.user_id) AS likes_count FROM forum JOIN 
		rating_info ON forum.forum_id = rating_info.post_id WHERE forum.comment_parent_id = 0 
		AND forum.reply_parent_id = 0 GROUP BY forum.forum_id ORDER BY likes_count DESC LIMIT 5";
		
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s', strtotime($row['forum_timestamp']));
				$rows[$key]['forum_desc'] = nl2br(htmlspecialchars($row['forum_desc']));
				//$rows[$key]['user_img'] = get_image($row['user_img']);

				$id = $row['user_id'];
				$query = "select * from users where user_id = '$id' limit 1";
				$user_row = query($query);
				
				if($user_row){

					if ($row['forum_anonimity'] == 1) {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = "assets/images/user.jpg?v1";
						// Anonymize the user's name
						$fname = substr($user_row[0]['user_fname'], 0, 1) . str_repeat("*", strlen($user_row[0]['user_fname']) - 2) . substr($user_row[0]['user_fname'], -1);
						$lname = substr($user_row[0]['user_lname'], 0, 1) . ".";
						$rows[$key]['user']['name'] = "$fname $lname";
					} else {
						$rows[$key]['user'] = $user_row[0];
						$rows[$key]['user']['image'] = get_image($user_row[0]['user_image']);
						// Display the full name
						$rows[$key]['user']['name'] = $user_row[0]['user_fname'] . " " . $user_row[0]['user_lname'];
					}
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
	if($_POST['data_type'] == 'load_most_viewed_video') //Initial work done
	{

		$query = "SELECT * FROM videos ORDER BY view_count DESC LIMIT 3";
		
		$rows = query($query);
		
		if($rows){

			foreach ($rows as $key => $row) {
				$rows[$key]['date'] = date('Y-m-d\TH:i:s', strtotime($row['video_timestamp']));
				$rows[$key]['video_title'] = htmlspecialchars($row['video_title']);
				$rows[$key]['video_desc'] = nl2br(htmlspecialchars($row['video_desc']));

				$id = $row['partner_facility_id'];
				$query = "select * from partner_facility where partner_facility_id = '$id' limit 1";
				$user_row = query($query);

				if ($user_row) {
					$rows[$key]['partner_facility'] = $user_row[0];
					$rows[$key]['partner_facility']['logo'] = get_image($user_row[0]['facility_logo']);
					// Display the full name
					$rows[$key]['partner_facility']['location'] = $user_row[0]['city_municipality'];
					$rows[$key]['partner_facility']['name'] = $user_row[0]['health_facility_name'];
				}
	
				$birth_control_id = $row['birth_control_id'];
				$query = "select * from birth_controls where birth_control_id = '$birth_control_id' limit 1";
				$birth_control_row = query($query);
				
				if($birth_control_row){
					$rows[$key]['birth_control']['name'] = $birth_control_row[0]['birth_control_name'];
				}
				
			}
	
			// Return rows
			$info['rows'] = $rows;
		}
		 // Return success status
		$info['success'] = true;

	}else
	if($_POST['data_type'] == 'load_city_municipalities')
	{
		$query = "select * from partner_facility";
		$rows = query($query);
		$info['rows'] = $rows;
		$info['success'] = true;

	}else
	if($_POST['data_type'] == 'load_health_facilities')
	{
		$city_municipality = $_POST['city_municipality'];

		$query = "select * from partner_facility where city_municipality = '$city_municipality'";
		$rows = query($query);

		if ($rows) {
			$info['rows'] = $rows;
			$info['success'] = true;
		}
		

	}else
	if($_POST['data_type'] == 'add_appointment')
	{
		$fname = addslashes($_POST['fname']);
		$lname = addslashes($_POST['lname']);
        $address = addslashes($_POST['address']);
        $email = addslashes($_POST['email']);
        $municipality = addslashes($_POST['selected_municipality']);
		$health_facility = addslashes($_POST['selected_health_facility']);
        $contact = (int)($_POST['contact']);
        $gender = $_POST['selected_gender'];
        $dob = $_POST['dob'];
        $appointment_date = $_POST['appointment_date'];
        $appointment_timeslot = $_POST['appointment_timeslot'];
		$appointment_data_privacy = $_POST['appointment_data_privacy'];

		// Check if contact number already exists
		$checkQuery = "SELECT * FROM appointments WHERE app_pnum = '$contact'";
		$result = query($checkQuery);

		if($result){
			$info['message'] = "Your contact number already exists.";
		} else {
			// Insert the new record
			$query = "INSERT INTO appointments (app_fname,app_lname,app_address,app_email,city_municipality,health_facility,app_pnum,app_gender,app_bdate,app_date,app_timeslot,appointment_data_privacy) 
			VALUES ('$fname','$lname','$address','$email','$municipality','$health_facility','$contact','$gender','$dob','$appointment_date','$appointment_timeslot','$appointment_data_privacy')";
			query($query);

			appointment_confirmation($contact, $fname, $municipality, $health_facility, $appointment_date, $appointment_timeslot);

			$info['success'] = true;
			$info['message'] = "Your appointment was successfully created";
		}
	}else
	if($_POST['data_type'] == 'check_contact_number')
	{
		$contact = (int)($_POST['contact_number']);
		
		// Check if contact number already exists
		$checkQuery = "SELECT * FROM appointments WHERE app_pnum = '$contact'";
		$result = query($checkQuery);

		if($result){
			$info['message'] = "Your contact number already exists.";
			$info['success'] = true;
		}

	}else 
	if($_POST['data_type'] == 'delete_method')
	{
		$user_id = $_SESSION['USER']['user_id'];
 
		//si limit 1 is parang pag may nakita na syang match sa data, iistop na sya
		//para rin tipid sa memory
		$query = "UPDATE users SET birth_control_name = NULL, birth_control_startdate = NULL, birth_control_enddate = NULL, birth_control_usage = NULL, isMessaged = NULL WHERE user_id = '$user_id'";
		query($query);
		
		$info['success'] = true;
		$info['message'] = "The old saved method has been deleted successfully";
		
	}else 
	if($_POST['data_type'] == 'delete_remdates')
	{
		$user_id = $_SESSION['USER']['user_id'];
 
		//si limit 1 is parang pag may nakita na syang match sa data, iistop na sya
		//para rin tipid sa memory
		$query = "UPDATE users SET birth_control_name = NULL, birth_control_startdate = NULL, birth_control_enddate = NULL, birth_control_usage = NULL, isMessaged = NULL WHERE user_id = '$user_id'";
		query($query);

		$query2 = "delete from reminder WHERE user_id = '$user_id'";
		query($query2);
		
		$info['success'] = true;
		$info['message'] = "The old saved method has been deleted successfully";
	}
	
}
// kinoconvert to json string si "$info", nag ooutput to ng variable $info
echo json_encode($info);
