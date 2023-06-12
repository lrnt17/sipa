<?php 

    include("connect.php"); 

    $_SESSION["pnum"] = $_SESSION["pnum"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery | SiPa</title>
</head>
<body>
    <div class="parent">
        <!-- 1st child div -->
        <div>
            <img src="" alt=""><!-- background photo-->
            <img src="" alt=""><!-- logo -->
            <div><!-- texts -->
                <p>Welcome back to</p>
                <h2>SiPa</h2>
                <p>Find out your top contraceptive methods.</p>
            </div>
        </div>

        <!-- 2nd child div -->
        <div class="child">
            <h1>Password Recovery?</h1>
            <p id="sub">An SMS message with verification code was just sent to your number</p>

            <form action="forgot_pass_4_reset_pass.php" method="post">
                <div class="form">
                    <input type="text" name="code" id="code" required>
                    <label for="code">Verification code</label>
                </div>
                <input type="submit" value="Verify code" name="verify" required>
                <a href="#.php" id="cancel">Back to Forget Password</a>
            </form>

            <p id="didnt_recieve_email">Didn't recieve the verification code? <a href="forgot_pass_2_send.php"><u>Resend</u></a></p>
            
            <!-- language -->
            <span>
                <div class="translate" id="google_translate_element"></div>
               <script type="text/javascript">
                        function googleTranslateElementInit() {
                        new google.translate.TranslateElement({
                            pageLanguage: 'en',
                            includedLanguages: 'en,tl',
                            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                            autoDisplay: false,
                            multilanguagePage: true
                        }, 'google_translate_element');
                        }
                    </script>
                    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            </span>
            <a href="">Privacy Policy</a>
            <a href="">Terms of Use</a>
        </div>
    </div>
</body>
</html>
