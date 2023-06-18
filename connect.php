
<?php 

    define('APP', 'Forum');
    $conn=mysqli_connect('localhost','root','','sipa_db', 3307);

    date_default_timezone_set('Asia/Manila');

    if(!$conn){
		echo "Could not connect!".mysqli_error();
	}
?>
