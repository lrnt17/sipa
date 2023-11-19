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
    <script>
        function check() {
            let code = document.getElementById('code').value;

            if (!/^\d+$/.test(code)) {
                alert('Verification code should only contain numbers');
                return false;
            }
        }
    </script>
        <style>
        .header-text{
        font-size: 35px;
        color:#FFFFFF;
        font-weight: 300;
        margin-top: 25px;
        }

        .header-text2{
            font-size: 35px;
            color:#FFFFFF;
            margin-top: -40px;
            font-weight: 400;
        }

         @media (max-width: 1225px) {
        .reco-pass{
        margin: 0;
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 303px !important;
        min-height: auto;
        }

        .header-text2{
            text-align: center;
            font-size: 25px !important; 
            margin-top: -23px !important;
        }

        .header-text{
            margin-top: 0px !important;
            text-align: center;
            font-size: 22px !important;
        }

        .info-text{
            display:none;
        }
}
@media (max-width: 450px) {
            .header-text2 {
                text-align: center;
                font-size: 23px !important;
                margin-top: -22px !important;
            }
        }
    </style>
</head>
<body>

    <header>
        <a href="#"><img class="logo" src="logo-fill.png" alt="logo"></a>
    </header>

    <div class="parent">
        <!-- 1st child div -->
        <div class = "container">
            <img class="doctor" src="doctora.png" alt="" style="height: 400px; padding-left: 20px !important;"><!-- background photo-->
            <div class = "text"><!-- texts -->
                <p class = "header-text">Welcome back to</p>
                <p class = "header-text2">SiPa Siguradong Pagpaplano</p>
                <p class = "info-text">Find out your top contraceptive methods.</p>
            </div>
        </div>

        <!-- 2nd child div -->
        <div class="container-box">
            <div class="reco-pass">
                <h1>Password Recovery?</h1>
                <p class="text-rem" id="sub">An SMS message with a verification code was just sent to your number</p></br><br>

                <form action="forgot_pass_4_reset_pass.php" method="post" onsubmit="return check(event);">
                    <div class="form">
                    <div class="fonticon">
                            <i class="fa-sharp fa-solid fa-shield-halved" style="font-size:15px;"></i>
                            <label for="code">Verification code</label>
                            <input type="text" name="code" id="code" minlength="6" maxlength="6" required>
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

