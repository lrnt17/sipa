<?php 
    session_start(); 

    $_SESSION["fname"] = $_SESSION['fname'];
    $_SESSION["lname"] = $_SESSION['lname'];
    $_SESSION["email"] = $_SESSION["email"];
    $_SESSION["pnum"] = $_SESSION['pnum'];
    $_SESSION["pass"] = $_SESSION['pass'];
    $_SESSION["terms_conditions"] = $_SESSION['terms_conditions'];
    $_SESSION["privacy_policy"] = $_SESSION['privacy_policy']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPa | Verification</title>
</head>
<body>
    <div class="parent">

        <div id="reg_block">
            <h1>Verification.</h1>
            <p id="sub">Please enter the verification code we sent to your
            <br>email address.</p>
            <form action="registration_3_completed.php" method="post">
                <div class="form">
                    <input type="text" name="code" id="code">
                    <label for="code">Verification Code</label>
                </div>
                <input type="submit" value="Verify" name="verify">
                <a href="#.html" id="cancel">Cancel</a>
            </form>
            <p id="didnt_recieve_code">Didn't recieve the code? <a href="http://"><u>Resend</u></a></p>
        </div>

    </div>
</body>
</html>