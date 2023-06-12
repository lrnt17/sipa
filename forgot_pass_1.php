<?php include("connect.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | SiPa</title>
    <style>
   .skiptranslate iframe  {
    visibility: hidden !important;
    } 
    body{
    top:0!important;
    
}</style>
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
            <div id="reg_block">
                <h1>Forgot Password?</h1>
                <p id="sub">Enter your phone number and we will send you a code to reset your password <br><br>
                You will recieve instructions for resetting your password.</p>
                <form action="forgot_pass_1.php" method="post">
                    <div class="form">
                        <input type="text" name="pnum" id="pnum" required>
                        <label for="pnum">Phone number</label>
                    </div>
                    <input type="submit" value="Send code" name="submit">
                    <a href="#.php" id="cancel">Cancel</a>
                </form>
            </div>

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
            
            <!--<div class="dropdown">
                <form action="#">
                    <label for="cars">Language: </label>
                    <select id="language">
                        <option value="1" selected="selected">English</option>
                        <option value="2">Tagalog</option>
                    </select>
                </form>
            </div>-->
            <a href="">Privacy Policy</a>
            <a href="">Terms of Use</a>
        </div>
    </div>
</body>
</html>

<?php 
    if (isset($_POST["submit"])) {
        $_SESSION["pnum"] = $_POST['pnum'];

    echo "<script>
            window.location.href='forgot_pass_2_send.php';
            </script>";
    }
?>
