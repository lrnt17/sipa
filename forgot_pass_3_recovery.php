<?php 

    include("connect.php");
    session_start(); 

    $_SESSION["pnum"] = $_SESSION["pnum"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/forms.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>Password Recovery | SiPa</title>
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
            <div class="reco-pass">
                <h1>Password Recovery?</h1>
                <p class="text-rem" id="sub">An SMS message with a verification code was just sent to your number</p></br><br>

                <form action="forgot_pass_4_reset_pass.php" method="post">
                    <div class="form">
                    <div class="fonticon">
                            <i class="fa-sharp fa-solid fa-shield-halved" style="font-size:15px;"></i>
                            <label for="code">Verification code</label>
                            <input type="text" name="code" id="code" required>
                        </div>
                    </div>
                    <button type="submit" name="verify" class="class_60 log-btn" value="Verify code">Verify Code</button>
                    <div class="fonticon">
                        <i class="fa-solid fa-angle-left" style="font-size:15px;"></i>
                        <a href="forgot_pass_1.php" id="cancel" class="a-cancel2">Back to Forget Password</a>
                    </div>
                </form>
                <div class="text-cont">
                    <div class="lines2">
                        <p class="didnt-recieve" id="didnt_recieve_email">Didn't receive the verification code? <a href="forgot_pass_2_send.php" class="a-resend">Resend</a></p>
                    </div>
                </div>
            </div>
               
            
            
        </div>
    </div>
    <!-- language, privacy policy, terms of use -->
    <div class="lang-box">
        <?php include('languageprivacyterms.php') ?>
    </div>
</body>
</html>

