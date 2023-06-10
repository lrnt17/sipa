<?php 

    // connect with database
    include("connect.php");

    function generateAccessCode($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $accessCode = '';
    
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $accessCode .= $characters[random_int(0, $max)];
        }
    
        $accessCode = strtoupper($accessCode); // Convert letters to uppercase
    
        return $accessCode;
    }
    
    // Example usage:
    $accessCode = generateAccessCode();

    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $email = $_SESSION["email"];
    $pnum = $_SESSION['pnum'];
    $pass = $_SESSION['pass'];
    $terms_conditions = $_SESSION['terms_conditions'];
    $privacy_policy = $_SESSION['privacy_policy']; 

    if (isset($_POST["verify"])) {

        $verification_code = $_POST["code"];
 
        // mark pnum as verified
        $sql = "UPDATE verification_codes SET pnum_verified_at = NOW() WHERE user_pnum = '" . $pnum . "' AND verification_code = '" . $verification_code . "'";
        $result  = mysqli_query($conn, $sql);
 
        if (mysqli_affected_rows($conn) == 0)
        {
            echo "<script>
                    alert('Your validation code is invalid. Please try again.');
                    window.history.back();
                  </script>";
            exit();
        } else {

            //THE ENCRYPTION PROCESS
            //$pass_encrypted=encryptthis($pass, $key);

            //THE DECRYPTION PROCESS
            //$pass_decrypted=decryptthis($pass_encrypted, $key);

            if($conn->connect_error){
                //echo "$conn->connect_error";
                die("Connection Failed : ".$conn->connect_error);

            } else {
            $stmt = $conn->prepare("insert into users(user_fname, user_lname, user_email, user_pnum, terms_conditions, privacy_policy, access_code, user_password) values(?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $fname, $lname, $email, $pnum, $terms_conditions, $privacy_policy, $accessCode, $pass);
            $stmt->execute();
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPa | Registration Completed</title>
</head>
<body>
    <div class="parent">

        <div class="child">
            <div class="reg_block">
                <h1>Sign up completed!</h1>
                <p id="sub">Congratulations! Your account is successfully registered.</p>
                <p>Here is your acess code: <?php echo $accessCode ?></p>
                <a href="login_1.php">Ok</a>
            </div>
        </div>

    </div>
</body>
</html>

<?php
            exit();
            $stmt->close();
            $conn->close();
            session_unset();
            session_destroy();
        }
    }
?>