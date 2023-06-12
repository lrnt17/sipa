//comment
<?php 

    $conn=mysqli_connect('localhost','root','','sipa_db', 3307);

    if(!$conn){
		echo "Could not connect!".mysqli_error();
	}

    session_start();
?>
