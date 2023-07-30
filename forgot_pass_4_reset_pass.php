<?php 

    include("connect.php");
    session_start();
    $_SESSION["pnum"] = $_SESSION["pnum"];

    if (isset($_POST["verify"]))
    {
        $verification_code = $_POST["code"];

        // mark email as verified
        $sql = "UPDATE verification_codes SET pnum_verified_at = NOW() WHERE user_pnum = '" . $_SESSION["pnum"] . "' AND verification_code = '" . $verification_code . "'";
        $result  = mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) == 0)
        {
            echo "<script>
                    alert('Your validation code is invalid. Please try again.');
                    window.location.href='forgot_pass_3_recovery.php';
                </script>";
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/forms_2.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>Create New Password | SiPa</title>
    <script>
        function check() {
            var newpass = document.getElementById('new_pass').value;
            var conpass = document.getElementById('con_pass').value;

            if (newpass!=conpass) {
                alert("Your password are not match. Please try again.");
                return false;
            }
        }
    </script>
</head>
<body>

    <header>
        <a href="#"><img class="logo" src="logo1.png" alt="logo"></a>
    </header>

    <div class="parent">
        <!-- 1st child div -->
        <div class = "container">
            <img class="doctor" src="doctor.png" alt=""><!-- background photo-->
            <div class = "text"><!-- texts -->
                <p class = "header-text">Welcome back to</p>
                <p class = "header-text2">SiPa Siguradong Pagpipilian</p>
                <p class = "info-text">Find out your top contraceptive methods.</p>
            </div>
        </div>

        <!-- 2nd child div -->
        <div class="container-box">
            <div class="reset-pass">
                <h1>Create New Password</h1>
                <p class="text-rem">Your password must be different from previously used password.</p>
                <p class="text-rem">Strong password includes numbers, letters, and punctuation marks.</p><br>
                <form action="forgot_pass_5_reset_success.php" method="post" onsubmit="return check(event);">
                    <div class="form">
                        <div class="fonticon">
                            <i class="fa-solid fa-lock" style="font-size:15px;"></i>
                            <label for="new_pass">New password</label>
                            <input type="password" name="new_pass" id="new_pass" required>
                        </div>
                    </div>
                    <div class="form">
                        <div class="fonticon">
                            <i class="fa-solid fa-lock" style="font-size:15px;"></i>
                            <label for="con_pass">Confirm new password</label>
                            <input type="password" name="con_pass" id="con_pass" required>
                        </div>
                    </div>
                    <button type="submit" name="reset" class="class_60 log-btn">Verify Code</button>
                </form>
            </div>

            
        </div>
    </div>
    <!-- language, privacy policy, terms of use -->
    <div class="lang-box">
        <?php include('languageprivacyterms.php') ?>
    </div>
</body>
</html>



<?php 
    }
?>
