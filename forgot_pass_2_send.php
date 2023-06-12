<?php 

    include("connect.php");
    $_SESSION["pnum"] = $_SESSION['pnum'];
    $pnum = $_SESSION["pnum"];

    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

    $ch = curl_init();
    $parameters = array(
        'apikey' => 'c17f81a2eb07d0ad839118cad67d2c55', //Your API KEY
        'number' => $pnum,
        'message' => 'To change password, use this key for confirmation: ' . $verification_code,
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
    
    // insert in users table
    $sql = "INSERT INTO verification_codes(user_pnum, verification_code, pnum_verified_at) VALUES ('" . $_SESSION["pnum"] . "', '" . $verification_code . "', NULL)";
    mysqli_query($conn, $sql);
    
    echo "<script>
            window.location.href='forgot_pass_3_recovery.php';
          </script>";

?>