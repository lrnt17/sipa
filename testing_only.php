<?php

/*function generateAccessCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $accessCode = '';

    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $accessCode .= $characters[random_int(0, $max)];
    }

    $accessCode = strtoupper($accessCode); // Convert letters to uppercase

    return $accessCode;
}
$verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
// Example usage:
$accessCode = generateAccessCode();
echo $verification_code;*/


/*$post_id = $_GET['id'] ?? 0;
$info['message'] = "this is the content for post with ID: " . $post_id;
echo json_encode($info);*/
?>

<!--<!DOCTYPE html>
<html>
<head>
  <title>Signup Form</title>
  Additional CSS or JavaScript
</head>
<body>
  <h2>Signup Form</h2>
  <form action="process_signup.php" method="POST">
    Form fields and other elements
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input type="email" name="email" placeholder="Email">
    <button type="submit">Sign up</button>
  </form>
</body>
</html>-->

<?php //include('server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Like and Dislike system</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="main.css">
</head>
<body>
  <div class="posts-wrapper">
   <?php //foreach ($posts as $post): ?>
   	<div class="post">
      <?php //echo $post['text']; ?>
      <div class="post-info">
	    <!-- if user likes post, style button differently -->
      	<i <?php //if(userLiked($post['id'])): ?>
      		  class="fa fa-thumbs-up like-btn"
      	  <?php //else: ?>
      		  class="fa fa-thumbs-o-up like-btn"
      	  <?php //endif ?>
      	  data-id="<?php //echo $post['id'] ?>"></i>
      	<span class="likes"><?php //echo getLikes($post['id']); ?></span>
      	
      	&nbsp;&nbsp;&nbsp;&nbsp;

	    <!-- if user dislikes post, style button differently -->
      	<i 
      	  <?php //if //(userDisliked($post['id'])): ?>
      		  class="fa fa-thumbs-down dislike-btn"
      	  <?php //else: ?>
      		  class="fa fa-thumbs-o-down dislike-btn"
      	  <?php //endif ?>
      	  data-id="<?php //echo $post['id'] ?>"></i>
      	<span class="dislikes"><?php //echo getDislikes($post['id']); ?></span>
      </div>
   	</div>
   <?php //endforeach ?>
  </div>
  <script src="scripts.js"></script>
</body>
</html>
